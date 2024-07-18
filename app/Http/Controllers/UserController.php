<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

Hash::make('password');

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('user.formuser', compact('users'));
    }

    public function create()
    {
        return view('user.formuser');
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);
        return view('user.formuser', compact('user'));
    }

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $user->username = $request->input('username');
        $user->password = bcrypt($request->input('password'));
        $user->level = $request->input('level');
        $user->save();
    
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'level' => 'required',
        ]);
    
    
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->level = $request->level;
        $user->save();
    
        return redirect()->route('user.index')->with('success', 'User added successfully.');
    }
}