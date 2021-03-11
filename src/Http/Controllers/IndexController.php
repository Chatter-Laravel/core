<?php

namespace Chatter\Core\Http\Controllers;

use Auth;
use Chatter\Core\Models\PostInterface;
use Illuminate\Routing\Controller as Controller;

class IndexController extends Controller
{
    public function index()
    {
        $logged = Auth::check();

        if (!config('chatter.user.allow_username_change')) {
            $hasUsername = true;
        } else {
            $hasUsername = Auth::check() ? null !== Auth::user()->username : null;
        }

        return view('chatter::home', compact('logged', 'hasUsername'));
    }
}
