<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\teacher\
{
    store as TeacherStore,
    update,
};
use App\Http\Resources\
{
    TeacherResource,
    UserResource
};
use App\Services\Admin\TeacherService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TeacherApiController extends Controller
{
    use ApiResponse;

    public function __construct(protected TeacherService $teacher)
    {
    }

    public function index(Request $request)
    {
        $info = $this->teacher->index($request->validated());

        if($info['teachers']->count() > 0){
            $data =
            [
                'teachers'               => TeacherResource::collection($info['teachers']),
                'count_teachers_trashed' => $info['count_teachers_trashed']
            ];
            $etag = md5(json_encode($data));

            if(($info['clientEtag'] && $info['clientEtag'] === $etag)){
                return $this->success(null,null,304)
                    ->header('ETag',$etag)
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

        return $this->error(__('messages.no_teachers'),null,404);
    }

    public function store(TeacherStore $request)
    {
        $teacher = $this->teacher->store($request);
        $data    = ['teacher' => new TeacherResource($teacher)];

        return $this->success($data,'Teacher created successfully',201)->header('Content-Length',strlen(json_encode($data)));
    }

    public function update(update $request ,$userId)
    {
        $teacher = $this->teacher->update($request,$userId);
        $data    = ['teacher' => new TeacherResource($teacher)];

        return $this->success($data,'Teacher updated successfully',200)->header('Content-Length',strlen(json_encode($data)));
    }

    public function trash($teacherId)
    {
        if($this->teacher->trash($teacherId)){
            return $this->success(null,'تم حذف المدرس مؤقتا',200);
        }

        return $this->error('هذا المدرس غير موجود !',null,404);
    }

    public function indexTrash(Request $request)
    {
        $info = $this->teacher->indexTrash($request->validated());

        if($info['teachers']->count()>0){
            $data = ['teachers' => UserResource::collection($info['teachers'])];
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

        return $this->error('There is no trashed teachers',null,404);
    }

    public function forceDelete($teacherId)
    {
        if($this->teacher->forceDelete($teacherId)){
            return $this->success(null,'تم حذف المدرس نهائيا',200);
        }

        $this->error('هذا المدرس غير موجود !',null,404);
    }

    public function restore($teacherId)
    {
        if($this->teacher->restore($teacherId)){
            return $this->success(null,'تم استرجاع المدرس بنجاح',200);
        }

        return $this->error('هذا المدرس غير موجود !',null,404);
    }
}
