<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Information;
use Illuminate\Support\Facades\Validator;

class InformationController extends Controller
{
    // ...

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'group_name' => 'required',
            'group_number' => 'required',
            'sender_name' => 'required',
            'message_topic' => 'required',
            'message_text' => 'required',
            'file' => 'nullable|file',
            'ext' => 'text',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        // Создаем новую запись информации
        $information = Information::create([
            'group_name' => $request->input('group_name'),
            'group_number' => $request->input('group_number'),
            'sender_name' => $request->input('sender_name'),
            'message_topic' => $request->input('message_topic'),
            'message_text' => $request->input('message_text'),
        ]);

        // Если файл загружен, сохраняем его и обновляем путь к файлу в записи информации
        if ($request->input('file')) {
            $file = base64_decode($request->input('file'));
            $file_path = public_path('/uploads/') . uniqid() . '.' . $request->input('ext');
            file_put_contents($file, $file_path);
            $information->file_path = $file_path;
            $information->save();
        }

        return response()->json(['message' => 'Информация успешно добавлена'], 200);
    }
}
