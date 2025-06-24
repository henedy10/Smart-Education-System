@extends('student.layout.app')

@section('title')  لوحة التحكم  @endsection

@section('content')
<body class="bg-gradient-to-tr from-gray-100 to-blue-50 font-cairo p-6 min-h-screen">
  <!-- ✅ Header -->
  <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <span class="text-lg font-semibold text-gray-800"> لوحة التحكم</span>
    </div>
    <a href="{{route('show_student')}}" class="text-white bg-green-600 rounded px-6 py-2 hover:bg-green-700">الصفحة السابقة</a>
  </div>
  <!-- ✅ Dashboard Content -->
  <div class="max-w-6xl mx-auto">

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

      <!-- 🎓 المحاضرات -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition border-t-4 border-blue-500">
        <div class="flex items-center gap-3 mb-4 text-blue-600">
          <i data-lucide="video" class="w-6 h-6"></i>
          <h2 class="text-xl font-semibold">المحاضرات</h2>
        </div>
        <p class="text-sm text-gray-600 mb-4">تابع الدروس والمحاضرات الخاصة بك لكل مادة.</p>
        <a href="{{route('show_student_lesson',[$class,$subject])}}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm" >عرض المحاضرات</a>
      </div>

      <!-- 📄 الواجبات -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition border-t-4 border-yellow-500">
        <div class="flex items-center gap-3 mb-4 text-yellow-600">
          <i data-lucide="file-text" class="w-6 h-6"></i>
          <h2 class="text-xl font-semibold">الواجبات</h2>
        </div>
        <p class="text-sm text-gray-600 mb-4">راجع الواجبات المطلوبة منك وسلّمها في الموعد.</p>
        <a href="{{route('show_student_homework',[$class,$subject])}}" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">عرض الواجبات</a>
      </div>

      <!-- 📝 الامتحانات -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition border-t-4 border-red-500">
        <div class="flex items-center gap-3 mb-4 text-red-600">
          <i data-lucide="edit" class="w-6 h-6"></i>
          <h2 class="text-xl font-semibold">الامتحانات</h2>
        </div>
        <p class="text-sm text-gray-600 mb-4">قم بحل الاختبارات الإلكترونية وتابع تقييمك.</p>
        <a href="{{route('show_student_quizzes',[$class,$subject])}}" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">عرض الامتحانات</a>
      </div>

    </div>
  </div>
@endsection


