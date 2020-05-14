<?php

namespace App\Http\Controllers;

use App\Link;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use Browser;

class LinkController extends Controller
{
    public function DetectDomainTld ($domain) {

        // detect last slashes
        $dotPos = (strpos($domain, 'www.') == false) ? strpos($domain, '.') : strpos($domain, '.', strpos($domain, '.')) ;

        // return $dotPos;
        $lastSlashPos = strpos($domain, '/', $dotPos);

        //removed slashes and another routes after tld --> [arbazargani.ir]
        $step = ($lastSlashPos == false) ? $domain : substr($domain, 0, $lastSlashPos);

        //detect exact tld
        $tld = strrev(substr(strrev($step), 0, strpos(strrev($step), '.')));

        return $tld;
    }

    public function GetRealAgent() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$content_nav['name'] = 'Unknown';

		if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) {

			$content_nav['name'] = 'Opera';

			if (strpos($user_agent, 'OPR/')) {
				$content_nav['reel_name'] = 'OPR/';
			} else {
				$content_nav['reel_name'] = 'Opera';
			}

		} elseif (strpos($user_agent, 'Edge')) {
			$content_nav['name'] = $content_nav['reel_name'] = 'Edge';
		} elseif (strpos($user_agent, 'Chrome')) $content_nav['name'] = $content_nav['reel_name'] = 'Chrome';
		elseif (strpos($user_agent, 'Safari')) $content_nav['name'] = $content_nav['reel_name'] = 'Safari';
		elseif (strpos($user_agent, 'Firefox')) $content_nav['name'] = $content_nav['reel_name'] = 'Firefox';
		elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7') || strpos($user_agent, 'Trident/7.0; rv:')) {
			$content_nav['name'] = 'Internet Explorer';

			if (strpos($user_agent, 'Trident/7.0; rv:')) {
				$content_nav['reel_name'] = 'Trident/7.0; rv:';
			} elseif (strpos($user_agent, 'Trident/7')) {
				$content_nav['reel_name'] = 'Trident/7';
			} else {
				$content_nav['reel_name'] = 'Opera';
			}

		}

		$pattern = '#' . $content_nav['reel_name'] . '\/*([0-9\.]*)#';

		$matches = array();

		if (preg_match($pattern, $user_agent, $matches)) {

			$content_nav['version'] = $matches[1];
			return $content_nav;
		}

		return array('name' => $content_nav['name'], 'version' => 'Inconnu');
    }

    public function BrowserDetect() {
        return Browser::browserFamily();
    }

    public function IsMobile() {
        return (Browser::isMobile() || Browser::isTablet()) ? true : false;
    }

    public function IsAndroid() {
        return Browser::isAndroid() ? true : false;
    }

    public function IsMac() {
        return Browser::isMac() ? true : false;
    }

    Public function IsWindows() {
        return Browser::isWindows() ? true : false;
    }

    public function IsLinux() {
        return Browser::isLinux() ? true : false;
    }

    public function ShowAllAbout() {
        echo 'Real Agent detected as: ' . $this->BrowserDetect() . '<hr/>';
        echo 'Is Mobile:' . $this->IsMobile() . '<hr/>';
        echo 'OS Linux:' . $this->IsLinux() . '<hr/>';
        echo 'OS Adnroid:' . $this->IsAndroid() . '<hr/>';
        echo 'OS Windows:' . $this->IsWindows() . '<hr/>';
        echo 'OS Mac/Ios:' . $this->IsMac() . '<hr/>';
    }

    public function Submit(Request $request)
    {
        $request->session()->put('status', '0');
        $request->validate([
            'url' =>'required|min:4',
            'android-url' => 'nullable|min:4',
            'ios-url' => 'nullable|min:4',
            'windows-url' => 'nullable|min:4',
        ]);

        if (preg_match('/^(((H|h)(T|t)(T|t)(P|p))?(S|s)?(:\/\/))?(www.|WWW.)?([A-Za-z0-9-]+)\.(\w+)/', $request['url'])) {
            if (substr($request['url'], 0, 4) !== 'http') {
                $request['url'] = 'http://' . $request['url'];
            }
        } else {
            $request->session()->put(['status' => 0, 'message' => 'Incorrect link structure.']);
            return back();
        }

        $link = new Link();
        $link->url = $request['url'];
        $link->tld = $this->DetectDomainTld($request['url']);

        $xtiny = [];
        $xtiny ['android'] = ( $request->has('android-url') && !is_null($request['android-url']) ) ? $request['android-url'] : 'false';
        $xtiny ['ios']     = ( $request->has('ios-url') && !is_null($request['ios-url']) ) ? $request['ios-url'] : 'false';
        $xtiny ['windows'] = ( $request->has('windows-url') && !is_null($request['windows-url']) ) ? $request['windows-url'] : 'false';

        $link->type = ( $request->has('android-url') || $request->has('ios-url') || $request->has('windows-url') ) ? 'xtiny' :'single';

        if ( $request->has('android-url') || $request->has('ios-url') || $request->has('windows-url') ) {
            $link->xtiny = $xtiny['android'] . '|||' . $xtiny['ios'] . '|||' . $xtiny['windows'];
        }

        $base = env('STR_BASE');
        $tiny = substr(str_shuffle($base . strtoupper($base)), 4, env('LINK_LENGTH'));

        $node = Link::whereRaw('LENGTH(tiny) =' . env('LINK_LENGTH'))->where('tiny', $tiny)->get();

        while (TRUE) {
            if (!count($node)) {
                break;
            } else {
                $tiny = substr(str_shuffle($base . strtoupper($base)), 4, env('LINK_LENGTH'));
                $node = Link::where('tiny', $tiny)->get();
            }
        }

        $link->registered_at = date('Y-m-d');
        $link->tiny = $tiny;
        $link->ip = $request->ip();
        if(!Auth::check() || Auth::user()->membership == 'free') {
            $link->deactivate = Carbon::now()->addMonths(1);
        }
        $link->save();
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $user->link()->attach($link->id);
        }
        $request->session()->put(['status' => 1, 'tiny' => $tiny]);

        return back();
    }

    public function Redirect(Request $request, $tiny)
    {
        $tiny = Link::where('tiny', '='  ,$tiny)->get();

        if (count($tiny) == 1) {

                // state zero -> link is deactive and process should stop with a message.

                if ($tiny[0]->state == 0) {
                    $request->session()->put(['status' => -1, 'message' => 'Tiny deactivated.']);
                    return redirect(route('Index'));
                }

                /*
                * state one -> link is active [for now].
                * after checking expire date the proccess sould continue.
                */
                elseif ($tiny[0]->state == 1) {
                    /*
                    * if link expires, proccess should stop with a message.
                    * also link state should change to zero.
                    * otherwise process to redirect will be done.
                    */
                    if(!is_null($tiny[0]->deactivate) && $tiny[0]->deactivate < date('Y-m-d H-i-s')) {
                        $tiny[0]->state = 0;
                        $tiny[0]->save();

                        $request->session()->put(['status' => -1, 'message' => 'Tiny deactivated.']);
                        return redirect(route('Index'));
                    } else {
                        Link::find($tiny[0]->id)->increment('views', 1);
                        if (!is_null($tiny[0]->xtiny)) {
                            $xtiny = explode('|||', $tiny[0]->xtiny);
                            if ($this->IsMobile()) {
                                if($this->IsAndroid()) {
                                    return redirect()->away("https://" . $xtiny[0], 303);
                                }
                                elseif ($this->IsMac()) {
                                    return redirect()->away("https://" . $xtiny[1], 303);
                                }
                                elseif ($this->IsWindows()) {;
                                    return redirect()->away("https://" . $xtiny[2], 303);
                                }
                            }
                        }
                        return redirect($tiny[0]->url, 303);
                    }
                }
        } else {
            $request->session()->put(['status' => -1, 'message' => 'Tiny not found.']);
            return redirect(route('Index'));
        }
    }
}
