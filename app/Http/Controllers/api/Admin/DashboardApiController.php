<?php

namespace App\Http\Controllers\api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function index(DashboardService $Service)
    {
        $info           = $Service->index();
        $user           = $info['user'];
        $count_teachers = $info['count_teachers'];
        $count_students = $info['count_students'];

        $data =
            [
                'status'         => 'success',
                'data'           => new UserResource($user),
                'count_teachers' => $count_teachers,
                'count_students' => $count_students
            ];

        $etag = md5(json_encode($data));
        $lastModified = gmdate('D, d M Y H:i:s',strtotime($info['last_modified'])) . ' GMT';

        return response()->json($data,200)
                        ->header('Content-Type','application/json')
                        ->header('Content-Length',strlen(json_encode($data)))
                        ->header('ETag',$etag)
                        ->header('Last-Modified',$lastModified);
    }
}
