<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TagsController extends Controller
{
    public function tagsList()
    {
        $tags = DB::table('tags')
            -> select('id', 'name',
                DB::raw('(SELECT count(a.id) FROM bl_articles as a 
                WHERE a.inTrash = 0 AND a.tagId = bl_tags.id) as articlesCount'))
            -> where('inTrash', 0)
            -> get();
        return view('admin.contents.tags.list', ['tags' => $tags]);
    }

    public function storeTag(Request $request)
    {
        $data = $request -> except(['_token', '_url']);
        $roles = [
            'id' => 'sometimes|exists:tags,id,inTrash,0',
            'name' => 'required|max:10' . (isset($data['id']) ? '|unique:tags,name,'.$request -> id : ''),
        ];
        $messages = [
            'id.exists' => '该标签不存在或已删除！',
            'name.required' => '请输入标签名称！',
            'name.max' => '标签名称长度最大为10！',
            'name.unique' => '该标签名称已经存在！',
        ];
        $this -> validate($request, $roles, $messages);
        try {
            if (isset($data['id'])) {
                if ($data['id'] == 1) {
                    return redirect('/admin/contents/tags') -> with('error', '无法编辑或删除默认标签！');
                }
                DB::table('tags')
                    -> where('id', $data['id'])
                    -> update($data);
            } else {
                DB::table('tags')
                    -> insert($data);
            }
            Redis::del('TAGS');
            return redirect('/admin/contents/tags') -> with('success', '保存成功');
        } catch (\Exception $e) {
            return redirect('/admin/contents/tags') -> with('error', '保存标签失败，错误原因：' . $e -> getMessage());
        }
    }

    public function deleteTag($id = 0)
    {
        if ($id == 1) {
            return redirect('/admin/contents/tags') -> with('error', '无法编辑或删除默认标签！');
        }
        try {
            DB::beginTransaction();
            DB::table('tags')
                -> where('id', $id)
                -> update(['inTrash' => 1]);
            DB::table('articles')
                -> where('tagId', $id)
                -> update(['tagId' => 1]);
            Redis::del('TAGS');
            DB::commit();
            return redirect('/admin/contents/tags') -> with('success', '删除标签成功，请到回收站中查看！');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/contents/tags') -> with('error', '删除失败，错误原因：' . $e -> getMessage());
        }
    }
}
