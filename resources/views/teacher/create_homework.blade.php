@extends('teacher.layout.app')

@section('title') الواجبات @endsection

@section('content')
<body class="bg-gray-100 min-h-screen">

    <div class="max-w-4xl mx-auto py-10 px-4">

        <!-- رسائل الخطأ -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- رسالة النجاح -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- رأس الصفحة -->
        <div class="bg-white shadow-md rounded-lg px-6 py-4 mb-6 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-800">رفع واجب جديد</h1>
            <a href="{{route('choose_action_homework', $TeacherId)}}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition">
                الصفحة السابقة
            </a>
        </div>

        <!-- نموذج رفع الواجب -->
        <form action="{{route('store_teacher', $TeacherId)}}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md px-6 py-8 space-y-6">
            @csrf

            <!-- عنوان الواجب -->
            <div>
                <label for="title_homework" class="block mb-1 text-sm font-medium text-gray-700">عنوان الواجب</label>
                <input type="text" name="title_homework" id="title_homework"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- المطلوب -->
            <div>
                <label for="content_homework" class="block mb-1 text-sm font-medium text-gray-700">المطلوب</label>
                <textarea name="content_homework" id="content_homework" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div>
                <label for="homework_mark" class="block mb-1 text-sm font-medium text-gray-700">درجه الواجب</label>
                <input type="number" name="homework_mark" id="homework_mark"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            </div>

            <!-- الموعد النهائي -->
            <div>
                <label for="deadline_homework" class="block mb-1 text-sm font-medium text-gray-700">آخر ميعاد للتسليم</label>
                <input type="datetime-local" name="deadline_homework" id="deadline_homework"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
            </div>

            <!-- زر الإرسال -->
            <div class="text-center">
                <button type="submit" name="upload" value="upload_homework"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow">
                    رفع الواجب
                </button>
            </div>
        </form>
    </div>

</body>
@endsection


