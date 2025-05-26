<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>لوحة تحكم المعلم</title>
        <script src="https://cdn.tailwindcss.com"></script>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body class="bg-gray-100 text-gray-800">
    <form action="{{route('store_teacher',$teacher->id)}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="flex h-screen overflow-hidden">
        <!-- الشريط الجانبي -->
        <aside
        id="sidebar"
        class="w-64 bg-white shadow-lg p-4 space-y-4 transition-all duration-300 transform translate-x-0 md:relative fixed top-0 right-0 h-full z-50"
        >
        <h2 class="text-xl font-bold text-blue-600 mb-4">👨‍🏫 المعلم</h2>

        <nav class="space-y-2">
            <a href="#lessons" class="block py-2 px-4 rounded hover:bg-gray-200">📚 إدارة الحصص</a>
            <a href="#assignments" class="block py-2 px-4 rounded hover:bg-gray-200">📝 الواجبات</a>
            <a href="#quizzes" class="block py-2 px-4 rounded hover:bg-gray-200">🧪 الاختبارات</a>
            <a href="#results" class="block py-2 px-4 rounded hover:bg-gray-200">📊 نتائج الطلاب</a>
            <a href="{{route('index')}}" class="block py-2 px-4 rounded hover:bg-red-100 text-red-600">🚪 تسجيل الخروج</a>
        </nav>
        </aside>

        <!-- المحتوى الرئيسي -->
        <div class="flex-1 flex flex-col ">

        <!-- رأس الصفحة -->
        <header class="bg-blue-600 text-white p-4 flex justify-between items-center shadow-md">
            <button id="toggleSidebar" class="text-white text-2xl">☰</button>
            <h1 class="text-lg font-semibold">  {{$teacher->user->name}} ({{$teacher->subject}})</h1>
        </header>

                <!-- المحتوى -->
                <main class="p-6 overflow-y-auto space-y-8">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                <!-- إدارة الحصص -->
                <section id="lessons">
                    <h2 class="text-xl font-bold mb-3 text-gray-700">📚  إدارة الحصص </h2>
                    <div class="bg-white p-4 rounded-lg shadow space-y-3">
                    <label class="block">
                        <span class="text-sm">عنوان الحصة:</span>
                        <input type="text" name="title_lesson" placeholder="مثال: رياضيات - الفصل 1" class="w-full border rounded p-2 mt-1" />
                    </label>
                    <label class="block">
                        <span class="text-sm">تحميل ملف:</span>
                        <input type="file" name="file_lesson" class="mt-1" />
                    </label>
                    <button  name="upload_lesson" value="upload_lesson" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">نشر الحصة</button>
                    </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                </section>

                <!-- الواجبات -->
                <section id="assignments">
                    <h2 class="text-xl font-bold mb-3 text-gray-700">📝 الواجبات</h2>
                    <div class="bg-white p-4 rounded-lg shadow space-y-3">
                    <label class="block">
                        <span class="text-sm">محتوى الواجب:</span>
                        <textarea rows="3" placeholder="مثال: حل التمارين 3 و 4" class="w-full border rounded p-2 mt-1"></textarea>
                    </label>
                    <label class="block">
                        <span class="text-sm">ملف الواجب:</span>
                        <input type="file" class="mt-1" />
                    </label>
                    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">إرسال الواجب</button>
                    </div>
                </section>

                <!-- الاختبارات -->
                <section id="quizzes">
                    <h2 class="text-xl font-bold mb-3 text-gray-700">🧪 الاختبارات</h2>
                    <div class="bg-white p-4 rounded-lg shadow space-y-3">
                    <label class="block">
                        <span class="text-sm">اسم الاختبار:</span>
                        <input type="text" class="w-full border rounded p-2 mt-1" />
                    </label>
                    <label class="block">
                        <span class="text-sm">ملف الأسئلة:</span>
                        <input type="file" class="mt-1" />
                    </label>
                    <button class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">إضافة اختبار</button>
                    </div>
                </section>

                <!-- نتائج الطلاب -->
                <section id="results">
                    <h2 class="text-xl font-bold mb-3 text-gray-700">📊 نتائج الطلاب</h2>
                    <div class="bg-white p-4 rounded-lg shadow">
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li>محمد أحمد: <span class="font-bold text-green-600">90%</span></li>
                        <li>سارة خالد: <span class="font-bold text-red-500">65%</span></li>
                    </ul>
                    </div>
                </section>
                </main>
            </div>
        </div>
    </form>

  <!-- JavaScript لتشغيل القائمة -->
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
