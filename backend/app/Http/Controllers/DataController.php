<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Information;


class DataController extends Controller
{
    public function index()
    {
        $data = Information::all();

        $responseData = [];

        foreach ($data as $item) {
            $file = null;
            $filename = null;

            // Если путь к файлу есть в базе данных, получаем его
            if ($item->file_path) {
                $file = Storage::path($item->file_path);
                $filename = basename($file);
            }

            $responseData[] = [
                'id' => $item->id,
                'group_name' => $item->group_name,
                'group_number' => $item->group_number,
                'sender_name' => $item->sender_name,
                'message_topic' => $item->message_topic,
                'message_text' => $item->message_text,
                'file' => [
                    'url' => $file ? route('data.file', ['id' => $item->id]) : null,
                    'filename' => $filename
                ]
            ];
        }

        return response()->json($responseData);
    }

    public function downloadFile($id)
    {
        $data = Information::find($id);

        if (!$data || !$data->file_path) {
            return response()->json(['error' => 'Файл не найден'], 404);
        }

        $file = Storage::path($data->file_path);
        $filename = basename($file);

        // Создание временного файла
        $tempFile = tempnam(sys_get_temp_dir(), 'bot');
        copy($file, $tempFile);

        return response()->download($tempFile, $filename)->deleteFileAfterSend(true);
    }


    public function getById($id)
    {
        $data = Information::find($id);


        if (!$data) {
            return response()->json(['error' => 'Данные не найдены'], 404);
        }


        if ($data->file_path) {
            $file = Storage::path($data->file_path);
            $filename = basename($file);
        }

        $responseData[] = [
            'id' => $data->id,
            'group_name' => $data->group_name,
            'group_number' => $data->group_number,
            'sender_name' => $data->sender_name,
            'message_topic' => $data->message_topic,
            'message_text' => $data->message_text,
            'file' => [
                'url' => $file ? route('data.file', ['id' => $data->id]) : null,
                'filename' => $filename
            ]
        ];

        return response()->json($responseData);

    }
    public function updateById($id, Request $request)
    {
        $data = Information::find($id);

        if (!$data) {
            return response()->json(['error' => 'Данные не найдены'], 404);
        }

        // Удаляем предыдущий файл, если он существует
        if ($data->file_path) {
            Storage::delete($data->file_path);
        }

        // Загружаем новый файл
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Генерация уникального имени файла
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Сохранение файла в указанной папке с уникальным именем
            $filePath = $file->storeAs('/uploads', $fileName); // Замените "your_directory" на путь к папке, в которую вы хотите сохранить файл

            $data->file_path = $filePath;
        }

        // Обновляем остальные данные
        $data->update($request->all());

        return response()->json($data);
    }
}
