<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use App\serverError;
use App\PlexRequest;
use Validator;
use Auth;
use Input;

class RequestController extends Controller
{
    public function allRequests() {

        $requests = PlexRequest::all();
        return view('allRequests', compact('requests'));

    }

    public function userRequests() {

        $currentUserID = Auth::user()->id;
        $requests = PlexRequest::where('userid', '=', $currentUserID)->get();
        return view('userRequests', compact('requests'));

    }

    public function admin() {

        $errors = serverError::all();
        $requests = PlexRequest::all();
        return view('adminPanel', compact('errors', 'requests'));

    }

    public function searchRequest(Request $request, Response $response) {

        $currentUserID = Auth::user()->id;
        
        $requests = PlexRequest::where('userid', '=', $currentUserID)->get();

        $data = $request->all();

        $title = $data['title'];

        $url = "http://www.omdbapi.com/?t=" . $title . "&y=&plot=short&r=json";

        $json = json_decode(file_get_contents($url), true);

//        return $json;

        return view('searchResults', compact('json'));

    }

    public function submit(Request $request) {

        $data = $request->all();

        $newRequest = New PlexRequest;

        $newRequest->year = $data['year'];
        $newRequest->title = $data['title'];
        $newRequest->userid = Auth::user()->id;
        $newRequest->save();

        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with(\Session::flash('failure', 'There was a problem. Your request was not submitted.'));
        } else {
            return redirect()->back()->with(\Session::flash('success', 'Your request was received.'));
        }

    }
}
