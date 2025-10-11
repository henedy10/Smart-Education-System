<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\teacher\
{
    store as TeacherStore,
    update,
};

use Illuminate\Support\Facades\Hash;

use App\Models\
{
    Teacher,
    User,
};



class TeacherController extends Controller
{

    public function index()
    {
        $teachers = Teacher::whereHas('user', function (Builder $query) {
                    $query->where('deleted_at' , NULL);})->get();

        $count_teachers_trashed = User::onlyTrashed()->where('user_as' , 'teacher')->count();
        return view('admin.teacher.index',compact('teachers','count_teachers_trashed'));
    }

    public function create()
    {
        return view('admin.teacher.create');
    }

    public function store(TeacherStore $request)
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

    public function edit($teacherId)
    {
        $teacher = User::with('teacher')->firstWhere('id',$teacherId);
        return view('admin.teacher.edit',compact('teacher'));
    }

    public function update(update $request ,$teacherId)
    {
        $validated = $request->validated();
        $user      = User::find($teacherId);

        $user->update([
            'user_as'  => $validated['user_as'],
            'email'    => $validated['email'],
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        $teacher = Teacher::firstWhere('user_id' , $user->id);
        $teacher->update([
            'user_id' => $teacherId,
            'class'   => $validated['class'],
            'subject' => $validated['subject'],
        ]);

        return redirect()->back()->with(['successEditMsg' => 'Teacher updated successfully']);
    }

    public function trash($teacherId)
    {
        User::where('id',$teacherId)->delete();
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف المدرس مؤقتا']);
    }

    public function indexTrash()
    {
        $teachers = User::with('teacher')->where('user_as','teacher')->onlyTrashed()->get();
        return view('admin.teacher.trash',compact('teachers'));
    }

    public function forceDelete($teacherId)
    {
        User::where('id',$teacherId)->forceDelete();
        return redirect()->back()->with(['successDeleteMsg' => 'تم حذف المدرس نهائيا']);
    }

    public function restore($teacherId)
    {
        User::where('id',$teacherId)->restore();
        return redirect()->back()->with(['successRestoreMsg' => 'تم استرجاع المدرس بنجاح']);
    }
}
