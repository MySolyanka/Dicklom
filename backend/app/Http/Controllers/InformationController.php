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
            'message_text' => 'nullable|string',
            //'file' => 'nullable|file',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $data = $request->all();






        $model = new Information(); // Создание новой модели
        $model->group_name = $data['group_name']; // Замените "field1" на имя поля в вашей таблице
        $model->group_number = $data['group_number'];
        $model->sender_name = $data['sender_name'];
        $model->message_topic = $data['message_topic'];

        $message_text = $data['message_text'];
        if ($message_text)
            $model->message_text = $data['message_text'];

        $file = $data['file'];
        if ($file != 'null') {
            $file = $request->file('file');

            // Генерация уникального имени файла
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Сохранение файла в указанной папке с уникальным именем
            $filePath = $file->storeAs('/uploads', $fileName); // Замените "your_directory" на путь к папке, в которую вы хотите сохранить файл

            $model->file_path = $filePath;
        }


        $model->save();

        return response()->json(['message' => 'Информация успешно добавлена'], 200);
    }

}
