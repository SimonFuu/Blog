<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CatalogsController extends AdminController
{
    public function catalogsList()
    {
        $catalogs = DB::table('catalogs')
            -> select('id', 'name', 'displayWeight',
                DB::raw('(SELECT count(a.id) FROM bl_articles as a 
                WHERE a.inTrash = 0 AND a.catalogId = bl_catalogs.id) as articlesCount'))
            -> where('inTrash', 0)
            -> orderBy('displayWeight', 'ASC')
            -> get();
        return view('admin.contents.catalogs.list', ['catalogs' => $catalogs]);
    }

    public function storeCatalog(Request $request)
    {
        $data = $request -> except(['_token', '_url']);
        $roles = [
            'id' => 'sometimes|exists:catalogs,id,inTrash,0',
            'name' => 'required|max:10' . (isset($data['id']) ? '|unique:catalogs,name,'.$request -> id : ''),
            'displayWeight' => 'required|numeric|min:1|max:1000'
        ];
        $messages = [
            'id.exists' => '该目录不存在或已删除！',
            'name.required' => '请输入目录名称！',
            'name.max' => '目录名称长度最大为10！',
            'name.unique' => '该目录名称已经存在！',
            'displayWeight.required' => '请输入展示权重！',
            'displayWeight.numeric' => '展示权重需为1-1000的数字！',
            'displayWeight.min' => '展示权重需为1-1000的数字！',
            'displayWeight.max' => '展示权重需为1-1000的数字！',
        ];
        $this -> validate($request, $roles, $messages);
        try {
            if (isset($data['id'])) {
                DB::table('catalogs')
                    -> where('id', $data['id'])
                    -> update($data);
            } else {
                DB::table('catalogs')
                    -> insert($data);
            }
            Redis::del('CATALOGS');
            return redirect('/admin/contents/catalogs') -> with('success', '保存成功');
        } catch (\Exception $e) {
            return redirect('/admin/contents/catalogs') -> with('error', '保存目录失败，错误原因：' . $e -> getMessage());
        }
    }

    public function editCatalog($id = 0)
    {
        if ($id == 1) {
            return redirect('/admin/contents/catalogs') -> with('error', '无法编辑或删除默认目录！');
        }
        $catalog = DB::table('catalogs')
            -> select('id', 'name', 'displayWeight')
            -> where('inTrash', 0)
            -> where('id', $id)
            -> first();
        if (is_null($catalog)) {
            return redirect('/admin/contents/catalogs') -> with('error', '该目录不存在或已删除！');
        }
        return view('admin.contents.catalogs.add', ['catalog' => $catalog]);
    }

    public function deleteCatalog($id = 0)
    {
        if ($id == 1) {
            return redirect('/admin/contents/catalogs') -> with('error', '无法编辑或删除默认目录！');
        }
        try {
            DB::beginTransaction();
            DB::table('catalogs')
                -> where('id', $id)
                -> update(['inTrash' => 1]);
            DB::table('articles')
                -> where('catalogId', $id)
                -> update(['catalogId' => 1]);
            Redis::del('CATALOGS');
            DB::commit();
            return redirect('/admin/contents/catalogs') -> with('success', '删除目录成功，请到回收站中查看！');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/admin/contents/catalogs') -> with('error', '删除失败，错误原因：' . $e -> getMessage());
        }
    }
}
