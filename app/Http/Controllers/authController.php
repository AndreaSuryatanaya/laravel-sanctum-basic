<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function registerUser(Request $request)
    {
        $datauser = new User();
        $rules = [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'proses validasi gagal',
                'data' => $validator->errors()
            ], 400);
        }

        $datauser->name = $request->name;
        $datauser->email = $request->email;
        $datauser->password = Hash::make($request->password);
        $datauser->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $datauser
        ], 201);
    }

    public function loginUser(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'proses login gagal',
                'data' => $validator->errors()
            ], 400);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah',
                'data' => null
            ], 401);
        }

        $datauser = User::where('email', $request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $datauser->createToken('api-product')->plainTextToken,
        ], 200);
    }
}
