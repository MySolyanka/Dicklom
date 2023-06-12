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
        $data = Data::find($id);

        if (!$data || !$data->file_path) {
            return response()->json(['error' => 'Файл не найден'], 404);
        }

        $file = Storage::path($data->file_path);
        $filename = basename($file);

        return response()->download($file, $filename);
    }
}
