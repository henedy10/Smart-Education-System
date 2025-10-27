<?php

namespace App\Services\Admin;
use Illuminate\Support\Facades\Hash;
use App\Models\
{
    Teacher,
    User,
};

class TeacherService
{
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
        $query = User::where('id',$teacherId)->delete();
        if($query){
            return true;
        }

        return false;
    }

    public function forceDelete($teacherId)
    {
        $query = User::where('id',$teacherId)->forceDelete();
        if($query){
            return true;
        }

        return false;
    }

    public function restore($teacherId)
    {
        $query = User::where('id',$teacherId)->restore();
        if($query){
            return true;
        }

        return false;
    }
}
