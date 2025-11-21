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
    public function __construct(protected StudentService $Service)
    {
    }

    public function index()
    {
        return view('admin.student.index');
    }

    public function create()
    {
        return view('admin.student.create');
    }

    public function store(store $request)
    {
        $this->Service->store($request);
        return redirect()->back()->with(['successCreateMsg' => 'Student created successfully']);
    }

    public function edit($studentId,)
    {
        $student = $this->Service->edit($studentId);
        return view('admin.student.edit',compact('student'));
    }

    public function update(update $request,$studentId)
    {
        $this->Service->update($request,$studentId);
        return redirect()->back()->with(['successEditMsg' => 'Student updated successfully']);
    }

    public function trash($studentId)
    {
        $this->Service->trash($studentId);
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف الطالب مؤقتا']);
    }

    public function indexTrash()
    {
        return view('admin.student.trash');
    }

    public function forceDelete($studentId)
    {
        $this->Service->forceDelete($studentId);
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف الطالب نهائيا']);
    }

    public function restore($studentId)
    {
        $this->Service->restore($studentId);
        return redirect()->back()->with(['successRestoreMsg' => 'تم استرجاع الطالب بنجاح']);
    }
}
