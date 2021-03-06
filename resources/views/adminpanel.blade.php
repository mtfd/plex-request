@extends('partials.master')

@section('content')
    @if (Auth::check())
        <div class="col-xs-12 col-md-7">
            @if(!$users->isEmpty())
            <h2>Users:</h2>
            <br>
            <form method="POST" action="{{ route('edituser') }}">
                {!! csrf_field() !!}
                <table class="table table-hover table-bordered">
                    <tr class="active">
                        <td>ID</td>
                        <td>Name</td>
                        <td>Admin?</td>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a href="{{ route('showuser', $user->id) }}">{{ $user->name }}</a></td>
                            <td>
                                <input type="hidden" id="admincheckbox" name="admincheckbox[{{$user->id}}]" value="0">
                                <input type="checkbox" id="admincheckbox" name="admincheckbox[{{$user->id}}]" value="1" @if($user->admin or $user->id ==1) checked @endif>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td><button class="btn btn-info">Submit</button></td>
                    </tr>
                </table>
            </form>
            @endif
            @if(!$errors->isEmpty())
            <h2>Reported errors:</h2>
            <br>
            <table class="table table-hover table-bordered">
                <tr class="active">
                    <td>Name:</td>
                    <td>Date:</td>
                    <td>Description:</td>
                    <td>Delete?</td>
                </tr>
                @foreach ($errors as $error)
                <tr>
                    <td>{{ $error->name }}</td>
                    <td>{{ $error->date }}</td>
                    <td>{{ $error->description }}</td>
                    <td class="text-center"><a href="{{ route('deleteerror', $error->id) }}"><button>x</button></a></td>
                </tr>
                @endforeach
            </table>
            @else
            <h2>No errors reported.</h2>
            @endif
        </div>
        <div class="col-xs-12 col-md-5">
            @if(!$requests->isEmpty())
                <h2>Current requests:</h2>
                <br>
                <table class="table table-hover table-bordered">
                    
                        <tr class="active">
                            <td>Title:</td>
                            <td>User:</td>
                            <td>Delete?</td>
                        </tr>
                        @foreach ($requests as $request)
                            <tr>
                                <td><a href="http://imdb.com/title/{{ $request['imdbid'] }}" target="new">{{ $request->title }}</a></td>
                                <td>{{ $request->user }}</td>
                                <td class="text-center"><a href="{{ route('deleterequest', $request->id) }}"><button>x</button></a></td>
                            </tr>
                        @endforeach
                    
                </table>
            @else
                <h2>No requests submitted.</h2>
            @endif
        </div>
    @else
        <div class="col-xs-12 col-md-6 col-md-offset-3 text-center">
            <h2>You shouldn't be seeing this, someone messed up.</h2>
        </div>
    @endif
@stop