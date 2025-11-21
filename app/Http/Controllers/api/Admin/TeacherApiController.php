<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\teacher\
{
    store as TeacherStore,
    update,
};
use App\Http\Resources\TeacherResource;
use App\Http\Resources\UserResource;
use App\Services\Admin\TeacherService;
use Illuminate\Http\Request;

class TeacherApiController extends Controller
{
    public function __construct(protected TeacherService $teacher)
    {
    }

    public function index(Request $request)
    {
        $info = $this->teacher->index($request->validated());

        if($info['teachers']->count() > 0){
            $data =
            [
                'status'                 => 'Success',
                'teachers'               => TeacherResource::collection($info['teachers']),
                'count_teachers_trashed' => $info['count_teachers_trashed']
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
            'status'                 => 'Failed',
            'teachers'               =>  __('messages.no_teachers'),
            'count_teachers_trashed' => $info['count_teachers_trashed']
        ],404)->header('Content-Type','application/json');
    }

    public function store(TeacherStore $request)
    {
        $teacher = $this->teacher->store($request);
        $data    =
        [
            'status'  => 'Success',
            'message' => 'Teacher created successfully',
            'teacher' => new TeacherResource($teacher)
        ];

        return response()->json($data,201)
                ->header('Content-Type','application/json')
                ->header('Content-Length',strlen(json_encode($data)));
    }

    public function update(update $request ,$userId)
    {
        $teacher = $this->teacher->update($request,$userId);
        $data    =
        [
            'status'  => 'Success',
            'message' => 'Teacher updated successfully',
            'teacher' => new TeacherResource($teacher)
        ];

        return response()->json($data,200)
                ->header('Content-Type','application/json')
                ->header('Content-Length',strlen(json_encode($data)));
    }

    public function trash($teacherId)
    {
        if($this->teacher->trash($teacherId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم حذف المدرس مؤقتا'
            ],200)->header('Content-Type','application/json');
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا المدرس غير موجود !'
        ],404)->header('Content-Type','application/json');
    }

    public function indexTrash(Request $request)
    {
        $info = $this->teacher->indexTrash($request->validated());

        if($info['teachers']->count()>0){
            $data =
            [
                'status'   => 'Success',
                'teachers' => UserResource::collection($info['teachers'])
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
            return response()->json($data,200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'There is no trashed teachers'
        ],404)->header('Content-Type','application/json');
    }

    public function forceDelete($teacherId)
    {
        if($this->teacher->forceDelete($teacherId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم حذف المدرس نهائيا'
            ],200)->header('Content-Type','application/json');
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا المدرس غير موجود !'
        ],404)->header('Content-Type','application/json');
    }

    public function restore($teacherId)
    {
        if($this->teacher->restore($teacherId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم استرجاع المدرس بنجاح'
            ],200)->header('Content-Type','application/json');
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا المدرس غير موجود !'
        ],404)->header('Content-Type','application/json');
    }
}
