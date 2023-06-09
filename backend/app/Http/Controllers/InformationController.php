<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;

class InformationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'group_name' => 'required',
            'group_number' => 'required',
            'sender_name' => 'required',
            'message_topic' => 'required',
            'message_text' => 'required',
            'file' => 'nullable|file',
        ]);

        // Создаем новую запись информации
        $information = Information::create([
            'group_name' => $data['group_name'],
            'group_number' => $data['group_number'],
            'sender_name' => $data['sender_name'],
            'message_topic' => $data['message_topic'],
            'message_text' => $data['message_text'],
        ]);

        // Если файл загружен, сохраняем его и обновляем путь к файлу в записи информации
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_path = $file->store('files');
            $information->file_path = $file_path;
            $information->save();
        }

        return response()->json(['message' => 'Информация успешно добавлена'], 200);
    }
}
