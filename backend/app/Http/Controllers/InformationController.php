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
            //'file' => 'nullable|text',
            //'ext' => 'text',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        $data = $request->all();


        $model = new information(); // Создание новой модели
        $model->field1 = $data['group_name']; // Замените "field1" на имя поля в вашей таблице
        $model->field2 = $data['group_number'];
        $model->field2 = $data['sender_name'];
        $model->field2 = $data['message_topic'];
        $model->field2 = $data['message_text'];


        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Генерация уникального имени файла
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Сохранение файла в указанной папке с уникальным именем
            $filePath = $file->storeAs('/uploads/', $fileName); // Замените "your_directory" на путь к папке, в которую вы хотите сохранить файл

            $model->file_path = $filePath;
        }


        $model->save();








        // Создаем новую запись информации
//        $information = Information::create([
//            'group_name' => $request->input('group_name'),
//            'group_number' => $request->input('group_number'),
//            'sender_name' => $request->input('sender_name'),
//            'message_topic' => $request->input('message_topic'),
//            'message_text' => $request->input('message_text'),
//        ]);
//
//        // Если файл загружен, сохраняем его и обновляем путь к файлу в записи информации
//        if ($request->input('file')) {
//            $file = base64_decode($request->input('file'));
//            $file_path = uniqid() . '.' . $request->input('ext');
//            file_put_contents(public_path('/uploads/').$file_path, $file);
//            $information->file_path = $file_path;
//            $information->save();
//        }

        return response()->json(['message' => 'Информация успешно добавлена'], 200);
    }
}
