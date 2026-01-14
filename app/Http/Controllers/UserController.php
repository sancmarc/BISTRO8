<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $checkRole = Auth::user()->role;

        return view('dashboard.admin.user-management')->with('checkRole', $checkRole);
    }
    public function create(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $query = $user->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'New User has been Added!']);
            }
        }
    }
    public function show(Request $request)
    {
        $userList = User::where('role', 0)->get();
        return DataTables::of($userList)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
            <button class="btn btn-sm btn-info" id="editBtn" data-id="' . $row->id . '">Update</button>
            <button class="btn btn-sm btn-danger" id="deleteBtn" data-id="' . $row->id . '">Delete</button>
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function edit(Request $request)
    {
        $details = User::find($request->dataID);
        return response()->json(['details' => $details]);
    }
    public function update(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'new_name' => 'required|string',
            'new_email' =>  'required|email|unique:users,email,' . $request->dataID,
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $user = User::find($request->dataID);
            $user->name = $request->new_name;
            $user->email = $request->new_email;
            $user->password = Hash::make($request->new_password);
            $query = $user->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'User has been Updated!']);
            }
        }
    }
    public function destroy(Request $request)
    {
        $details = User::find($request->dataID);
        $query = $details->delete();

        if (!$query) {
            return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'User has been Deleted!']);
        }
    }
}
