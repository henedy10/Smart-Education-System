<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\teacher\
{
    store as TeacherStore,
    update,
};
use App\Services\Admin\TeacherService;

class TeacherController extends Controller
{

    public function index()
    {
        return view('admin.teacher.index');
    }

    public function create()
    {
        return view('admin.teacher.create');
    }

    public function store(TeacherStore $request ,TeacherService $Service)
    {
        $Service->store($request);
        return redirect()->back()->with(['successCreateMsg' => 'Teacher created successfully']);
    }

    public function edit($teacherId , TeacherService $Service)
    {
        $teacher = $Service->edit($teacherId);
        return view('admin.teacher.edit',compact('teacher'));
    }

    public function update(update $request ,$teacherId,TeacherService $Service)
    {
        $Service->update($request,$teacherId);
        return redirect()->back()->with(['successEditMsg' => 'Teacher updated successfully']);
    }

    public function trash($teacherId , TeacherService $Service)
    {
        $Service->trash($teacherId);
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف المدرس مؤقتا']);
    }

    public function indexTrash(TeacherService $Service)
    {
        $teachers = $Service->indexTrash();
        return view('admin.teacher.trash',compact('teachers'));
    }

    public function forceDelete($teacherId,TeacherService $Service)
    {
        $Service->forceDelete($teacherId);
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف المدرس نهائيا']);
    }

    public function restore($teacherId , TeacherService $Service)
    {
        $Service->restore($teacherId);
        return redirect()->back()->with(['successRestoreMsg' => 'تم استرجاع المدرس بنجاح']);
    }
}
