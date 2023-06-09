<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
//    public function register(Request $request)
//    {
//        $validatedData = $request->validate([
//            'name' => 'required|string',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|string|min:6',
//        ]);
//
//        $user = User::create([
//            'name' => $validatedData['name'],
//            'email' => $validatedData['email'],
//            'password' => bcrypt($validatedData['password']),
//        ]);
//
//        // Возвращаем ответ с данными созданного пользователя
//        return response()->json(['user' => $user, 'message' => 'Регистрация прошла успешно'], 201);
//    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || $user->password !== $credentials['password']) {
            // Неверные учетные данные, возвращаем ошибку аутентификации
            return response()->json([
                'message' => 'Ошибка аутентификации',
            ], 401);
        }
        return response()->json([
            'message' => 'Аутентификация успешна',
        ]);
    }
//    {
//        $credentials = $request->only('email', 'password');
//
//        if (Auth::attempt($credentials)) {
//            $user = Auth::user();
//            $token = $user->createToken('MyApp');
//
//            // Возвращаем ответ с данными пользователя и токеном
//            return response()->json(['user' => $user, 'token' => $token->plainTextToken, 'message' => 'Авторизация успешна']);
//        } else {
//            // Ошибка аутентификации
//            return response()->json(['message' => 'Ошибка аутентификации'], 401);
//        }
//    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        // Возвращаем ответ с сообщением о успешном выходе
        return response()->json(['message' => 'Вы успешно вышли из системы']);
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || $user->password !== $credentials['password']) {
            // Неверные учетные данные, возвращаем ошибку аутентификации
            return response()->json([
                'message' => 'Ошибка аутентификации',
            ], 401);
        }

        // Аутентификация успешна, создаем токен аутентификации или отправляем успешный ответ с заголовком авторизации
        $token = $user->createToken('MyApp')->accessToken;

        return response()->json([
            'message' => 'Аутентификация успешна',
            'access_token' => $token,
        ]);
    }
}
