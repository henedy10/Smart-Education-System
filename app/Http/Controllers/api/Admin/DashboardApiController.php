<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\Admin\DashboardService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    use ApiResponse;

    public function index(DashboardService $Service , Request $request)
    {
        $info = $Service->index();

        $data =
            [
                'user'           => new UserResource($info['user']),
                'count_teachers' => $info['count_teachers'],
                'count_students' => $info['count_students']
            ];

        $etag = md5(json_encode($data));
        $lastModified = gmdate('D, d M Y H:i:s',strtotime($info['last_modified'])) . ' GMT';

        if($clientEtag = $request->header('if-None-Match')){
            if($clientEtag === $etag){
                return $this->success(null,null,304)
                        ->header('Etag',$etag)
                        ->header('Last-Modified',$lastModified);
            }
        }

        if($ifModifiedSinceTime = strtotime($request->header('If-Modified-Since'))){
            if($ifModifiedSinceTime >= $lastModified){
                return $this->success(null,null,304)
                        ->header('Etag',$etag)
                        ->header('Last-Modified',$lastModified);
            }
        }

        return $this->success($data,null,200)
                        ->header('Content-Length',strlen(json_encode($data)))
                        ->header('ETag',$etag)
                        ->header('Last-Modified',$lastModified);
    }
}
