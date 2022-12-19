<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Tag;
use App\Models\Category;
use App\Services\UserService;
use App\Services\TaskService;


class TaskController extends Controller
{
    public function getTasks(Request $request)
    {
        $query = Task::query();

        if ($request['keyword']) {
            $query->where('task_name', 'like', '%' . $request['keyword'] . '%');
        }
        if ($request['requestedUserId']) {
            $query->where('task_requested_user_id', $request['requestedUserId']);
        }
        if ($request['requesterUserId']) {
            $query->where('task_requester_user_id', $request['requesterUserId']);
        }
        if ($request['categoryId']) {
            $query->where('task_category_id', $request['categoryId']);
        }
        if ($request['tagId']) {
            $query->where('task_tag_id', $request['tagId']);
        }
        if ($request['priority']) {
            $query->where('task_priority', $request['priority']);
        }
        if ($request['status']) {
            $query->where('task_status', $request['status']);
        }
        $dataStart = $request['dateStart'];
        $dateEnd = $request['dateEnd'];
        // 日付完全検索
        if ($request['isPerfect'] === "true") {
            if ($dataStart) {
                $query->where('task_date_start', '>=', $dataStart);
            }
            if ($dateEnd) {
                $query->where('task_date_end', '<=', $dateEnd);
            }
            // 日付検索
        } else {
            if ($dataStart) {
                $query->where(function ($query) use ($dataStart) {
                    $query->orwhere('task_date_start', '>=', $dataStart)
                        ->orwhere('task_date_end', '>=', $dataStart);
                });
            }
            if ($dateEnd) {
                $query->where(function ($query) use ($dateEnd) {
                    $query->orwhere('task_date_start', '<=', $dateEnd)
                        ->orwhere('task_date_end', '<=', $dateEnd);
                });
            }
        }
        $query->select(
            "task_id",
            "task_name",
            "task_detail",
            "task_date_start",
            "task_date_end",
            "task_category_id",
            "task_tag_id",
            "task_priority",
            "task_status",
            "task_predicted_hours",
            "task_actual_hours",
            "task_requester_user_id",
            "task_requested_user_id",
        );

        if ($request['page']) {
            $paginate = $query->orderBy('task_id', 'desc')->paginate(20, 0, 0, $request['page']);
            $tasks = $paginate->items();
            $return['paginate'] = [
                'currentPage' => $paginate->currentPage(),
                'lastPage' => $paginate->lastPage(),
                'perPage' => $paginate->perPage(),
                'firstItem' => $paginate->firstItem(),
                'lastItem' => $paginate->lastItem(),
                'total' => $paginate->total(),
            ];
        } else {
            $tasks = $query->orderBy('task_id', 'desc')->get();
        }
        foreach ($tasks as $task) {
            $task['category'] = Category::where('category_id', $task['task_category_id'])
                ->select("category_id as id", "category_name as name")
                ->first();
            if (!$task['category']) {
                $task['category'] = [
                    'id' => null,
                    'name' => null
                ];
            }
        }
        foreach ($tasks as $task) {
            $task['tag'] = Tag::where('tag_id', $task['task_tag_id'])
                ->select("tag_id as id", "tag_name as name")
                ->first();
            if (!$task['tag']) {
                $task['tag'] = [
                    'id' => null,
                    'name' => null
                ];
            }
        }
        foreach ($tasks as $task) {
            $task['requesterUser'] = User::where('id', $task['task_requester_user_id'])
                ->select("id", "name", "img")
                ->first();
            if (!$task['requesterUser']) {
                $task['requesterUser'] = [
                    'id' => null,
                    'name' => null,
                    'img' => null
                ];
            }
        }
        foreach ($tasks as $task) {
            $task['requestedUser'] = User::where('id', $task['task_requested_user_id'])
                ->select("id", "name", "img")
                ->first();
            if (!$task['requestedUser']) {
                $task['requestedUser'] = [
                    'id' => null,
                    'name' => null,
                    'img' => null
                ];
            }
        }

        $return['tasks'] = $tasks;
        return $return;
    }
    public function getTask(Request $request)
    {
        $task = Task::where('task_id', $request['id'])->first();
        if (!$task) return response()->json(['errorMessage' => 'このデータは存在しません'], 404);
        return $task;
    }
    public function postTask(Request $request)
    {
        return Task::create([
            'task_name' => $request['name'],
            'task_detail' => $request['detail'],
            'task_date_start' => $request['dateStart'],
            'task_date_end' => $request['dateEnd'],
            'task_category_id' => $request['categoryId'],
            'task_tag_id' => $request['tagId'],
            'task_priority' => $request['priority'],
            'task_status' => $request['status'],
            'task_predicted_hours' => $request['predictedSeconds'],
            'task_actual_hours' => $request['actualSeconds'],
            'task_requester_user_id' => $request['requesterUserId'],
            'task_requested_user_id' => $request['requestedUserId'],
        ]);
    }
    public function putTask(Request $request)
    {
        return Task::where('task_id', $request['id'])->update([
            'task_name' => $request['name'],
            'task_detail' => $request['detail'],
            'task_date_start' => $request['dateStart'],
            'task_date_end' => $request['dateEnd'],
            'task_category_id' => $request['categoryId'],
            'task_tag_id' => $request['tagId'],
            'task_priority' => $request['priority'],
            'task_status' => $request['status'],
            'task_predicted_hours' => $request['predictedSeconds'],
            'task_actual_hours' => $request['actualSeconds'],
            'task_requester_user_id' => $request['requesterUserId'],
            'task_requested_user_id' => $request['requestedUserId'],
        ]);
    }
    public function deleteTask(Request $request)
    {
        return Task::where('task_id', $request['id'])->delete();
    }
}
