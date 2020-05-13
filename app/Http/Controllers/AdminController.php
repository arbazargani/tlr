<?php

namespace App\Http\Controllers;

use App\Link;
use App\Session;
use App\User;
use App\Charts\LinkChart;
use App\Charts\UserChart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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

    public function Index()
    {
        $yesterdayLinks = Link::where('registered_at', date('Y-m-d', strtotime('-1 day')))->get();
        $beforeYesterdayLinks = Link::where('registered_at', date('Y-m-d', strtotime('-2 day')))->get();
        $todayLinks = Link::where('registered_at', date('Y-m-d'))->get();
        $totalLinks = Link::count();

        $Link_Count_Chart = new LinkChart;
        $Link_Count_Chart->labels(['-2 Days', 'Yesterday', 'Today']);
        $Link_Count_Chart->dataset('Links Reg', 'line', [count($beforeYesterdayLinks), count($yesterdayLinks), count($todayLinks)])
            ->color("hsla(356,86%,55%,1)")
            ->backgroundColor('rgba(165, 165, 165, 0.14)')
            ->linetension(0.2);
        $Link_Count_Chart->options([
            'tooltip' => [
                'show' => true // or false, depending on what you want.
            ]
        ]);


        $loyalUsers = Session::where('returning_user', '1')->get();
        $newUsers = Session::where('returning_user', '0')->get();

        $loyal_users_chart = new UserChart;
        $loyal_users_chart->labels(['Returning', 'New']);
        $loyal_users_chart->dataset('Users', 'bar', [count($loyalUsers), count($newUsers)])
            ->color("hsla(356,86%,55%,1)")
            ->backgroundColor('rgba(165, 165, 165, 0.14)')
            ->linetension(0.2);

        return view('admin.home.index', compact(['todayLinks', 'totalLinks', 'yesterdayLinks', 'Link_Count_Chart', 'loyal_users_chart']));
    }

    public function Links()
    {
        $links = Link::latest()->paginate(2);
        return view('admin.link.manage', compact('links'));
    }

    public function FindLinks(Request $request)
    {
        if(isset($_GET['link']) && !is_null($_GET['link'])) {
            if ($_GET['find_by'] === 'id') {
                $link = Link::find(trim($_GET['link'], ' /'));
                if (!is_null($link)) {
                    return view('admin.link.find', compact('link'));
                } else {
                    $error = 1;
                    return view('admin.link.find', compact('error'));
                }
            } else {
                $link = Link::where('tiny', trim($_GET['link'], ' /'))->get();
                $link = count($link) == 1 ? $link[0] : NULL;
                if (!is_null($link)) {
                    return view('admin.link.find', compact('link'));
                } else {
                    $error = 1;
                    return view('admin.link.find', compact('error'));
                }
            }
        } else {
            return view('admin.link.find');
        }
    }

    public function ActivateLink($id)
    {
        $tiny = Link::find($id);
        $tiny->state = 1;
        $tiny->save();
        return back();
    }

    public function DeactivateLink($id)
    {
        $tiny = Link::find($id);
        $tiny->state = 0;
        $tiny->save();
        return back();
    }

    public function DeleteLink($id)
    {
        $tiny = Link::find($id)->delete();
        return back();
    }

    public function AddLink($multiple = null) {
        return (is_null($multiple)) ? view('admin.link.add') : view('admin.link.xadd');
    }

    public function SubmitLink(Request $request)
    {
        $request->session()->put('status', '0');
        $request->validate([
            'url' =>'required|min:4'
        ]);

        if (preg_match('/^(((H|h)(T|t)(T|t)(P|p))?(S|s)?(:\/\/))?(www.|WWW.)?([A-Za-z0-9-]+)\.(\w+)/', $request['url'])) {
            if (substr($request['url'], 0, 4) !== 'http') {
                $request['url'] = 'http://' . $request['url'];
            }
        } else {
            $request->session()->put(['status' => 0, 'message' => 'Incorrect link structure.']);
            return redirect(route('Admin > Links > Add'));
        }

        $link = new Link();
        $link->url = $request['url'];
        $link->tld = $this->DetectDomainTld($request['url']);

        $base = env('STR_BASE');
        $tiny = substr(str_shuffle($base . strtoupper($base)), 4, env('LINK_LENGTH'));

        $node = Link::whereRaw('LENGTH(tiny) = ' . env('LINK_LENGTH'))->where('tiny', $tiny)->get();

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

}
