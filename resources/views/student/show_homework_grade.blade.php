@extends('student.layout.app')

@section('title') تقييمك @endsection

@section('content')
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-6 border-t-4 border-blue-600">
        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">تقييمك في الواجب</h2>

        <div class="space-y-3 text-gray-700">
            <div class="flex justify-between">
                <span class="font-semibold">الملف الذي تم رفعه :</span>
                <span>#</span>
            </div>

            <div class="flex justify-between">
                <span class="font-semibold">الدرجة:</span>
                <span class="text-green-600 font-bold">{{$student_homework_grade->student_mark}} / {{$student_homework_grade->homework->homework_mark}}</span>
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{route('show_student_homework',[$class,$subject])}}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded">
                العودة إلى قائمة الواجبات
            </a>
        </div>
    </div>
@endsection
