<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRegister;
use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    public function user_data()
    {
        $user = UserRegister::all();
        return response()->json([
            'status' => 'success',
            'message' => 'User data',
            'data' => $user
        ]);
    }

    public function add_user(Request $request)
    {
        $data = $request->all();
        $user = UserRegister::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Add user'
        ]);
    }

    public function delete_user($id)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Delete user'
        ]);
    }
}
