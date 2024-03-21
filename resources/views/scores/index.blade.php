@extends('layouts.index')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-dark">
                    <span class="fs-5 text-white">Pilih Cara</span>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Pilih Cara</label>
                        <select name="cara" id="cara" class="form-select">
                            <option value="0" disabled selected>--Pilih Cara--</option>
                            <option value="1">Satu per satu</option>
                            <option value="2">Multiple</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body single d-none">
                    <form method="POST" action="{{ route('scores.storeSingle') }}">
                        @csrf
                        <div class="row">
                            <div class="col-6 mb-3">
                                <select name="club_home_id" id="club_home_id" class="form-select" required>
                                    <option value="0" disabled selected>Klub 1</option>
                                    @foreach ($data as $club)
                                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <select name="club_away_id" id="club_away_id" class="form-select" required>
                                    <option value="0" disabled selected>Klub 2</option>
                                    @foreach ($data as $club)
                                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" name="club_home_goal" placeholder="Score 1" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" name="club_away_goal" placeholder="Score 2" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                    </form>
                </div>

                {{-- multiple --}}
                <div class="card-body multiple d-none">
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Pastikan tidak ada pertandingan yang sama dan lengkapi form
                        </div>
                    @endif
                    <form action="{{ route('scores.store') }}" method="POST">
                        @csrf
                        <table class="table">
                            <tbody id="tbody">
                                <tr>
                                    <td>
                                        <select name="club_home[1]" id="club_home_1" class="form-select">
                                            <option value="0" disabled selected>Klub 1</option>
                                            @foreach ($data as $club)
                                                <option value="{{ $club->id }}">{{ $club->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="club_away[1]" id="club_away_1" class="form-select">
                                            <option value="0" disabled selected>Klub 2</option>
                                            @foreach ($data as $club)
                                                <option value="{{ $club->id }}">{{ $club->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="score_home[1]" id="score_home_1" min="0"
                                            class="form-control" placeholder="Skor 1"></td>
                                    <td><input type="number" name="score_away[1]" id="score_away_1" min="0"
                                            class="form-control" placeholder="Skor 2"></td>
                                </tr>
                            </tbody>

                        </table>
                        <button type="button" class="btn btn-sm btn-success add">Tambah</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('jquery/jquery.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $('#cara').on('change', function() {
            let value = $(this).val();
            if (value === "1") {
                $('.single').removeClass('d-none')
                $('.multiple').addClass('d-none')
            } else if (value === "2") {
                $('.single').addClass('d-none')
                $('.multiple').removeClass('d-none')
            }
        })
    </script>
@endpush

@push('scripts')
    <script>
        let i = 1;
        let index = 2;
        let secondIndex = 3;
        let selectedClubs = [];
        let clubData = @json($data);

        $('.add').on('click', function() {
            let home = {
                id: parseInt($(`#club_home_${i}`).val())
            };
            let away = {
                id: parseInt($(`#club_away_${i}`).val())
            };
            selectedClubs.push(home, away);


            if (index >= 3 && secondIndex >= 4) {
                index = secondIndex;
                secondIndex += 1;
            }
            index += 1;
            secondIndex += 1;
            i += 1;

            let html = `
                <tr>
                    <td>
                        <select name="club_home[${i}]" id="club_home_${i}" class="form-select">
                            <option value="0" disabled selected>Klub ${index}</option>
                            ${fetchClubs()}
                        </select>
                    </td>
                    <td>
                        <select name="club_away[${i}]" id="club_away_${i}" class="form-select">
                            <option value="0" disabled selected>Klub ${secondIndex}</option>
                            ${fetchClubs()}
                        </select>
                    </td>
                    <td><input type="number" name="score_home[${i}]" id="score_home_${i}" min="0"
                            class="form-control" placeholder="Skor ${index}"></td>
                    <td><input type="number" name="score_away[${i}]" id="score_away_${i}" min="0"
                            class="form-control" placeholder="Skor ${secondIndex}"></td>  
                </tr>
            `;

            $('#tbody').append(html);

        });

        const fetchClubs = () => {
            let html = '';

            for (let j = 0; j < clubData.length; j++) {
                html += `
                    <option value="${clubData[j].id}">${clubData[j].name}</option>
                `;
            }

            return html;
        }
    </script>
@endpush
