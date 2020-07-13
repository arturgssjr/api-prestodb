<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('oauth.index');
    }
}
