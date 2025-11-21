<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Requests\admin\student\
{
    store,
    update,
};
use App\Services\Admin\StudentService;
use App\Http\Controllers\Controller;
use App\Http\Resources\
{
    StudentResource,
    UserResource
};
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    public function __construct(protected StudentService $student)
    {
    }

    public function index(Request $request)
    {
        $info = $this->student->index($request->validated());

        if($info['students']->count() > 0)
        {
            $data =
            [
                'status'                 => 'success',
                'students'               => StudentResource::collection($info['students']),
                'count_students_trashed' => $info['count_students_trashed']
            ];
            $etag = md5(json_encode($data));

            if(($info['clientEtag'] && $info['clientEtag'] === $etag)){
                return response()->noContent(304)
                    ->header('ETag' , $etag)
                    ->header('Last-Modified',$info['lastModifiedHttp']);
            }

            if($request->header('If-Modified-Since')){
                $ifModifiedSinceTime = strtotime($request->header('If-Modified-Since'));
                if($ifModifiedSinceTime >= $info['lastModified']){
                    return response()->noContent(304)
                        ->header('ETag' , $etag)
                        ->header('Last-Modified',$info['lastModifiedHttp']);
                }
            }
            return response()->json($data,200)
                ->header('Content-Type','application/json')
                ->header('Content-Length',strlen(json_encode($data)))
                ->header('ETag',$etag)
                ->header('Last-Modified',$info['lastModifiedHttp']);
        }

        return response()->json([
            'status'                 => 'failed',
            'message'                =>  __('messages.no_students'),
            'count_students_trashed' => $info['count_students_trashed']
        ],404)->header('Content-Type','application/json');
    }

    public function store(store $request)
    {
        $student = $this->student->store($request->validated());
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

    public function update(update $request,$userId)
    {
        $student = $this->student->update($request->validated(),$userId);
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

    public function trash($studentId)
    {
        if($this->student->trash($studentId)){
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
        $info = $this->student->indexTrash($request->validated());

        if($info['students']->count() > 0){
            $data =
            [
                'status'   => 'success',
                'students' => UserResource::collection($info['students'])
            ];
            $etag = md5(json_encode($data));

            if($clientEtag = $request->header('If-None-Match')){
                if($clientEtag === $etag){
                    return response()->noContent(304)
                            ->header('ETag',$etag)
                            ->header('Last-Modified',$info['lastModifiedHttp']);
                }
            }

            if($request->header('If-Modified-Since')){
                $ifModifiedSinceTime = strtotime($request->header('If-Modified-Since'));
                if($ifModifiedSinceTime >= $info['lastModified']){
                    return response()->noContent(304)
                            ->header('ETag',$etag)
                            ->header('Last-Modified',$info['lastModifiedHttp']);
                }
            }

            return response()->json($data,200)
                    ->header('Content-Type','application/json')
                    ->header('Content-Length',strlen(json_encode($data)))
                    ->header('ETag',$etag)
                    ->header('Last-Modified',$info['lastModifiedHttp']);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'There is no trashed students'
        ],404)->header('Content-Type','application/json');
    }

    public function forceDelete($studentId)
    {
        if($this->student->forceDelete($studentId)){
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

    public function restore($studentId)
    {
        if($this->student->restore($studentId)){
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
