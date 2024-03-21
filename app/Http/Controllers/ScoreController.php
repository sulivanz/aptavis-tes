<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Leaderboard;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    //
    public function index(): View
    {
        $data = Club::query()->orderBy('name', 'asc')->get();

        return view('scores.index', compact([
            'data'
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "club_home"    => "required|array|min:1",
            "club_home.*"  => "required|numeric|distinct|min:1",
            "club_away"    => "required|array|min:1",
            "club_away.*"  => "required|numeric|distinct|min:1",
            "score_home"    => "required|array|min:1",
            "score_home.*"  => "required|numeric|distinct|min:1",
            "score_away"    => "required|array|min:1",
            "score_away.*"  => "required|numeric|distinct|min:1",
        ]);

        DB::transaction(function () use ($data) {
            foreach ($data['club_home'] as $key => $value) {
                $homeId = (int)$value;
                $awayId = (int)$data['club_away'][$key];
                $homeGoal = (int)$data['score_home'][$key];
                $awayGoal = (int)$data['score_away'][$key];
                Score::create([
                    'club_home_id' => $homeId,
                    'club_away_id' => $awayId,
                    'club_home_goal' => $homeGoal,
                    'club_away_goal' => $awayGoal,
                ]);

                $homeClub = Leaderboard::query()->where('club_id', $homeId)->first();
                $awayClub = Leaderboard::query()->where('club_id', $awayId)->first();

                //point
                $homePoint = 0;
                $awayPoint = 0;

                //match result
                $homeWin = 0;
                $awayWin = 0;
                $isDraw = 0;
                $homeLose = 0;
                $awayLose = 0;

                //total goal
                $goalHomeWin = 0;
                $goalHomeLose = 0;

                $goalAwayWin = 0;
                $goalAwayLose = 0;

                if ($homeGoal > $awayGoal) {
                    $homePoint = 3;
                    $awayPoint = 0;

                    $homeWin = 1;
                    $awayLose = 1;

                    $goalHomeWin = $homeGoal;
                    $goalAwayLose = $homeGoal;
                }
                if ($homeGoal < $awayGoal) {
                    $homePoint = 0;
                    $awayPoint = 3;

                    $awayWin = 1;
                    $homeLose = 1;

                    $goalHomeLose = $awayGoal;
                    $goalAwayWin = $awayGoal;
                }
                if ($homeGoal == $awayGoal) {
                    $homePoint = 1;
                    $awayPoint = 1;
                    $isDraw = 1;

                    $goalHomeLose = $awayGoal;
                    $goalAwayLose = $homeGoal;

                    $goalHomeWin = $homeGoal;
                    $goalAwayWin = $awayGoal;
                }

                if ($homeClub) {
                    Leaderboard::query()->where('club_id', $homeId)->update([
                        'match' => $homeClub->match + 1,
                        'win' => $homeClub->win + $homeWin,
                        'lose' => $homeClub->lose + $homeLose,
                        'draw' => $homeClub->draw + $isDraw,
                        'win_goal' => $homeClub->win_goal + $goalHomeWin,
                        'lose_goal' => $homeClub->lose_goal + $goalHomeLose,
                        'point' => $homeClub->point + $homePoint,
                    ]);
                } else {
                    Leaderboard::create([
                        'match' => 1,
                        'club_id' => $homeId,
                        'win' => $homeWin,
                        'lose' => $homeLose,
                        'draw' => $isDraw,
                        'win_goal' => $goalHomeWin,
                        'lose_goal' => $goalHomeLose,
                        'point' => $homePoint,
                    ]);
                }

                if ($awayClub) {
                    Leaderboard::query()->where('club_id', $awayId)->update([
                        'match' => $awayClub->match + 1,
                        'win' => $awayClub->win + $awayWin,
                        'lose' => $awayClub->lose + $awayLose,
                        'draw' => $awayClub->draw + $isDraw,
                        'win_goal' => $awayClub->win_goal + $goalAwayWin,
                        'lose_goal' => $awayClub->lose_goal + $goalAwayLose,
                        'point' => $awayClub->point + $awayPoint,
                    ]);
                } else {
                    Leaderboard::create([
                        'match' => 1,
                        'club_id' => $awayId,
                        'win' => $awayWin,
                        'lose' => $awayLose,
                        'draw' => $isDraw,
                        'win_goal' => $goalAwayWin,
                        'lose_goal' => $goalAwayLose,
                        'point' => $awayPoint,
                    ]);
                }
            }
        });

        //redirect to index
        return redirect()->route('scores')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function storeSingle(Request $request)
    {
        DB::transaction(function () use ($request) {
            $homeId = (int)$request->club_home_id;
            $awayId = (int)$request->club_away_id;
            $homeGoal = (int)$request->club_home_goal;
            $awayGoal = (int)$request->club_away_goal;
            Score::create([
                'club_home_id' => $homeId,
                'club_away_id' => $awayId,
                'club_home_goal' => $homeGoal,
                'club_away_goal' => $awayGoal,
            ]);

            $homeClub = Leaderboard::query()->where('club_id', $homeId)->first();
            $awayClub = Leaderboard::query()->where('club_id', $awayId)->first();

            //point
            $homePoint = 0;
            $awayPoint = 0;

            //match result
            $homeWin = 0;
            $awayWin = 0;
            $isDraw = 0;
            $homeLose = 0;
            $awayLose = 0;

            //total goal
            $goalHomeWin = 0;
            $goalHomeLose = 0;

            $goalAwayWin = 0;
            $goalAwayLose = 0;

            if ($homeGoal > $awayGoal) {
                $homePoint = 3;
                $awayPoint = 0;

                $homeWin = 1;
                $awayLose = 1;

                $goalHomeWin = $homeGoal;
                $goalAwayLose = $homeGoal;
            }
            if ($homeGoal < $awayGoal) {
                $homePoint = 0;
                $awayPoint = 3;

                $awayWin = 1;
                $homeLose = 1;

                $goalHomeLose = $awayGoal;
                $goalAwayWin = $awayGoal;
            }
            if ($homeGoal == $awayGoal) {
                $homePoint = 1;
                $awayPoint = 1;
                $isDraw = 1;

                $goalHomeLose = $awayGoal;
                $goalAwayLose = $homeGoal;

                $goalHomeWin = $homeGoal;
                $goalAwayWin = $awayGoal;
            }

            if ($homeClub) {
                Leaderboard::query()->where('club_id', $homeId)->update([
                    'match' => $homeClub->match + 1,
                    'win' => $homeClub->win + $homeWin,
                    'lose' => $homeClub->lose + $homeLose,
                    'draw' => $homeClub->draw + $isDraw,
                    'win_goal' => $homeClub->win_goal + $goalHomeWin,
                    'lose_goal' => $homeClub->lose_goal + $goalHomeLose,
                    'point' => $homeClub->point + $homePoint,
                ]);
            } else {
                Leaderboard::create([
                    'match' => 1,
                    'club_id' => $homeId,
                    'win' => $homeWin,
                    'lose' => $homeLose,
                    'draw' => $isDraw,
                    'win_goal' => $goalHomeWin,
                    'lose_goal' => $goalHomeLose,
                    'point' => $homePoint,
                ]);
            }

            if ($awayClub) {
                Leaderboard::query()->where('club_id', $awayId)->update([
                    'match' => $awayClub->match + 1,
                    'win' => $awayClub->win + $awayWin,
                    'lose' => $awayClub->lose + $awayLose,
                    'draw' => $awayClub->draw + $isDraw,
                    'win_goal' => $awayClub->win_goal + $goalAwayWin,
                    'lose_goal' => $awayClub->lose_goal + $goalAwayLose,
                    'point' => $awayClub->point + $awayPoint,
                ]);
            } else {
                Leaderboard::create([
                    'match' => 1,
                    'club_id' => $awayId,
                    'win' => $awayWin,
                    'lose' => $awayLose,
                    'draw' => $isDraw,
                    'win_goal' => $goalAwayWin,
                    'lose_goal' => $goalAwayLose,
                    'point' => $awayPoint,
                ]);
            }
        }, 10);

        //redirect to index
        return redirect()->route('scores')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
