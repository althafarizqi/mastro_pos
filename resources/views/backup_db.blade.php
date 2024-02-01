@extends('layouts/dashboard')

@section('content')
<div class="row">
    <form action="{{ route('backup.dbonly') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-sm btn-primary mb-3 mr-3">Backup Database</button>
    </form>
    <form action="{{ route('backup.full') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-sm btn-primary mb-3">Backup Full</button>
    </form>
</div>
<h1>List of Backups</h1>

@if($backups !== null && count($backups) > 0)
<ul>
    @foreach($backups as $backup)
    <li>
        Backup Name: {{ $backup }}
        <!-- Tampilkan informasi backup lainnya sesuai kebutuhan -->
        <a class="ml-4 btn badge badge-pill badge-primary"
            href="{{ route('download.backup', ['name' => $backup]) }}">Download</a>
        <a class="btn badge badge-pill badge-danger" href="{{ route('delete.backup', ['name' => $backup]) }}"
            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $loop->index }}').submit();">
            Delete
        </a>

        <!-- Formulir untuk menghapus backup -->
        <form id="delete-form-{{ $loop->index }}" action="{{ route('delete.backup', ['name' => $backup]) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </li>
    @endforeach
</ul>
@else
<p>No backups available.</p>
@endif
@endsection