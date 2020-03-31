<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function link()
    {
        // reach to links
        $user = User::find(Auth::id());
        foreach ($user->link as $item) {
            echo "<pre>'$item->tiny'</pre>";
        }
    }

    public function Index()
    {
        $links = User::find(Auth::id());
        $links->setRelation('links', $links->link()->latest()->paginate(10));
        $count = count($links->links);
        return view('panel.home.index', compact('count'));
    }

    public function Links()
    {
        $links = User::find(Auth::id());
        $links->setRelation('links', $links->link()->latest()->paginate(10));
        return view('panel.links.index', compact('links'));
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            return redirect(route('Index'));
        } else {
            return redirect(route('login'));
        }
    }
}
