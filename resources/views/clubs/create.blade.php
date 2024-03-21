@extends('layouts.index')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-o shadow-sm rounded">
                <div class="card-header bg-dark">
                    <div class="float-end">
                        <span class="fs-5 text-white">Tambah Klub</span>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('clubs.store') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Nama Klub</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" placeholder="Masukkan Nama Klub">

                            <!-- error message -->
                            @error('name')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Kota Klub</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                                value="{{ old('city') }}" placeholder="Masukkan Kota Klub">

                            <!-- error message -->
                            @error('city')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-md btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
