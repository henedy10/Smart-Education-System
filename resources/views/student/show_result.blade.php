@extends('student.layout.app')

@section('title','نتيجة الطالب')

@section('style',"bg-gray-100 min-h-screen flex items-center justify-center p-4")

@section('content')
    <div class="bg-white shadow-xl rounded-lg w-full max-w-md p-6">
        <h1 class="text-2xl font-bold text-center text-blue-700 mb-4">نتيجتك في الاختبار</h1>

        <div class="mb-4 text-center">
            <p class="text-gray-700 text-lg">اسم الطالب: <span class="font-semibold text-black">{{$student->user->name}}</span></p>
            <p class="text-gray-700 text-lg">الاختبار: <span class="font-semibold text-black">{{$quiz->title}}</span></p>
        </div>

        <div class="bg-blue-100 text-blue-800 text-center py-4 rounded-lg mb-4">
            <p class="text-xl font-bold">الدرجة: {{$studentMark}} / {{$quiz->quiz_mark}}</p>
        </div>

        <div class="text-sm text-gray-600 text-center">
            <p>تم التقييم بنجاح. بالتوفيق! 🎉</p>
        </div>

        <div class="mt-6 text-center">
            <a href="{{route('content.show',[$class,$subject])}}" class=" bg-green-500 p-2 rounded hover:text-white">العودة إلى الصفحة الرئيسية</a>
        </div>
    </div>
@endsection

