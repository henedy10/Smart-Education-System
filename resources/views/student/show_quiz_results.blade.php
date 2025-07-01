@extends('student.layout.app')

@section('title') نتائج الاختبارات السابقة @endsection

@section('content')
<body class="bg-gray-100 min-h-screen p-6 flex items-center justify-center">

  <div class="w-full max-w-4xl bg-white shadow-xl rounded-lg p-6">
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <p class="text-center text-gray-600 font-bold">نتائج الامتحانات السابقه</p>
        <a href="{{route('show_student_quiz_action',[$class,$subject])}}"  class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
    </div>

    <!-- جدول النتائج -->
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-300 rounded">
        <thead class="bg-gray-100 text-right text-sm">
          <tr>
            <th class="py-3 px-4 border-b">عنوان الاختبار</th>
            <th class="py-3 px-4 border-b">الدرجة</th>
            <th class="py-3 px-4 border-b">الدرجة النهائية</th>
          </tr>
        </thead>
        <tbody>
          <!-- مثال لصف واحد -->
          @foreach (  $results as $result)
          <tr class="hover:bg-gray-50">
            <td class="py-3 px-4 border-b">{{$result->quiz->title}}</td>
            <td class="py-3 px-4 border-b font-semibold text-green-700">{{$result->student_mark}}</td>
            <td class="py-3 px-4 border-b">{{$result->quiz_mark}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection
