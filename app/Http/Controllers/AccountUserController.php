<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;
use App\Models\{User};
use App\Http\Requests\account\{login, updatePassword};

class AccountUserController extends Controller
{
    public function index()
    {
        $email = Cookie::get('user_email');

        if($email){
            $user = User::where('email',$email)->first();

            if(is_null($user)){
                Cookie::queue(Cookie::forget('user_email'));
                return redirect()->view('index')->withErrors(['login' => 'هذا الحساب غير موجود']);
            }

            session([
                'email'    => $user->email,
                'id'       => $user->id,
                'user_as'  => $user->user_as,
            ]);

            return $user->user_as === 'teacher'
                ? redirect()->route('teacher.index')
                : redirect()->route('student.index');

        }else{
            return view('index');
        }
    }

    public function login(login $request)
    {
        $user = User::where('email',$request->email)
                    ->where('password',$request->password)
                    ->first();

        if(is_null($user)){
            return redirect()->back()->withErrors(['password' => 'كلمة المرور غير صحيحة']);
        }else{
            session([
                'email'     => $user->email,
                'id'        => $user->id,
                'user_as'   => $user->user_as,
            ]);

            if(request()->remember_me){
                Cookie::queue('user_email', $request->email, 60*24*30, '/'); // for 1 month
            }

            return $user->user_as === 'teacher'
                    ? redirect()->route('teacher.index')
                    : redirect()->route('student.index');
        }
    }
        // تسجيل الخروج لكل من الطالب و المدرس

    public function logout()
    {
        session() -> forget(['email','id','user_as']);
        session() -> invalidate();
        session() -> regenerateToken();
        Cookie::queue(Cookie::forget('user_email'));

        return redirect()->route('index');
    }

    // تغيير كلمه المرور للمستخدم
    public function editPassword()
    {
        return view('EditPassword');
    }

    public function updatePassword(updatePassword $request)
    {
        $user = User::where('email',$request->email)->first();
        $user->update(['password' => $request->NewPassword]);

        return redirect()->route('index')->with('success','تم تغيير كلمة المرور بنجاح');
    }
}
