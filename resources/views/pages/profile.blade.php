@extends('Layout.master')

@section('title', 'Profile')

@section('admincontent')
    <div class="container mt-5" style="padding: 80px;">

        <div class="card shadow-lg p-4">
            <div class="text-center">
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/profiles/' . Auth::user()->photo) }}" alt="Profile Photo" width="150" height="150">
                @else
                    <p>No profile photo uploaded.</p>
                @endif
                <h1>{{ Auth::user()->name }}</h1>


                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Created At:</strong> {{ Auth::user()->created_at }}</p>

                <br>
                <br>

                <form action="" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Are you sure you want to delete your profile?')">edit Profile</button>
                </form>
            </div>
        </div>

    </div>
@endsection
