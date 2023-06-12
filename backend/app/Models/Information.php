<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'group_name',
        'group_number',
        'sender_name',
        'message_topic',
        'message_text',
        'file_path',
    ];
}
