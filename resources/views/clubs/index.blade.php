@extends('layouts.index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-o shadow-sm rounded">
                <div class="card-header bg-white">
                    <div class="float-end">
                        <a href="{{ route('clubs.create') }}" class="btn btn-success">Add</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Klub</th>
                                <th scope="col">Kota Klub</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $club)
                                <tr>

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $club->name }}</td>
                                    <td>{{ $club->city }}</td>
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
