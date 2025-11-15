<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\Controller;
use App\Models\
{
    Teacher,
    User,
};
use App\Http\Requests\admin\teacher\
{
    store as TeacherStore,
    update,
};
use App\Http\Resources\TeacherResource;
use App\Http\Resources\UserResource;
use App\Services\Admin\TeacherService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TeacherApiController extends Controller
{
    public function index(Request $request)
    {
        $name     = $request->query('name');
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
        $clientEtag             = $request->header('If-None-Match');
        $count_teachers_trashed = User::onlyTrashed()->where('user_as' , 'teacher')->count();

        if($teachers->count() > 0){
            $data =
            [
                'status'                 => 'Success',
                'teachers'               => TeacherResource::collection($teachers),
                'count_teachers_trashed' => $count_teachers_trashed
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
            'status'                 => 'Failed',
            'teachers'               =>  __('messages.no_teachers'),
            'count_teachers_trashed' => $count_teachers_trashed
        ],404)->header('Content-Type','application/json');
    }

    public function store(TeacherStore $request ,TeacherService $Service)
    {
        $teacher = $Service->store($request);
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

    public function update(update $request ,$userId,TeacherService $Service)
    {
        $teacher = $Service->update($request,$userId);
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

    public function trash($teacherId , TeacherService $Service)
    {
        if($Service->trash($teacherId)){
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
        $name     = $request->query('name');
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

        if($teachers->count()>0){
            $data =
            [
                'status'   => 'Success',
                'teachers' => UserResource::collection($teachers)
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
            return response()->json($data,200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'There is no trashed teachers'
        ],404)->header('Content-Type','application/json');
    }

    public function forceDelete($teacherId,TeacherService $Service)
    {
        if($Service->forceDelete($teacherId)){
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

    public function restore($teacherId,TeacherService $Service)
    {
        if($Service->restore($teacherId)){
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
