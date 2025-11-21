<?php
namespace App\Services\Admin ;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

use App\Models\
{
    Student,
    User,
};

class StudentService
{
    public function index($data)
    {
        $name     = $data->query('name');
        $students = Student::with('user')->whereHas('user', function (Builder $query) use ($name) {
                    $query->whereNull('deleted_at')
                            ->where('name','LIKE','%'.$name.'%');})->get();

        $lastModified = $students->max(function($student){
            $studentUpdated = strtotime($student->updated_at);
            $userUpdated    = $student->user ? strtotime($student->user->updated_at) : 0;
            return max($studentUpdated,$userUpdated);
        });

        $lastModifiedHttp       = gmdate('D, d M Y H:i:s',$lastModified) . ' GMT';
        $count_students_trashed = User::onlyTrashed()->where('user_as' , 'student')->count();
        $clientEtag             = $data->header('If-None-Match');

        return [
            'students'               => $students,
            'lastModified'           => $lastModified,
            'lastModifiedHttp'       => $lastModifiedHttp,
            'count_students_trashed' => $count_students_trashed,
            'clientEtag'             => $clientEtag
        ];
    }

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

    public function indexTrash($data)
    {
        $name     = $data->query('name');
        $students = User::with('student')
                        ->where('user_as','student')
                        ->where('name','LIKE','%'.$name.'%')
                        ->onlyTrashed()
                        ->get();

        $lastModified = $students->max(function($student){
            $studentUpdated = $student->updated_at ? strtotime($student->updated_at) : 0;
            return $studentUpdated;
        });

        $lastModifiedHttp = gmdate('D, d M Y H:i:s',$lastModified) . ' GMT';

        return [
            'students'         => $students,
            'lastModified'     => $lastModified,
            'lastModifiedHttp' => $lastModifiedHttp
        ];
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
