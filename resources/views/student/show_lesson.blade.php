<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>المحاضرات الدراسية</title>
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

  <!-- ✅ Header -->
  <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <i data-lucide="video" class="w-6 h-6 text-blue-600"></i>
      <span class="text-lg font-semibold text-gray-800">📺 المحاضرات الدراسية</span>
    </div>
    <a href="{{route('show_student_content',[$class,$subject])}}" class="text-sm text-blue-600 hover:underline">العودة للوحة التحكم</a>
  </div>

  <!-- ✅ محتوى المحاضرات -->
  <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6">
        @foreach ($lessons as $lesson )
            <!-- 🧪 محاضرة واحدة -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition border-r-4 border-blue-500">
            <div class="flex items-center gap-2 text-blue-600 mb-3">
                <i data-lucide="book-open" class="w-5 h-5"></i>
                <h2 class="text-lg font-semibold">{{$lesson->title_lesson}}</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{asset('storage/'.$lesson->file_lesson)}}" target="_blank" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">مشاهدة</a>
                <a href="{{asset('storage/'.$lesson->file_lesson)}}" download class="bg-gray-200 text-gray-800 px-3 py-1 rounded hover:bg-gray-300 text-sm">تحميل</a>
            </div>
            </div>
        @endforeach
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
