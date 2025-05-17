<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>لوحة تحكم الطالب - نظام الاختبارات</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <div class="flex h-screen">

    <!-- الشريط الجانبي -->
    <aside id="sidebar" class="w-64 bg-white shadow-lg p-4  transition-all duration-300 overflow-y-auto">
      <h2 class="text-xl font-bold text-blue-600 mb-4">👨‍🎓 الطالب</h2>

      <nav class="space-y-2">
        <a href="#lessons" class="block py-2 px-4 rounded hover:bg-gray-200">📚 الحصص الدراسية</a>
        <a href="#assignments" class="block py-2 px-4 rounded hover:bg-gray-200">📝 الواجبات</a>
        <a href="#quizzes" class="block py-2 px-4 rounded hover:bg-gray-200">🧪 الاختبارات</a>
        <a href="#results" class="block py-2 px-4 rounded hover:bg-gray-200">📊 النتائج</a>
        <a href="{{route('index')}}" class="block py-2 px-4 rounded hover:bg-red-100 text-red-600">🚪 تسجيل الخروج</a>
      </nav>
    </aside>

    <!-- المحتوى الرئيسي -->
    <div class="flex-1 flex flex-col">

      <!-- رأس الصفحة -->
      <header class="bg-blue-600 text-white p-4 flex justify-between items-center shadow-md">
        <button id="toggleSidebar" class="text-white text-2xl">☰</button>
        <h1 class="text-lg font-semibold">لوحة تحكم الطالب</h1>
      </header>

      <!-- المحتوى الداخلي -->
      <main class="p-6 overflow-y-auto space-y-8">

        <!-- الحصص -->
        <section id="lessons">
          <h2 class="text-xl font-bold mb-3 text-gray-700">📚 الحصص الدراسية</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white p-4 rounded-lg shadow">
              <h3 class="font-bold text-blue-700 mb-2">الرياضيات - الفصل 1</h3>
              <a href="#" class="text-blue-500 hover:underline text-sm">تحميل الملف</a>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
              <h3 class="font-bold text-blue-700 mb-2">العلوم - الفصل 2</h3>
              <a href="#" class="text-blue-500 hover:underline text-sm">تحميل الملف</a>
            </div>
          </div>
        </section>

        <!-- الواجبات -->
        <section id="assignments">
          <h2 class="text-xl font-bold mb-3 text-gray-700">📝 الواجبات</h2>
          <ul class="space-y-3">
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <span>حل التمارين من 1 إلى 5 في كتاب الرياضيات</span>
              <a href="#" class="text-green-600 hover:underline text-sm">تسليم</a>
            </li>
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <span>اكتب تقرير عن دورة الماء في الطبيعة</span>
              <a href="#" class="text-green-600 hover:underline text-sm">تسليم</a>
            </li>
          </ul>
        </section>

        <!-- الاختبارات -->
        <section id="quizzes">
          <h2 class="text-xl font-bold mb-3 text-gray-700">🧪 الاختبارات</h2>
          <ul class="space-y-3">
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <span>اختبار رياضيات - الفصل الأول</span>
              <a href="quiz.html" class="text-blue-600 hover:underline text-sm">ابدأ الآن</a>
            </li>
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <span>اختبار علوم - الطاقة والحرارة</span>
              <a href="quiz.html" class="text-blue-600 hover:underline text-sm">ابدأ الآن</a>
            </li>
          </ul>
        </section>

        <!-- النتائج -->
        <section id="results">
          <h2 class="text-xl font-bold mb-3 text-gray-700">📊 النتائج</h2>
          <div class="bg-white p-4 rounded-lg shadow">
            <ul class="space-y-2 text-sm text-gray-700">
              <li>الرياضيات: <span class="font-bold text-green-600">85%</span></li>
              <li>العلوم: <span class="font-bold text-green-600">92%</span></li>
            </ul>
          </div>
        </section>

      </main>
    </div>
  </div>

<script>
  const toggleBtn = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
  });

  if (window.innerWidth < 768) {
    sidebar.classList.add('hidden');
  }
</script>


</body>
</html>
