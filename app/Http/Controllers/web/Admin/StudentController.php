<?php

namespace App\Http\Controllers\web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\student\
{
    store,
    update,
};

use App\Services\Admin\StudentService;

class StudentController extends Controller
{
    public function index()
    {
        return view('admin.student.index');
    }

    public function create()
    {
        return view('admin.student.create');
    }

    public function store(store $request , StudentService $Service)
    {
        $Service->store($request);
        return redirect()->back()->with(['successCreateMsg' => 'Student created successfully']);
    }

    public function edit($studentId, StudentService $Service)
    {
        $student = $Service->edit($studentId);
        return view('admin.student.edit',compact('student'));
    }

    public function update(update $request , $studentId , StudentService $Service)
    {
        $Service->update($request,$studentId);
        return redirect()->back()->with(['successEditMsg' => 'Student updated successfully']);
    }

    public function trash($studentId , StudentService $Service)
    {
        $Service->trash($studentId);
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف الطالب مؤقتا']);
    }

    public function indexTrash()
    {
        return view('admin.student.trash');
    }

    public function forceDelete($studentId,StudentService $Service)
    {
        $Service->forceDelete($studentId);
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف الطالب نهائيا']);
    }

    public function restore($studentId,StudentService $Service)
    {
        $Service->restore($studentId);
        return redirect()->back()->with(['successRestoreMsg' => 'تم استرجاع الطالب بنجاح']);
    }
}
