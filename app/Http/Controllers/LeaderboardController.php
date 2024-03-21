<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    //
    public function index(): View
    {
        $data = Club::whereHas('leaderboard')
            ->with('leaderboard')->get()->sortByDesc('leaderboard.point');

        return view('leaderboards.index', compact([
            'data'
        ]));
    }
}
