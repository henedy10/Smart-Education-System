<?php

namespace App\Services\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Models\
{
    Teacher,
    User,
};

class TeacherService
{
    public function index($data)
    {
        $name     = $data->query('name');
        $teachers = Teacher::with('user')->whereHas('user', function (Builder $query) use($name) {
                    $query->whereNull('deleted_at')
                        ->where('name','LIKE','%'.$name.'%')
                    ;})->get();

        $lastModified = $teachers->max(function($teacher){
            $teacherUpdated = strtotime($teacher->updated_at);
            $userUpdated    = $teacher->user ? strtotime($teacher->user->updated_at) : 0;
            return max($teacherUpdated,$userUpdated);
        });
        $lastModifiedHttp       = gmdate('D, d M Y H:i:s',$lastModified) . ' GMT';
        $clientEtag             = $data->header('If-None-Match');
        $count_teachers_trashed = User::onlyTrashed()->where('user_as' , 'teacher')->count();

        return [
            'teachers'               => $teachers,
            'lastModified'           => $lastModified,
            'lastModifiedHttp'       => $lastModifiedHttp,
            'clientEtag'             => $clientEtag,
            'count_teachers_trashed' => $count_teachers_trashed
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

    public function indexTrash($data)
    {
        $name     = $data->query('name');
        $teachers = User::with('teacher')
                        ->where('user_as','teacher')
                        ->where('name','LIKE','%'.$name.'%')
                        ->onlyTrashed()
                        ->get();

        $lastModified = $teachers->max(function($teacher){
            $teacherUpdated = $teacher->updated_at ? strtotime($teacher->updated_at) : 0;
            return $teacherUpdated;
        });

        $lastModifiedHttp = gmdate('D, d M Y H:i:s',$lastModified) . ' GMT';

        return [
            'teachers'         => $teachers,
            'lastModified'     => $lastModified,
            'lastModifiedHttp' => $lastModifiedHttp
        ];
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
