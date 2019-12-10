<?php

namespace Chatter\Core\Http\Controllers;

use Illuminate\Routing\Controller as Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('chatter::home');
    }
}
