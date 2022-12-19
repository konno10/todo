<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Task;

class TagController extends Controller
{
    // 全てのカテゴリー情報・取得
    public function getTags(Request $request)
    {
        $tags = Tag::get();
        foreach ($tags as $tag) {
            $tag['taskNum'] = Task::where('task_tag_id', $tag['tag_id'])
                ->count();
        }
        return $tags;
    }

    // 特定のカテゴリー情報・取得
    public function getTag(Request $request)
    {
        $tag = Tag::where('tag_id', $request['id'])->first();
        if (!$tag) return response()->json(['errorMessage' => 'このデータは存在しません'], 404);
        return $tag;
    }

    // 特定のカテゴリー情報・作成
    public function postTag(Request $request)
    {
        return Tag::create([
            'tag_name' => $request['name'],
            'tag_detail' => $request['detail'],
        ]);
    }

    // 特定のカテゴリー情報・更新
    public function putTag(Request $request)
    {
        if ($request['name']) {
            Tag::where('tag_id', $request['id'])->update([
                'tag_name' => $request['name'],
            ]);
        }
        if ($request['detail']) {
            Tag::where('tag_id', $request['id'])->update([
                'tag_detail' => $request['detail'],
            ]);
        }
    }

    // 特定のカテゴリー情報・更新
    public function deleteTag(Request $request)
    {
        return Tag::where('tag_id', $request['id'])->delete();
    }
}
