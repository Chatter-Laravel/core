<?php

namespace Chatter\Core\Http\Controllers\Api;

use Str;
use Auth;
use Illuminate\Routing\Controller;
use Chatter\Core\Models\UserResource;
use Chatter\Core\Http\Requests\StoreUsernameRequest;

class UsernameController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(StoreUsernameRequest $request)
    {
        return new UserResource(tap(Auth::user(), function ($user) use ($request) {
            $user->username = Str::snake(Str::lower($request->username));
            $user->save();
        }));
    }
}
