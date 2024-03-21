<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClubController extends Controller
{
    //
    public function index(): View
    {
        $data = Club::query()->latest()->get();

        return view('clubs.index', compact([
            'data'
        ]));
    }

    public function create(): View
    {
        return view('clubs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        //validate form
        $request->validate([
            'name'         => 'required|unique:clubs',
            'city'   => 'required',
        ]);

        //create 
        Club::create([
            'name'         => $request->name,
            'city'         => $request->city
        ]);

        //redirect to index
        return redirect()->route('clubs')->with(['success' => 'Data Berhasil Disimpan!']);
    }
}
