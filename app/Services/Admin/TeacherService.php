<?php

namespace App\Services\Admin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use App\Models\
{
    Teacher,
    User,
};

class TeacherService
{
    public function index()
    {
        $teachers = Teacher::whereHas('user', function (Builder $query) {
                    $query->where('deleted_at' , NULL);})->get();

        $count_teachers_trashed = User::onlyTrashed()->where('user_as' , 'teacher')->count();

        return
        [
            'teachers'                => $teachers,
            'count_teachers_trashed'  => $count_teachers_trashed,
        ];
    }

    public function store($request)
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
    }

    public function edit($teacherId)
    {
        $teacher = User::with('teacher')->firstWhere('id',$teacherId);
        return $teacher;
    }

    public function update($request ,$teacherId)
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
    }

    public function trash($teacherId)
    {
        User::where('id',$teacherId)->delete();
    }

    public function indexTrash()
    {
        $teachers = User::with('teacher')->where('user_as','teacher')->onlyTrashed()->get();
        return $teachers;
    }

    public function forceDelete($teacherId)
    {
        User::where('id',$teacherId)->forceDelete();
    }

    public function restore($teacherId)
    {
        User::where('id',$teacherId)->restore();
    }
}
