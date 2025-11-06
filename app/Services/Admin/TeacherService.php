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

        $user = User::create([
            'user_as'  => $validated['user_as'],
            'email'    => $validated['email'],
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'class'   => $validated['class'],
            'subject' => $validated['subject'],
        ]);

        return $teacher->loadMissing('user');
    }

    public function edit($teacherId)
    {
        $teacher = User::with('teacher')->firstWhere('id',$teacherId);
        return $teacher;
    }

    public function update($request ,$userId)
    {
        $validated = $request->validated();
        $user      = User::findOrFail($userId);
        $updateData =
        [
            'user_as'  => $validated['user_as'],
            'email'    => $validated['email'],
            'name'     => $validated['name'],
        ];

        if(!empty($validated['password'])){
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        $teacher = Teacher::firstWhere('user_id' , $user->id);
        $teacher->update([
            'class'   => $validated['class'],
            'subject' => $validated['subject'],
        ]);

        return $teacher->loadMissing('user');
    }

    public function trash($teacherId)
    {
        $query = User::where('id',$teacherId)->delete();
        return $query ? true : false;
    }

    public function forceDelete($teacherId)
    {
        $query = User::where('id',$teacherId)->forceDelete();
        return $query ? true : false;
    }

    public function restore($teacherId)
    {
        $query = User::where('id',$teacherId)->restore();
        return $query ? true : false;
    }
}
