<?php

namespace App\Http\Controllers\api\Admin;

use App\Models\
{
    User,
    Student,
};
use App\Http\Requests\admin\student\
{
    store,
    update,
};
use App\Services\Admin\StudentService;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function index(Request $request)
    {
        $name     = $request->query('name');
        $students = Student::whereHas('user', function (Builder $query) use ($name) {
                    $query->whereNull('deleted_at')
                            ->where('name','LIKE','%'.$name.'%');})->get();

        $count_students_trashed = User::onlyTrashed()->where('user_as' , 'student')->count();

        if($students->count() > 0){
            return response()->json([
                'status'                 => 'Success',
                'students'               => $students,
                'count_students_trashed' => $count_students_trashed
            ],200);
        }

        return response()->json([
            'status'                 => 'Failed',
            'students'               =>  __('messages.no_students'),
            'count_students_trashed' => $count_students_trashed
        ],404);
    }

    public function store(store $request , StudentService $Service)
    {
        $Service->store($request);
        return response()->json([
            'status'  => 'Success',
            'message' => 'Student created successfully'
        ],201);
    }

    public function update(update $request , $studentId , StudentService $Service)
    {
        $Service->update($request,$studentId);
        return response()->json([
            'status'  => 'Success',
            'message' => 'Student updated successfully'
        ],200);
    }

    public function trash($studentId , StudentService $Service)
    {
        if($Service->trash($studentId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم حذف الطالب مؤقتا'
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا الطالب غير موجود !'
        ],404);
    }

    public function indexTrash(Request $request)
    {
        $name     = $request->query('name');
        $students = User::with('student')
                        ->where('user_as','student')
                        ->where('name','LIKE','%'.$name.'%')
                        ->onlyTrashed()
                        ->get();

        if($students->count()>0){
            return response()->json([
                'status' => 'Success',
                'students' => $students
            ],200);
        }

        return response()->json([
            'status' => 'Failed',
            'message' => 'There is no trashed students'
        ],404);
    }

    public function forceDelete($studentId,StudentService $Service)
    {
        if($Service->forceDelete($studentId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم حذف الطالب نهائيا'
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا الطالب غير موجود !'
        ],404);
    }

    public function restore($studentId,StudentService $Service)
    {
        if($Service->restore($studentId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم استرجاع الطالب بنجاح'
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا الطالب غير موجود !'
        ],404);
    }
}
