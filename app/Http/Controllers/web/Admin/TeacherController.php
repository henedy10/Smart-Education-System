<?php

namespace App\Http\Controllers\web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\teacher\
{
    store as TeacherStore,
    update,
};
use App\Services\Admin\TeacherService;

class TeacherController extends Controller
{
    public function __construct(protected TeacherService $Service)
    {
    }

    public function index()
    {
        return view('admin.teacher.index');
    }

    public function create()
    {
        return view('admin.teacher.create');
    }

    public function store(TeacherStore $request)
    {
        $this->Service->store($request);
        return redirect()->back()->with(['successCreateMsg' => 'Teacher created successfully']);
    }

    public function edit($teacherId)
    {
        $teacher = $this->Service->edit($teacherId);
        return view('admin.teacher.edit',compact('teacher'));
    }

    public function update(update $request ,$teacherId)
    {
        $this->Service->update($request,$teacherId);
        return redirect()->back()->with(['successEditMsg' => 'Teacher updated successfully']);
    }

    public function trash($teacherId)
    {
        $this->Service->trash($teacherId);
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف المدرس مؤقتا']);
    }

    public function indexTrash()
    {
        return view('admin.teacher.trash');
    }

    public function forceDelete($teacherId)
    {
        $this->Service->forceDelete($teacherId);
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف المدرس نهائيا']);
    }

    public function restore($teacherId)
    {
        $this->Service->restore($teacherId);
        return redirect()->back()->with(['successRestoreMsg' => 'تم استرجاع المدرس بنجاح']);
    }
}
