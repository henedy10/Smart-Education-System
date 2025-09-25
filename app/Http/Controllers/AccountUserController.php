<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cookie;
use App\Models\{User};

class AccountUserController extends Controller
{
    public function index(){

        $email=Cookie::get('user_email');

        if($email){
            $user=User::where('email',$email)->first();

            if(!$user){
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

    public function login(){

            request()->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required'    => ' يجب إدخال الإيميل الخاص بك',
                'email.email'       => 'صيغة الإيميل غير صحيحه',
                'password.required' => 'يجب إدخال كلمة المرور الخاصة بك',
            ]);

            $user= User::where('email',request()->email)
                        ->where('password',request()->password)
                        ->first();

            if(!$user){
                return back()->withErrors(['login' => 'بيانات الدخول غير صحيحه']);
            }else{
                session([
                    'email'     => $user->email,
                    'id'        => $user->id,
                    'user_as'   => $user->user_as,
                ]);

                if(request()->remember_me){
                    Cookie::queue('user_email', request()->email, 60*24*30, '/'); // for 1 month
                }

                return $user->user_as == 'teacher'
                        ? redirect()->route('teacher.index')
                        : redirect()->route('student.index');
            }
    }
        // تسجيل الخروج لكل من الطالب و المدرس

    public function LogOut(){

        session() -> forget(['email','id','user_as']);
        session() -> invalidate();
        session() -> regenerateToken();

        Cookie::queue(Cookie::forget('user_email'));

        return redirect()->route('index');
    }

    // تغيير كلمه المرور للمستخدم
    public function EditPassword(){

        return view('EditPassword');

    }

    public function UpdatePassword(){

        request()->validate([
            'email'             => 'required | email',
            'NewPassword'       => 'required | min:8',
            'ConfirmPassword'   => 'required | same:NewPassword',
        ],[
            'email.required'            => 'يجب إدخال الإيميل الخاص بك',
            'email.email'               => 'صيغة الإيميل غير صحيحه',
            'NewPassword.required'      => 'يجب إدخال كلمة المرور الجديدة',
            'NewPassword.min'           => 'يجب ألا يقل كلمة المرور عن 8 أحرف',
            'ConfirmPassword.required'  => 'يجب إدخال كلمة المرور الجديدة للتأكيد',
            'ConfirmPassword.same'      => 'لا يوجد تطابق لكلمة المرور الجديدة',
        ]);

        $user= User::where('email',request()->email)->first();

        if(is_null($user)){
            return redirect()->back()->withErrors(['email' => 'هذا الحساب غير موجود']);
        }else{
            $user->update(['password' => request()->NewPassword]);

            return redirect()->route('index')->with('success','تم تغيير كلمة المرور بنجاح');
        }
    }
}
