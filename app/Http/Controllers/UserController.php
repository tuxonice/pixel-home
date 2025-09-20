<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function list(): View
    {
        $users = DB::table('users')->paginate();

        return view('users.list', ['users' => $users]);
    }
}
