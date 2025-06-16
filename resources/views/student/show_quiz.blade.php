@extends('student.layout.app')

@section('title') الكويزات المتاحة @endsection

@section('content')

<body class="bg-gray-100 p-6">
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-lg font-bold text-gray-800"> الإمتحانات الدراسيه</span>
        </div>
        <a href="{{route('show_student_content',[$class,$subject])}}"  class="text-sm text-blue-600 hover:underline">السابق -></a>
    </div>
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">الكويزات المتاحة</h1>
        @if ($quiz->isempty())
                <h2 class="text-lg text-red-700">  * لا يوجد اختبارات حاليا  </h2>
        @else
        @foreach ( $quiz as $quiz )
        <ul class="space-y-4">
            <li class="bg-gray-50 p-4 rounded shadow flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">{{$quiz->title}}</h2>
                    <p class="text-sm text-gray-600">عدد الأسئلة: 10</p>
                    <p class="text-sm text-gray-600">الوقت : {{$quiz->duration}}</p>
                </div>
                <a href="{{route('show_content_quiz')}}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                ابدأ الاختبار
                </a>
            </li>
        </ul>
        @endforeach
        @endif
    </div>
</body>

@endsection
