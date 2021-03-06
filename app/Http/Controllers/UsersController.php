<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UsersController extends Controller
{

    public function edituser(Request $request) {

        $admincheckboxes = $request->input('admincheckbox');

        foreach ($admincheckboxes as $uid => $value) {
            $user = User::find($uid);
            $user->admin= $value;
            $user->save();
        }

        return redirect()->back()->with(\Session::flash('success', 'Changes saved.'));
    }

    public function showuser($id) {

        $user = User::findOrFail($id);

        return view('showuser', compact('user'));

    }

    public function destroy($id) {

        $user = User::findOrFail($id);

        if($user->delete()) {

            return redirect()->route('admin')->with(\Session::flash('success', 'User was deleted'));

        } else {

            return redirect()->back()->with(\Session::flash('failure', 'There was a problem. User was not deleted.'));

        }

    }

}
