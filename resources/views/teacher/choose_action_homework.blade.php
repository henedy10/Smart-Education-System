<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>إدارة الواجبات</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between  ">
        <h1 class="text-2xl font-semibold mb-8">إدارة الواجبات</h1>
        <a href="{{route('show_teacher')}}" class="text-white bg-red-600 rounded px-3 py-3 hover:bg-red-700">الصفحة السابقة</a>
    </div>

  <div class=" flex items-center justify-center p-6">
    <div class="bg-white rounded-xl shadow-xl p-10 w-full max-w-xl text-center ">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- 📝 رفع واجب جديد -->
        <a href="{{route('create_teacher_homeworks',$TeacherId)}}"
           class="block p-6 bg-blue-50 border border-blue-200 rounded-xl shadow hover:shadow-md hover:bg-blue-100 transition group">
          <div class="text-blue-700 text-4xl mb-2 group-hover:scale-110 transition">📤</div>
          <h2 class="text-lg font-semibold text-blue-800">رفع واجب جديد</h2>
          <p class="text-sm text-blue-600 mt-1">أضف واجبًا جديدًا للطلاب</p>
        </a>

        <!-- ✅ تصحيح الواجبات -->
        <a href="{{route('correct_teacher_homework',$TeacherId)}}"
           class="block p-6 bg-green-50 border border-green-200 rounded-xl shadow hover:shadow-md hover:bg-green-100 transition group">
          <div class="text-green-700 text-4xl mb-2 group-hover:scale-110 transition">✅</div>
          <h2 class="text-lg font-semibold text-green-800">تصحيح حلول الطلاب</h2>
          <p class="text-sm text-green-600 mt-1">عرض ومراجعة واجبات الطلاب</p>
        </a>

      </div>

    </div>
  </div>

</body>
</html>
