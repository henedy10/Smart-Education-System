<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\student\
{
    store,
    update,
};

use Illuminate\Support\Facades\Hash;

use App\Models\
{
    Student,
    User,
};


class StudentController extends Controller
{
    public function index()
    {
        $students = Student::whereHas('user', function (Builder $query) {
                    $query->where('deleted_at' , NULL);})->get();

        $count_students_trashed = User::onlyTrashed()->where('user_as' , 'student')->count();
        return view('admin.student.index',compact('students','count_students_trashed'));
    }
    public function create()
    {
        return view('admin.student.create');
    }

    public function store(store $request)
    {
        $validated = $request->validated();

        User::create([
            'user_as'  => $validated['user_as'],
            'email'    => $validated['email'],
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        $studentId = User::latest()->value('id');

        Student::create([
            'user_id' => $studentId,
            'class'   => $validated['class'],
        ]);

        return redirect()->back()->with(['successCreateMsg' => 'Student created successfully']);
    }

    public function edit($studentId)
    {
        $student = User::with('student')->firstWhere('id',$studentId);
        return view('admin.student.edit',compact('student'));
    }

    public function update(update $request , $studentId)
    {
        $validated = $request->validated();
        $user      = User::find($studentId);

        $user->update([
            'user_as'  => $validated['user_as'],
            'email'    => $validated['email'],
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        $student = Student::firstWhere('user_id' , $user->id);

        $student->update([
            'user_id' => $studentId,
            'class'   => $validated['class'],
        ]);

        return redirect()->back()->with(['successEditMsg' => 'Student updated successfully']);
    }

    public function trash($studentId)
    {
        User::where('id',$studentId)->delete();
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف الطالب مؤقتا']);
    }

    public function indexTrash()
    {
        $students = User::with('student')->where('user_as','student')->onlyTrashed()->get();
        return view('admin.student.trash',compact('students'));
    }

    public function forceDelete($studentId)
    {
        User::where('id',$studentId)->forceDelete();
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف الطالب نهائيا']);
    }

    public function restore($studentId)
    {
        User::where('id',$studentId)->restore();
        return redirect()->back()->with(['successRestoreMsg' => 'تم استرجاع الطالب بنجاح']);
    }
}
