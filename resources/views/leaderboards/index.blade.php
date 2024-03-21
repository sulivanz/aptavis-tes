@extends('layouts.index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-o shadow-sm rounded">
                <div class="card-header bg-white">
                    <div class="float-end">
                        <span class="fs-5">Klasemen</span>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Klub</th>
                                <th scope="col">Ma</th>
                                <th scope="col">Me</th>
                                <th scope="col">S</th>
                                <th scope="col">K</th>
                                <th scope="col">GM</th>
                                <th scope="col">GK</th>
                                <th scope="col">Point</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $club)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $club->name }}</td>
                                    <td>{{ $club->leaderboard->match }}</td>
                                    <td>{{ $club->leaderboard->win }}</td>
                                    <td>{{ $club->leaderboard->draw }}</td>
                                    <td>{{ $club->leaderboard->lose }}</td>
                                    <td>{{ $club->leaderboard->win_goal }}</td>
                                    <td>{{ $club->leaderboard->lose_goal }}</td>
                                    <td>{{ $club->leaderboard->point }}</td>
                                </tr>
                            @empty
                                Data tidak ada
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
