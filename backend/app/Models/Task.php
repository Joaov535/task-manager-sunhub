<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'updated_at',
        'status',
        'user_id'
    ];

    public static function createTask($data, $userId)
    {
        return self::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'user_id' => $userId
        ]);
    }

    public static function getAllTasks($userID)
    {
        return self::where('user_id', '=', $userID)->get();
    }
}
