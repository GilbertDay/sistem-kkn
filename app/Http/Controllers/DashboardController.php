<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFeed;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $dataFeed = new DataFeed();
        $users = User::all();

        return view('pages/admin/users',compact('users'));
    }

    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
}
