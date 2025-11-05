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
        $dashboard      = $info['dashboard'];
        $count_teachers = $info['count_teachers'];
        $count_students = $info['count_students'];

        $data =
            [
                'status'         => 'Success',
                'data'           => new UserResource($dashboard),
                'count_teachers' => $count_teachers,
                'count_students' => $count_students
            ];

        $etag = md5(json_encode($data));
        $lastModified = now()->toRfc7231String();

        return response()->json($data,200)
                        ->header('Content-Type','application/json')
                        ->header('ETag',$etag)
                        ->header('Last-Modified',$lastModified);
    }
}
