<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

     public function handleAdmin()
    {
        $users = User::where("is_admin","!=" , 1)->get();

        return view('handleAdmin', compact('users'));
    }

    public function getUser($id)
    {
        $user = User::find($id);

         return response()->json(['status' => 'success'
            , 'user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
          $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['status' => 'success'
            , 'user' => $user]);
    }

    public function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return response()->json(['status' => 'success']);
    }
}
