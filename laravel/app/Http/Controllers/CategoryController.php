<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Task;

class CategoryController extends Controller
{
    // 全てのカテゴリー情報・取得
    public function getCategories(Request $request)
    {
        $categories = Category::get();
        foreach ($categories as $category) {
            $category['taskNum'] = Task::where('task_category_id', $category['category_id'])
                ->count();
        }
        return $categories;
    }

    // 特定のカテゴリー情報・取得
    public function getCategory(Request $request)
    {
        $category = Category::where('category_id', $request['id'])->first();
        if (!$category) return response()->json(['errorMessage' => 'このデータは存在しません'], 404);
        return $category;
    }

    // 特定のカテゴリー情報・作成
    public function postCategory(Request $request)
    {
        return Category::create([
            'category_name' => $request['name'],
            'category_detail' => $request['detail'],
        ]);
    }

    // 特定のカテゴリー情報・更新
    public function putCategory(Request $request)
    {
        if ($request['name']) {
            Category::where('category_id', $request['id'])->update([
                'category_name' => $request['name'],
            ]);
        }
        if ($request['detail']) {
            Category::where('category_id', $request['id'])->update([
                'category_detail' => $request['detail'],
            ]);
        }
    }

    // 特定のカテゴリー情報・更新
    public function deleteCategory(Request $request)
    {
        return Category::where('category_id', $request['id'])->delete();
    }
}
