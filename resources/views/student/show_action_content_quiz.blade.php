@extends('student.layout.app')

@section('title') اختيار الطالب@endsection

@section('content')
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

  <div class="max-w-xl w-full bg-white rounded-lg shadow-lg p-6">
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <p class="text-center text-gray-600 font-bold">اختر ما ترغب في القيام به:</p>
        <a href="{{route('content.show',[$class,$subject])}}"  class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
    </div>

    <div class="flex flex-col gap-6">
      <!-- زر الاختبارات المتاحة -->
      <a href="{{route('availableQuiz.show',[$class,$subject])}}"
         class="block w-full bg-green-500 hover:bg-green-600 text-white text-lg text-center py-4 rounded-lg shadow transition duration-300">
        عرض الاختبارات المتاحة
      </a>

      <!-- زر نتائج الامتحانات السابقة -->
      <a href="{{route('student.quizResult.show',[$class,$subject])}}"
         class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-lg text-center py-4 rounded-lg shadow transition duration-300">
        عرض النتائج السابقة
      </a>
    </div>
  </div>

@endsection
