<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>الكويزات المتاحة</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
      <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <span class="text-lg font-semibold text-gray-800"> الإمتحانات الدراسيه</span>
    </div>
 <a href="{{route('show_student_content',[$class,$subject])}}" class="text-sm text-blue-600 hover:underline">السابق -></a>
  </div>
  <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-6 text-center">الكويزات المتاحة</h1>

    <ul class="space-y-4">
      <li class="bg-gray-50 p-4 rounded shadow flex justify-between items-center">
        <div>
          <h2 class="text-lg font-semibold">اختبار رياضيات - الفصل الأول</h2>
          <p class="text-sm text-gray-600">عدد الأسئلة: 10</p>
        </div>
        <a href="quiz.html" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          ابدأ الاختبار
        </a>
      </li>

      <li class="bg-gray-50 p-4 rounded shadow flex justify-between items-center">
        <div>
          <h2 class="text-lg font-semibold">اختبار علوم - الطاقة والحرارة</h2>
          <p class="text-sm text-gray-600">عدد الأسئلة: 8</p>
        </div>
        <a href="quiz.html" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          ابدأ الاختبار
        </a>
      </li>
    </ul>
        <a href="{{route('show_student_content',[$class,$subject])}}" class="text-sm text-blue-600 hover:underline">السابق -></a>
  </div>
</body>
</html>
