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
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    use ApiResponse;

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
                'students'               => StudentResource::collection($info['students']),
                'count_students_trashed' => $info['count_students_trashed']
            ];
            $etag = md5(json_encode($data));

            if(($info['clientEtag'] && $info['clientEtag'] === $etag)){
                return $this->success(null,null,304)
                    ->header('ETag' , $etag)
                    ->header('Last-Modified',$info['lastModifiedHttp']);
            }

            if($request->header('If-Modified-Since')){
                $ifModifiedSinceTime = strtotime($request->header('If-Modified-Since'));
                if($ifModifiedSinceTime >= $info['lastModified']){
                    return $this->success(null,null,304)
                        ->header('ETag' , $etag)
                        ->header('Last-Modified',$info['lastModifiedHttp']);
                }
            }
            return $this->success($data,null,200)
                ->header('Content-Length',strlen(json_encode($data)))
                ->header('ETag',$etag)
                ->header('Last-Modified',$info['lastModifiedHttp']);
        }

        return $this->error(__('messages.no_students'),null,404);
    }

    public function store(store $request)
    {
        $student = $this->student->store($request->validated());
        $data    = ['student' => new StudentResource($student)];

        return $this->success($data,'Student created successfully',201)->header('Content-Length',strlen(json_encode($data)));
    }

    public function update(update $request,$userId)
    {
        $student = $this->student->update($request->validated(),$userId);
        $data    = ['student' => new StudentResource($student)];

        return $this->success($data,'Student updated successfully',200)->header('Content-Length',strlen(json_encode($data)));
    }

    public function trash($studentId)
    {
        if($this->student->trash($studentId)){
            return $this->success(null,'تم حذف الطالب مؤقتا',200);
        }

        return $this->error('هذا الطالب غير موجود !',null,404);
    }

    public function indexTrash(Request $request)
    {
        $info = $this->student->indexTrash($request->validated());

        if($info['students']->count() > 0){
            $data = ['students' => UserResource::collection($info['students'])];
            $etag = md5(json_encode($data));

            if($clientEtag = $request->header('If-None-Match')){
                if($clientEtag === $etag){
                    return $this->success(null,null,304)
                            ->header('ETag',$etag)
                            ->header('Last-Modified',$info['lastModifiedHttp']);
                }
            }

            if($request->header('If-Modified-Since')){
                $ifModifiedSinceTime = strtotime($request->header('If-Modified-Since'));
                if($ifModifiedSinceTime >= $info['lastModified']){
                    return $this->success(null,null,304)
                            ->header('ETag',$etag)
                            ->header('Last-Modified',$info['lastModifiedHttp']);
                }
            }

            return $this->success($data,null,200)
                    ->header('Content-Length',strlen(json_encode($data)))
                    ->header('ETag',$etag)
                    ->header('Last-Modified',$info['lastModifiedHttp']);
        }

        return $this->error('There is no trashed students',null,404);
    }

    public function forceDelete($studentId)
    {
        if($this->student->forceDelete($studentId)){
            return $this->success(null,'تم حذف الطالب نهائيا',200);
        }

        return $this->error('هذا الطالب غير موجود !',null,404);
    }

    public function restore($studentId)
    {
        if($this->student->restore($studentId)){
            return $this->success(null,'تم استرجاع الطالب بنجاح',200);
        }

        return $this->error('هذا الطالب غير موجود !',null,404);
    }
}
