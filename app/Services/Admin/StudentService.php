<?php
namespace App\Services\Admin ;

use Illuminate\Support\Facades\Hash;

use App\Models\
{
    Student,
    User,
};

class StudentService
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

        $studentId = User::latest()->value('id');

        Student::create([
            'user_id' => $studentId,
            'class'   => $validated['class'],
        ]);
    }

    public function edit($studentId)
    {
        $student = User::with('student')->firstWhere('id',$studentId);
        return $student;
    }

    public function update($request ,$studentId)
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
    }

    public function trash($studentId)
    {
        $query = User::where('id',$studentId)->delete();
        if($query){
            return true;
        }

        return false;
    }

    public function forceDelete($studentId)
    {
        $query = User::where('id',$studentId)->forceDelete();
        if($query){
            return true;
        }

        return false;
    }

    public function restore($studentId)
    {
        $query = User::where('id',$studentId)->restore();
        if($query){
            return true;
        }

        return false;
    }
}
