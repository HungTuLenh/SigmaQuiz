<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $limit = $request->query('limit', 10); // Giới hạn số bản ghi trên mỗi trang
    
        // Lấy danh sách người dùng với phân trang
        $users = User::select(['id', 'username', 'email', 'role', 'image'])
            ->paginate($limit); // Phân trang tự động
    
        // Trả về kết quả
        return response()->json([
            'DT' => [
                'totalRows' => $users->total(), // Tổng số bản ghi
                'totalPages' => $users->lastPage(), // Tổng số trang
                'users' => $users->items(), // Danh sách người dùng
            ],
            'EC' => 0,
            'EM' => 'Get list participants succeed',
        ]);
    }
    public function getAllUsers() 
    {
        $users = User::select(['id', 'username', 'email', 'role', 'image'])->get();    
        return response()->json([
            'DT' => $users,
            'EC' => 0,
            'EM' => 'Get list users succeed',
        ]);
    }
    public function createUser(Request $request)
    {
        // Kiểm tra tính hợp lệ của dữ liệu
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'DT' => '',
                'EC' => -1,
                'EM' => 'Email '. $request->email . ' đã tồn tại'
            ], 400);
        }
        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'image' => $request->file('userImage') ? $request->file('userImage')->store('images', 'public') : null,
        ]);

        return response()->json([
            'DT' => [
                'user' => $user,
            ],
            'EC' => 0,
            'EM' => 'User created successfully',
        ]);
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'DT' => '',
                'EC' => -1,
                'EM' => 'id ' . $request->id . ' chưa có bản ghi nào', // Lấy lỗi đầu tiên
            ], 400);
        }
        // Tìm người dùng cần cập nhật
        $user = User::findOrFail($request->id);
        if ($request->has('username')) {
            $user->username = $request->username;
        }
    
        if ($request->has('role')) {
            $user->role = $request->role;
        }

        if ($request->hasFile('userImage')) {
            $user->image = $request->file('userImage')->store('images', 'public');
        }
        $user->save();

        return response()->json([
            'DT' => [
                'user' => $user,
            ],
            'EC' => 0,
            'EM' => 'User updated successfully',
        ]);
    }
    public function deleteUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'DT' => '',
                'EC' => -1,
                'EM' => 'id ' . $request->id . ' chưa có bản ghi nào', // Lấy lỗi đầu tiên
            ], 400);
        }
        if($request->id == 1 || $request->id == 2) {
            return response()->json([
                'DT' => '',
                'EC' => -1,
                'EM' => 'Không thể xóa user này',
            ], 400);
        }
        $user = User::withTrashed()->find($request->id);
        if ($user && $user->trashed()) {
            return response()->json([
                'DT' => $request->id,
                'EC' => -1,
                'EM' => 'Người dùng này đã bị xóa trước đó',
            ]);
        }   

        $user->delete();  // Sử dụng phương thức soft delete
    
        return response()->json([
            'DT' => $request->id,
            'EC' => 0,
            'EM' => 'User deleted successfully',
        ]);
    }
    
}
