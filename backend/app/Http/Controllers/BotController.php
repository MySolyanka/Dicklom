<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Information;
class BotController extends Controller
{
    public function checkMessage(Request $request, $topic)
    {
        // Выполните здесь необходимую логику для проверки наличия записи в базе данных
        // и получения соответствующего сообщения

        // Пример: ищем запись с заданной темой в таблице "information"
        $information = Information::where('message_topic', $topic)->first();

        if ($information) {
            // Запись найдена
            $response = [
                'found' => true,
                'message' => $information->message_text,

            ];
            if ($information->file_path) {
                // Отправляем путь к файлу
                $response['id'] = $information->id;
            }
        } else {
            // Запись не найдена
            $response = [
                'found' => false,
                'message' => 'Запись не найдена',
            ];
        }

        return response()->json($response);
    }
}
