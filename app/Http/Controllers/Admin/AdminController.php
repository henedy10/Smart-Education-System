<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $userId    = session('id');
        $dashboard = User::where('id',$userId)
                        ->withCount('teacher','student')
                        ->first();
        return view('admin.dashboard' , compact('dashboard'));
    }
}
