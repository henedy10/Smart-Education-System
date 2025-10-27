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
use App\Services\Admin\TeacherService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TeacherApiController extends Controller
{
    public function index(Request $request)
    {
        $name     = $request->query('name');
        $teachers = Teacher::whereHas('user', function (Builder $query) use($name) {
                    $query->whereNull('deleted_at')
                        ->where('name','LIKE','%'.$name.'%')
                    ;})->get();

        $count_teachers_trashed = User::onlyTrashed()->where('user_as' , 'teacher')->count();

        if($teachers->count() > 0){
            return response()->json([
                'status'                 => 'Success',
                'teachers'               => $teachers,
                'count_teachers_trashed' => $count_teachers_trashed
            ],200);
        }

        return response()->json([
            'status'                 => 'Failed',
            'teachers'               =>  __('messages.no_teachers'),
            'count_teachers_trashed' => $count_teachers_trashed
        ],404);
    }

    public function store(TeacherStore $request ,TeacherService $Service)
    {
        $Service->store($request);

        return response()->json([
            'status'  => 'Success',
            'message' => 'Teacher created successfully'
        ],201);
    }

    public function update(update $request ,$teacherId,TeacherService $Service)
    {
        $Service->update($request,$teacherId);
        return response()->json([
            'status'  => 'Success',
            'message' => 'Teacher updated successfully'
        ],200);
    }

    public function trash($teacherId , TeacherService $Service)
    {
        if($Service->trash($teacherId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم حذف المدرس مؤقتا'
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا المدرس غير موجود !'
        ],404);
    }

    public function indexTrash(Request $request)
    {
        $name     = $request->query('name');
        $teachers = User::with('teacher')
                        ->where('user_as','teacher')
                        ->where('name','LIKE','%'.$name.'%')
                        ->onlyTrashed()
                        ->get();

        if($teachers->count()>0){
            return response()->json([
                'status'   => 'Success',
                'teachers' => $teachers
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'There is no trashed teachers'
        ],404);
    }

    public function forceDelete($teacherId,TeacherService $Service)
    {
        if($Service->forceDelete($teacherId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم حذف المدرس نهائيا'
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا المدرس غير موجود !'
        ],404);
    }

    public function restore($teacherId,TeacherService $Service)
    {
        if($Service->restore($teacherId)){
            return response()->json([
                'status'  => 'Success',
                'message' => 'تم استرجاع المدرس بنجاح'
            ],200);
        }

        return response()->json([
            'status'  => 'Failed',
            'message' => 'هذا المدرس غير موجود !'
        ],404);
    }
}
