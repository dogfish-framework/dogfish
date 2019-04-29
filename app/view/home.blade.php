@extends('layouts/main')

@section('title')
Home
@endsection

@section('container')
<h4 CLASS="text-accent-3 center">Bienvenue sur DOGFISH</h4>
        @forelse ($users as $user)
            <li>{{ $user->nom }}</li>
        @empty
            <p>No users</p>
        @endforelse
@endsection
