<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\TaskService;
use App\Models\Work;

class WorkController extends Controller
{
    public function read_calendar(Request $request)
    {
        $loginInfo = (new UserService())->getLoginInfoByToken($request->header('token'));
        // 日別データ
        $year_month = $request['year'] . '-' . $request['month'];
        $last_day = date('d', strtotime("last day of " . $year_month));

        $return['calendars'] = [];
        for ($day = 1; $day <= $last_day; $day++) {
            $calendar['date'] = date('Y-m-d', strtotime($year_month . '-' . $day));
            $calendar['minute'] = (int)Work::where('work_room_id', $loginInfo['user_room_id'])
                ->where('work_date', $calendar['date'])
                ->sum('work_minute');
            $calendar['users'] = (new UserService())->getJoinedUsersByRoomId($loginInfo['user_room_id']);
            foreach ($calendar['users'] as $user) {
                $user['minute'] = (int)Work::where('work_room_id', $loginInfo['user_room_id'])
                    ->where('work_date', $calendar['date'])
                    ->where('work_user_id', $user['id'])
                    ->sum('work_minute');
            }
            array_push($return['calendars'], $calendar);
        }
        return $return;
    }
    public function read_analytics(Request $request)
    {
        $loginInfo = (new UserService())->getLoginInfoByToken($request->header('token'));
        function getQuery($request)
        {
            $loginInfo = (new UserService())->getLoginInfoByToken($request->header('token'));
            $query = Work::where('work_room_id', $loginInfo['user_room_id']);
            if ($request['start_date']) {
                $query->where("work_date", ">=", $request['start_date']);
            }
            if ($request['last_date']) {
                $query->where("work_date", "<=", $request['last_date']);
            }
            return $query;
        }
        // 検索範囲
        if ($request['start_date'] && $request['last_date']) {
            $return['span'] = date('Y年m月d日', strtotime($request['start_date'])) . '~' . date('Y年m月d日', strtotime($request['last_date']));
        } elseif ($request['start_date']) {
            $return['span'] = date('Y年m月d日', strtotime($request['start_date'])) . '~';
        } elseif ($request['last_date']) {
            $return['span'] = '~' . date('Y年m月d日', strtotime($request['last_date']));
        } else {
            $return['span'] = '全期間';
        }

        // 合計値
        $return['minute'] = (int) getQuery($request)->sum('work_minute');

        // ユーザー別データ
        $return['users'] = (new UserService())->getJoinedUsersByRoomId($loginInfo['user_room_id']);
        foreach ($return['users'] as $user) {
            $user['minute'] = (int) getQuery($request)
                ->where('work_user_id', $user['id'])
                ->sum('work_minute');
            $user['ratio'] = $return['minute'] ? $user['minute'] / $return['minute'] : 0;
            $tasks = (new TaskService())->getTasksByRoomId($loginInfo['user_room_id']);
            foreach ($tasks as $task) {
                $task['minute'] = (int)getQuery($request)->where('work_task_id', $task['task_id'])
                    ->where('work_user_id', $user['id'])
                    ->sum('work_minute');
                $task['ratio'] = $user['minute'] ? $task['minute'] / $user['minute'] : 0;
            }
            $user['datas'] = $tasks;
        }

        // タスク別のデータ
        $return['tasks'] = (new TaskService())->getTasksByRoomId($loginInfo['user_room_id']);
        foreach ($return['tasks'] as $task) {
            $task['minute'] = (int)getQuery($request)->where('work_task_id', $task['task_id'])
                ->sum('work_minute');
            $task['ratio'] = $return['minute'] ? $task['minute'] / $return['minute'] : 0;
            $users = (new UserService())->getJoinedUsersByRoomId($loginInfo['user_room_id']);
            foreach ($users as $user) {
                $user['minute'] = (int)getQuery($request)->where('work_task_id', $task['task_id'])
                    ->where('work_user_id', $user['id'])
                    ->sum('work_minute');
                $user['ratio'] = $task['minute'] ? $user['minute'] / $task['minute'] : 0;
            }
            $task['datas'] = $users;
        }

        return $return;
    }
    public function create(Request $request)
    {
        $loginInfo = (new UserService())->getLoginInfoByToken($request->header('token'));
        Work::where('work_date', $request['date'])
            ->where('work_task_id', $request['task_id'])
            ->delete();

        foreach ($request['works'] as $work) {
            Work::create([
                'work_date' => $request['date'],
                'work_room_id' => $loginInfo['user_room_id'],
                'work_task_id' => $request['task_id'],
                'work_user_id' => $work['work_user_id'],
                'work_minute' => $work['work_minute'],
            ]);
        }
        return $request;
    }
    public function delete(Request $request)
    {
        $loginInfo = (new UserService())->getLoginInfoByToken($request->header('token'));
        Work::where('work_date', $request['date'])
            ->where('work_task_id', $request['task_id'])
            ->where('work_room_id', $loginInfo['user_room_id'])
            ->delete();
    }
}
