<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('pages/admin/users',compact('users'));
    }

    public function tambahUser(Request $req)
    {
        // Validate the input data
        // $validatedData = $req->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6',
        //     'role' => 'required|in:0,1,2', // Example for role validation, adjust as needed
        // ]);

        // Create a new user instance and save it
        $user = new User();
        $user->name = $req->name;
        $user->nim = $req->nim;
        $user->no_telp = $req->no_telp;
        $user->prodi = $req->prodi;
        $user->gender = $req->gender;
        $user->email = $req->email;
        $user->password = bcrypt($req->password); // Encrypt the password
        $user->plain_password = $req->password; // Encrypt the password
        $user->type =$req->role;
        $user->save();

        return redirect('/users')->with('success', 'User added successfully!');
    }

    public function editUser(Request $req)
    {
        $id = $req->input('id');
        $user = User::find($id);
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->type = $req->input('role');
        $user->nim = $req->nim;
        $user->no_telp = $req->no_telp;
        $user->prodi = $req->prodi;
        $user->gender = $req->gender;
        $user->save();
        return redirect('/users')->with('success', 'User updated successfully!');
    }

    public function hapusUser(Request $req)
    {
        $id = $req->input('id');
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->with('success', 'User deleted successfully!');
    }

}
