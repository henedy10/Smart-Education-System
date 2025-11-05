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
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function index(Request $request)
    {
        $name     = $request->query('name');
        $students = Student::with('user')->whereHas('user', function (Builder $query) use ($name) {
                    $query->whereNull('deleted_at')
                            ->where('name','LIKE','%'.$name.'%');})->get();

        $lastModified = $students->max(function($student){
            $studentUpdated = strtotime($student->updated_at);
            $userUpdated    = $student->user ? strtotime($student->user->updated_at) : 0;
            return max($studentUpdated,$userUpdated);
        });

        $lastModifiedHttp = gmdate('D, d M Y H:i:s',$lastModified) . ' GMT';
        $count_students_trashed = User::onlyTrashed()->where('user_as' , 'student')->count();
        $clientEtag = $request->header('If-None-Match');
        if($students->count() > 0){
            $data =
            [
                'status'                 => 'Success',
                'students'               => StudentResource::collection($students),
                'count_students_trashed' => $count_students_trashed
            ];
            $etag = md5(json_encode($data));

            if(($clientEtag && $clientEtag === $etag)){
                return response()->noContent(304)
                    ->header('ETag' , $etag)
                    ->header('Last-Modified',$lastModifiedHttp);
            }

            if($request->header('If-Modified-Since')){
                $ifModifiedSinceTime = strtotime($request->header('If-Modified-Since'));
                if($ifModifiedSinceTime >= $lastModified){
                    return response()->noContent(304)
                        ->header('ETag' , $etag)
                        ->header('Last-Modified',$lastModifiedHttp);
                }
            }
            return response()->json($data,200)
                ->header('Content-Type','application/json')
                ->header('Content-Length',strlen(json_encode($data)))
                ->header('ETag',$etag)
                ->header('Last-Modified',$lastModifiedHttp);
        }

        $data =
        [
            'status'                 => 'Failed',
            'students'               =>  __('messages.no_students'),
            'count_students_trashed' => $count_students_trashed
        ];

        return response()->json($data,404)
                ->header('Content-Type','application/json');
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
                'status'   => 'Success',
                'students' => UserResource::collection($students)
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
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
