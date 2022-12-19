<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i  < 200; $i++) {
            $id = $i + 1;
            $month = $i < 100 ? 11 : 12;
            $randThree = $i % 3 + 1;
            $randFive = $i % 5 + 1;
            $randTwenty = $i % 20 + 1;
            $randTwentyAndFive = $randTwenty + $randFive;
            DB::table("tasks")->insert([
                [
                    "task_name" => "${id}番目のタスク",
                    "task_detail" => "${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細${id}番目のタスクの詳細",
                    "task_date_start" => "2022-${month}-${randTwenty}",
                    "task_date_end" => "2022-${month}-${randTwentyAndFive}",
                    "task_category_id" => $randThree,
                    "task_tag_id" => $randThree,
                    "task_priority" => $randThree,
                    "task_status" => $randFive,
                    "task_predicted_hours" => 11,
                    "task_actual_hours" => 12 + $randFive,
                    "task_requester_user_id" => $randThree,
                    "task_requested_user_id" => $randFive,
                ],
            ]);
        }
    }
}
