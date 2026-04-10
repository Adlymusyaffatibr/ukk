<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = User::all();;
        return view ('admin.user', compact('users'));
    }

    public function store(Request $r){

        $r->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min5',
            'role'=> 'required', 
        ]);

        User::create([
            'name'->name,
            'email'->email,
            'password'->Hash::make($r->password),
            'role'->role,
        ]);

        return back()->with('success', 'User berhasil ditambah');
    }

    public function update(Request $r, $id){
        $user= User::findOrfail($id);

        $r->validate([
            'name'=> 'required',
            'email'=> 'required|email|unique:user,email,'. $id,
            'role'=> 'required'
        ]);

        $data([
            'name'=>$r->name,
            'email'=>$r->email,
            'role'=>$r->role
        ]);

        if($r->password){
            $data['password'] = Hash::make($r->password);
        }

        $user->update($data);

        return back()->with('success', 'User berhasil diupdate');
    }

    public function destroy($id){
        User::findOrfail($id)->delete();
        return back()->with('success',"User berhasil dihapus");
    }
}
