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

        $lastModifiedHttp       = gmdate('D, d M Y H:i:s',$lastModified) . ' GMT';
        $count_students_trashed = User::onlyTrashed()->where('user_as' , 'student')->count();
        $clientEtag             = $request->header('If-None-Match');

        if($students->count() > 0){
            $data =
            [
                'status'                 => 'success',
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

        return response()->json([
            'status'                 => 'failed',
            'message'                =>  __('messages.no_students'),
            'count_students_trashed' => $count_students_trashed
        ],404)->header('Content-Type','application/json');
    }

    public function store(store $request , StudentService $Service)
    {
        $student = $Service->store($request);
        $data    =
        [
            'status'     => 'success',
            'message'    => 'Student created successfully',
            'student'    => new StudentResource($student)
        ];

        return response()->json($data,201)
                ->header('Content-Type','application/json')
                ->header('Content-Length',strlen(json_encode($data)));
    }

    public function update(update $request , $userId , StudentService $Service)
    {
        $student = $Service->update($request,$userId);
        $data    =
        [
            'status'   => 'success',
            'message'  => 'Student updated successfully',
            'student'  => new StudentResource($student)
        ];

        return response()->json($data,200)
                ->header('Content-Type','application/json')
                ->header('Content-Length',strlen(json_encode($data)));
    }

    public function trash($studentId , StudentService $Service)
    {
        if($Service->trash($studentId)){
            return response()->json([
                'status'  => 'success',
                'message' => 'تم حذف الطالب مؤقتا'
            ],200)->header('Content-Type','application/json');
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'هذا الطالب غير موجود !'
        ],404)->header('Content-Type','application/json');
    }

    public function indexTrash(Request $request)
    {
        $name     = $request->query('name');
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

        if($students->count() > 0){
            $data =
            [
                'status'   => 'success',
                'students' => UserResource::collection($students)
            ];
            $etag = md5(json_encode($data));

            if($clientEtag = $request->header('If-None-Match')){
                if($clientEtag === $etag){
                    return response()->noContent(304)
                            ->header('ETag',$etag)
                            ->header('Last-Modified',$lastModifiedHttp);
                }
            }

            if($request->header('If-Modified-Since')){
                $ifModifiedSinceTime = strtotime($request->header('If-Modified-Since'));
                if($ifModifiedSinceTime >= $lastModified){
                    return response()->noContent(304)
                            ->header('ETag',$etag)
                            ->header('Last-Modified',$lastModifiedHttp);
                }
            }

            return response()->json($data,200)
                    ->header('Content-Type','application/json')
                    ->header('Content-Length',strlen(json_encode($data)))
                    ->header('ETag',$etag)
                    ->header('Last-Modified',$lastModifiedHttp);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'There is no trashed students'
        ],404)->header('Content-Type','application/json');
    }

    public function forceDelete($studentId,StudentService $Service)
    {
        if($Service->forceDelete($studentId)){
            return response()->json([
                'status'  => 'success',
                'message' => 'تم حذف الطالب نهائيا'
            ],200)->header('Content-Type','application/json');
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'هذا الطالب غير موجود !'
        ],404)->header('Content-Type','application/json');
    }

    public function restore($studentId,StudentService $Service)
    {
        if($Service->restore($studentId)){
            return response()->json([
                'status'  => 'success',
                'message' => 'تم استرجاع الطالب بنجاح'
            ],200)->header('Content-Type','application/json');
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'هذا الطالب غير موجود !'
        ],404)->header('Content-Type','application/json');
    }
}
