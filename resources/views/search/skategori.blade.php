@extends('layouts.adm-main')

@section('content')
<div class='mt-4 text-gray-700'>Hasil pencarian untuk '<span class='text-orange-500'><b>{{ $query }}</b></span>'
<br><hr><br><br>
<h3>Kategori</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($rsetResultsKategori as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->deskripsi }}</td>
                <td>{{ $row->kategori }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Data Kategori belum tersedia</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection