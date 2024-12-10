<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('dashboard', [
            'users' => $users,
        ]);
    }
}
