{{-- <!DOCTYPE html>
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
        <h1 class="text-lg font-semibold">({{$student->class}}) {{$student->user->name}}</h1>
      </header>

      <!-- المحتوى الداخلي -->
      <main class="p-6 overflow-y-auto space-y-8">

        <!-- الحصص -->
        <section id="lessons">
            <h2 class="text-xl font-bold mb-3 text-gray-700">📚 الحصص الدراسية</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($lessons as $lesson)
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="font-bold text-blue-700 mb-2">{{$lesson->title_lesson}}</h3>
                        <a href="{{ asset('storage/'.$lesson->file_lesson)}}" target="_blank" class="text-blue-500 hover:underline text-sm">تحميل الملف</a>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- الواجبات -->
        <section id="assignments">
          <h2 class="text-xl font-bold mb-3 text-gray-700">📝 الواجبات</h2>
          <ul class="space-y-3">
            @foreach ($homeworks as $homework )
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <span>{{$homework->}}</span>
              <a href="#" class="text-green-600 hover:underline text-sm">تسليم</a>
            </li>
            @endforeach
            {{-- <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <span>اكتب تقرير عن دورة الماء في الطبيعة</span>
              <a href="#" class="text-green-600 hover:underline text-sm">تسليم</a>
            </li> --}}
          {{-- </ul>
        </section>

        <!-- الاختبارات -->
        <section id="quizzes">
          <h2 class="text-xl font-bold mb-3 text-gray-700">🧪 الاختبارات</h2>
          <ul class="space-y-3">
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <span>اختبار رياضيات - الفصل الأول</span>
              <a href="{{route('show_quiz')}}" class="text-blue-600 hover:underline text-sm">ابدأ الآن</a>
            </li>
            <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
              <span>اختبار علوم - الطاقة والحرارة</span>
              <a href="#" class="text-blue-600 hover:underline text-sm">ابدأ الآن</a>
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
</html> --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>المواد الدراسية</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            cairo: ['Cairo', 'sans-serif']
          }
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-blue-50 font-cairo p-6 min-h-screen">

  <!-- ✅ شريط الطالب -->
  <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
      <span class="text-lg font-semibold text-gray-800">👋 مرحبًا، <span id="studentName">{{$student->user->name}}</span></span>
    </div>
    <button class="text-sm text-red-500 hover:underline">تسجيل الخروج</button>
  </div>

  <!-- 👇 باقي الصفحة كما هي -->
  <div class="max-w-6xl mx-auto">
    <h1 class="text-3xl md:text-4xl font-bold text-center text-blue-700 mb-10">📚 المواد الدراسية المتاحة</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

      <!-- كارت مادة -->
      <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-t-4 border-blue-500 group relative overflow-hidden">
        <div class="p-5">
          <div class="flex items-center gap-2 text-blue-600 mb-3">
            <i data-lucide="calculator" class="w-5 h-5"></i>
            <h2 class="text-xl font-semibold">الرياضيات</h2>
          </div>
          <p class="text-sm text-gray-600 mb-4">الجبر - الهندسة - الاحتمالات</p>
          <a href="lessons.html" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm transition">
            عرض المحتوي
          </a>
        </div>
      </div>

      <!-- باقي المواد زي ما هي ... -->

    </div>
  </div>

  <script>
    lucide.createIcons(); // لتشغيل الأيقونات

    // ✅ لو عايز تجيب الاسم من الـ backend
    // document.getElementById("studentName").innerText = "الاسم من السيرفر";
  </script>

</body>

</html>

