<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function createcDummyTask($roomId)
    {
        Task::create([
            'task_name' => '洗い物',
            'task_default_minute' => 15,
            'task_is_everyday' => 1,
        ]);
        Task::create([
            'task_name' => '料理',
            'task_default_minute' => 30,
            'task_is_everyday' => 1,
        ]);
        Task::create([
            'task_name' => '洗濯',
            'task_default_minute' => 15,
            'task_is_everyday' => 1,
        ]);
    }
}
