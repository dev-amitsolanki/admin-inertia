<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->type != 'admin') {
                return Redirect::route('dashboard');
            }
            return $next($request);
        });
    }
    function index(): Response
    {
        $users = User::orderBy('id', 'desc')
            ->paginate(5);

        return Inertia::render('users/index', [
            'users' => $users,
        ]);
    }
}
