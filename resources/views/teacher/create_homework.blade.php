@extends('teacher.layout.app')

@section('title') الواجبات @endsection

@section('content')
<body class="bg-gray-100 min-h-screen">

    <div class="max-w-4xl mx-auto py-10 px-4">

        <!-- رسالة النجاح -->
        @if(session('success'))
            <div class="flex items-center gap-2 bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- رأس الصفحة -->
        <div class="bg-white shadow-md rounded-2xl px-6 py-4 mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-800">✏️ رفع واجب جديد</h1>
            <a href="{{route('teacher.homeworkAction.show', $TeacherId)}}"
               class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">
                الصفحة السابقة
            </a>
        </div>

        <!-- نموذج رفع الواجب -->
        <form action="{{route('teacher.homeworks.store', $TeacherId)}}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow-md px-8 py-10 space-y-6">
            @csrf

            <!-- عنوان الواجب -->
            <div>
                <label for="title_homework" class="block mb-1 text-sm font-medium text-gray-700">عنوان الواجب</label>
                <input type="text" name="title_homework" id="title_homework"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('title_homework')
                    <p class="text-red-500 text-sm mt-1">* {{ $message }}</p>
                @enderror
            </div>

            <!-- المطلوب -->
            <div>
                <label for="content_homework" class="block mb-1 text-sm font-medium text-gray-700">المطلوب</label>
                <textarea name="content_homework" id="content_homework" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                @error('content_homework')
                    <p class="text-red-500 text-sm mt-1">* {{ $message }}</p>
                @enderror
            </div>

            <!-- درجة الواجب -->
            <div>
                <label for="homework_mark" class="block mb-1 text-sm font-medium text-gray-700">درجة الواجب</label>
                <input type="number" name="homework_mark" id="homework_mark"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('homework_mark')
                    <p class="text-red-500 text-sm mt-1">* {{ $message }}</p>
                @enderror
            </div>

            <!-- الموعد النهائي -->
            <div>
                <label for="deadline_homework" class="block mb-1 text-sm font-medium text-gray-700">آخر ميعاد للتسليم</label>
                <input type="datetime-local" name="deadline_homework" id="deadline_homework"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('deadline_homework')
                    <p class="text-red-500 text-sm mt-1">* {{ $message }}</p>
                @enderror
            </div>

            <!-- رفع الملف -->
            <div>
                <label for="file_homework" class="block mb-1 text-sm font-medium text-gray-700">
                    رفع ملف (pdf, doc, docx, zip, rar, jpg, png)
                </label>
                <input type="file" name="file_homework" id="file_homework"
                       class="w-full file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                              file:bg-blue-50 file:text-blue-700 file:font-semibold
                              hover:file:bg-blue-100 transition">
                @error('file_homework')
                    <p class="text-red-500 text-sm mt-1">* {{ $message }}</p>
                @enderror
            </div>

            <!-- زر الإرسال -->
            <div class="text-center">
                <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-xl shadow transition-all duration-300">
                    <i class="fas fa-upload"></i> رفع الواجب
                </button>
            </div>
        </form>
    </div>

</body>

@endsection


