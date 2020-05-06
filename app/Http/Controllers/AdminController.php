<?php

namespace App\Http\Controllers;

use App\Link;
use App\Session;
use App\Charts\LinkChart;
use App\Charts\UserChart;

use Illuminate\Http\Request;

class AdminController extends Controller
{
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
}
