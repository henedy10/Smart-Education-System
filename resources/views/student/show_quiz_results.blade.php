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
            <th class="py-3 px-4 border-b">التاريخ</th>
            <th class="py-3 px-4 border-b">الدرجة</th>
            <th class="py-3 px-4 border-b">الدرجة النهائية</th>
            <th class="py-3 px-4 border-b">الحالة</th>
          </tr>
        </thead>
        <tbody>
          <!-- مثال لصف واحد -->
          <tr class="hover:bg-gray-50">
            <td class="py-3 px-4 border-b">امتحان الفصل الأول - لغة عربية</td>
            <td class="py-3 px-4 border-b">2025-06-10</td>
            <td class="py-3 px-4 border-b font-semibold text-green-700">18</td>
            <td class="py-3 px-4 border-b">20</td>
            <td class="py-3 px-4 border-b text-green-600 font-semibold">ناجح</td>
          </tr>

          <tr class="hover:bg-gray-50">
            <td class="py-3 px-4 border-b">امتحان الفصل الأول - رياضيات</td>
            <td class="py-3 px-4 border-b">2025-06-15</td>
            <td class="py-3 px-4 border-b font-semibold text-red-600">9</td>
            <td class="py-3 px-4 border-b">20</td>
            <td class="py-3 px-4 border-b text-red-600 font-semibold">راسب</td>
          </tr>

          <tr class="hover:bg-gray-50">
            <td class="py-3 px-4 border-b">امتحان الفصل الأول - فيزياء</td>
            <td class="py-3 px-4 border-b">2025-06-20</td>
            <td class="py-3 px-4 border-b font-semibold text-yellow-600">12</td>
            <td class="py-3 px-4 border-b">20</td>
            <td class="py-3 px-4 border-b text-yellow-600 font-semibold">إعادة</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

@endsection
