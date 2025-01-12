<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        // Nếu xác thực thất bại
        if ($validator->fails()) {
            return response()->json([
                'DT' => '',
                'EC' => -1,
                'EM' => 'Email '. $request->email . ' đã tồn tại'
            ], 400);
        }

        // Tạo user mới
        try {
            $user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'DT' => '', // Có thể trả về dữ liệu user (trừ password)
                'EC' => 0,
                'EM' => 'A new user created success',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'DT' => '',
                'EC' => -1,
                'EM' => 'An error occurred while creating user',
            ], 500);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Tìm user bằng email
        $user = User::where('email', $request->email)->first();
    
        // Kiểm tra xem user có tồn tại và mật khẩu có đúng không
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'DT' => '',
                'EC' => -1,
                'EM' => 'Invalid email or password',
            ], 401);
        }
    
        // Tạo access token
        $accessToken = $user->createToken('access_token')->plainTextToken;
        $refreshToken = base64_encode(random_bytes(40));
        $user->refresh_token = $refreshToken;
        $user->save();

        return response()->json([
            'DT' => [
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'username' => $user->username,
                'role' => $user->role,
                'email' => $user->email,
                'image' => $user->image,
            ],
            'EC' => 0,
            'EM' => 'Login succeed',
        ]);
    }
    public function refreshToken(Request $request)
    {
        $refreshToken = $request->input('refresh_token');

        $user = User::where('email', $request->email)->first();
        // Kiểm tra refresh token hợp lệ (tùy vào cách bạn lưu trữ token)
        if (!$user || !$refreshToken || $user->refresh_token !== $refreshToken) {
            return response()->json([
                'DT' =>  [
                    'email' => $request->email,
                    'access_token' => $refreshToken,
                ],
                'EC' => -1,
                'EM' => 'Invalid refresh token',
            ], 401);
        }

        
        $newAccessToken = $user->createToken('access_token')->plainTextToken;
        $newRefreshToken = base64_encode(random_bytes(40));
        $user->refresh_token = $newRefreshToken;
        $user->save();

        return response()->json([
            'DT' => [
                'access_token' => $newAccessToken,
                'refresh_token' => $newRefreshToken,
            ],
            'EC' => 0,
            'EM' => 'Token refreshed successfully',
        ]);
    }

}

