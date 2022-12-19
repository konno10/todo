<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Services\UserService;
use Illuminate\Support\Str;


class UserController extends Controller
{
    // ベーシック認証
    public function signin(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response()->json(['errorMessage' => 'このメールアドレスは登録されていません'], 500);
        }
        $user = User::where('email', $request['email'])
            ->where('password', $request['password'])->first();
        if (!$user) {
            return response()->json(['errorMessage' => 'パスワードが間違っています'], 500);
        }
        $return['token'] = $user['token'];
        return $return;
    }
    // ベアラー認証
    public function auth(Request $request)
    {
        return (new UserService())->getLoginInfoByToken($request->header('token'));
    }

    // 全てのユーザー情報・取得
    public function getUsers(Request $request)
    {
        $query = User::query();
        if ($request['keyword']) {
            $query->where('name', 'like', '%' . $request['keyword'] . '%');
        }
        $users = $query->select('id', 'name', 'email', 'password', 'img as img')
            ->get();

        $users = User::get();
        foreach ($users as $user) {
            $user['taskNum'] = Task::where('task_requested_user_id', $user['id'])
                ->count();
        }

        $return['users'] = $users;
        return $return;
    }

    // 特定のユーザー情報・取得
    public function getUser(Request $request)
    {
        return User::where('id', $request['id'])->first();
    }

    // 特定のユーザー情報・作成
    public function postUser(Request $request)
    {
        // 重複確認
        $existUser = User::where('email', $request['email'])->first();
        if ($existUser) {
            return response()->json(['errorMessage' => 'このメールアドレスは既に登録されています',], 500);
        }
        // 新規ユーザー登録
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
            'img' => $request['img'],
            'token' => $request['email'] . Str::random(100),
        ]);
    }

    // 特定のユーザー情報・更新
    public function putUser(Request $request)
    {
        if ($request['email']) {
            // 重複確認
            $existUser = User::where('email', $request['email'])->first();
            if ($existUser && $existUser['email'] != $request['email']) {
                return response()->json(['errorMessage' => 'このメールアドレスは既に登録されています',], 500);
            }
            User::where('id', $request['id'])->update([
                'email' => $request['email'],
            ]);
        }
        if ($request['name']) {
            User::where('id', $request['id'])->update([
                'name' => $request['name'],
            ]);
        }
        if ($request['password']) {
            User::where('id', $request['id'])->update([
                'password' => $request['password'],
            ]);
        }
        if ($request['img']) {
            User::where('id', $request['id'])->update([
                'img' => $request['img'],
            ]);
        }
    }
    public function deleteUser(Request $request)
    {
        return User::where('id', $request['id'])->delete();
    }
}
