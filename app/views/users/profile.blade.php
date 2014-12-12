@extends('layouts.default')
<div class="container">
    <div>
        @if(Sentry::check())
            <p>Welcome to your profile page {{ $user->email }}</p>
            <p>{{ $user_id }}</p>
            <p>{{ Form::selectMonth('month') }}</p>			
            <p>{{ Form::input('number', 'off') }}</p>
         @endif
    </div>
</div>