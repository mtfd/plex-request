@extends('partials.master')

@section('content')

@if (Auth::check())
    <div class="col-xs-12 col-md-8 col-md-offset-2">
        <h2>{{ $user->name }}</h2>
        <br>
        <form method="POST" action="{{ route('edituser') }}">
            {!! csrf_field() !!}
            <table class="table table-hover table-bordered">
                <tr class="active">
                    <td>ID</td>
                    <td>Email</td>
                    <td>Registered</td>
                    <td>Delete?</td>
                </tr>
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td><a href="{{ route('destroyuser', $user->id) }}">Confirm</a></td>
                </tr>
            </table>
        </form>
    </div>
@endif

@stop