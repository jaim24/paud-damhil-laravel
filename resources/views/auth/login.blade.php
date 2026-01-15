@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="container mt-2" style="min-height: 60vh; display: flex; align-items: center; justify-content: center;">
    <div class="form-card" style="width: 100%; max-width: 400px; margin: 0;">
        <h2 class="text-center">Login Admin</h2>
        <form action="{{ route('login.perform') }}" method="POST">
            @csrf
            <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" required></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" required></div>
            <button type="submit" class="btn btn-primary" style="width: 100%">Login</button>
        </form>
    </div>
</div>
@endsection
