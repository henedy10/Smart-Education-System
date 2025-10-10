<?php

namespace App\Http\Controllers\admin;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\student\store;
use App\Http\Requests\admin\teacher\store as TeacherStore;
use App\Models\
{
    Student,
    Teacher,
    User,
};

use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index()
    {
        $userId         = session('id');
        $dashboard      = User::firstWhere('id',$userId);
        $count_teachers = Teacher::count();
        $count_students = Student::count();

        return view('admin.dashboard' , compact('dashboard','count_teachers','count_students'));
    }

    public function studentIndex()
    {
        $students = Student::whereHas('user', function (Builder $query) {
                    $query->where('deleted_at' , NULL);})->get();

        $count_students_trashed = User::onlyTrashed()->where('user_as' , 'student')->count();
        return view('admin.student.index',compact('students','count_students_trashed'));
    }
    public function studentCreate()
    {
        return view('admin.student.create');
    }

    public function studentStore(store $request)
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

    public function studentTrash($studentId)
    {
        User::where('id',$studentId)->delete();
        return redirect()->back();
    }

    public function studentIndexTrash()
    {
        $students = User::with('student')->onlyTrashed()->get();
        return view('admin.student.trash',compact('students'));
    }

    public function studentForceDelete($studentId)
    {
        User::where('id',$studentId)->forceDelete();
        return redirect()->back();
    }

    public function studentRestore($studentId)
    {
        User::where('id',$studentId)->restore();
        return redirect()->back();
    }



    public function teacherIndex()
    {
        $teachers = Teacher::whereHas('user', function (Builder $query) {
                    $query->where('deleted_at' , NULL);})->get();

        $count_teachers_trashed = User::onlyTrashed()->where('user_as' , 'teacher')->count();
        return view('admin.teacher.index',compact('teachers','count_teachers_trashed'));
    }

    public function teacherCreate()
    {
        return view('admin.teacher.create');
    }

    public function teacherStore(TeacherStore $request)
    {
        $validated = $request->validated();

        User::create([
            'user_as'  => $validated['user_as'],
            'email'    => $validated['email'],
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        $teacherId = User::latest()->value('id');

        Teacher::create([
            'user_id' => $teacherId,
            'class'   => $validated['class'],
            'subject' => $validated['subject'],
        ]);

        return redirect()->back()->with(['successCreateMsg' => 'Teacher created successfully']);
    }

    public function teacherTrash($teacherId)
    {
        User::where('id',$teacherId)->delete();
        return redirect()->back();
    }

    public function teacherIndexTrash()
    {
        $teachers = User::with('teacher')->onlyTrashed()->get();
        return view('admin.teacher.trash',compact('teachers'));
    }

    public function teacherForceDelete($teacherId)
    {
        User::where('id',$teacherId)->forceDelete();
        return redirect()->back();
    }

    public function teacherRestore($teacherId)
    {
        User::where('id',$teacherId)->restore();
        return redirect()->back();
    }
}
