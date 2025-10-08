<?php

namespace App\Http\Controllers\admin;

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
        $students = Student::with('user')->get();
        return view('admin.student.index',compact('students'));
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

    public function teacherIndex()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.teacher.index',compact('teachers'));
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
}
