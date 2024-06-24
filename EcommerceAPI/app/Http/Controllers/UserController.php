<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function register(Request $request){
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    
        // Create new User instance and save
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
    
        return $user;  // Return the saved user object
    }
    
    
    // My Code
    // function login(Request $request)
    // {
    //     $user = User::where('email',$request->email)->first();
    //     if(!$user || !Hash::check($request->password,$user->password))
    //     {
    //         return response([
    //             'error'=>["Email or password is not matched"]
    //         ],401);
    //     }
    // }


    //Chat gpt code

    public function login(Request $request)
{
    // $request->validate([
    //     'email' => 'required|email',
    //     'password' => 'required',
    // ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'error' => 'Email or password is incorrect.'
        ], 401);
    }

    // Authentication passed
    // You may generate a token or perform additional tasks here if needed

    return response()->json([
        'message' => 'Login successful',
        'user' => $user, // You can return the user data here if needed
    ]);
}


}
