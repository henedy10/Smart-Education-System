
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
    <form action="{{route("log_out_student")}}" method="GET">
     @method('delete')
      @csrf
      <button type="submit" class="text-sm text-red-500 hover:underline">تسجيل الخروج</button>
    </form>
  </div>

  <!-- 👇 باقي الصفحة كما هي -->
  <div class="max-w-6xl mx-auto">
    <h1 class="text-3xl md:text-4xl font-bold text-center text-blue-700 mb-10">📚 المواد الدراسية المتاحة</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

      <!-- كارت مادة -->
      @foreach ($teachers as $teacher )
      <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-t-4 border-blue-500 group relative overflow-hidden">
        <div class="p-5">
          <div class="flex items-center gap-2 text-blue-600 mb-3">
            <i data-lucide="calculator" class="w-5 h-5"></i>
            <h2 class="text-xl font-semibold">{{$teacher->subject}}</h2>
          </div>
          <p class="text-sm text-gray-600 mb-4">Teacher : {{$teacher->user->name}}</p>
          <a href="{{route('show_student_content',[$teacher->class, $teacher->subject])}}"  class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm transition">
            عرض المحتوي
          </a>
        </div>
      </div>
      @endforeach

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

