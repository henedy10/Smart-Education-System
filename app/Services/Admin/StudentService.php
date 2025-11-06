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

        $user = User::create([
            'user_as'  => $validated['user_as'],
            'email'    => $validated['email'],
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'class'   => $validated['class'],
        ]);

        return $student->loadMissing('user');
    }

    public function edit($studentId)
    {
        $student = User::with('student')->firstWhere('id',$studentId);
        return $student;
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

        $student = Student::firstWhere('user_id' , $user->id);

        $student->update(['class' => $validated['class']]);

        return $student->loadMissing('user');
    }

    public function trash($studentId)
    {
        $query = User::where('id',$studentId)->delete();
        return $query ? true : false;
    }

    public function forceDelete($studentId)
    {
        $query = User::where('id',$studentId)->forceDelete();
        return $query ? true : false;
    }

    public function restore($studentId)
    {
        $query = User::where('id',$studentId)->restore();
        return $query ? true : false;
    }
}
