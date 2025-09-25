@extends('teacher.layout.app')

@section('title')  الحصص @endsection

@section('content')
<body class=" min-h-screen">
    <div class="max-w-5xl bg-gray-200  mx-auto py-10 px-4">
        <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
            <h1 class="text-lg font-bold">إدارة المحاضرات</h1>
            <a href="{{route('teacher.index')}}" class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
        </div>

        <!-- رفع محاضرة جديدة -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-xl font-semibold mb-4 text-gray-700">رفع محاضرة جديدة</h2>
            <form action="{{route('teacher.lessons.store',$TeacherId)}}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 text-sm font-medium">عنوان المحاضرة</label>
                        <input type="text" name="title_lesson" class="w-full border rounded p-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                    @error('title_lesson')
                        <span class="text-danger">{{"* ".$message}}</span>
                    @enderror

                    <div>
                        <label class="block mb-1 text-sm font-medium">تحميل الملف</label>
                        <input type="file" name="file_lesson" class="w-full border rounded p-2">
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                        <i class="fas fa-upload ml-1"></i> رفع المحاضرة
                    </button>

                    @error('file_lesson')
                        <span class="text-danger">{{"* ".$message}}</span>
                    @enderror
            </form>
        </div>

        <!-- عرض المحاضرات السابقة -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">المحاضرات التي تم رفعها</h2>
            @if ($lessons->isEmpty())
                    <h2 class="text-danger">* لا توجد محاضرات تم رفعها حاليا</h2>
            @else
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-sm">
                            <th class="p-2 border">العنوان</th>
                            <th class="p-2 border">الملف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lessons as $lesson )
                            <tr>
                            <td class="border p-2">{{$lesson->title_lesson}}</td>
                            <td class="border p-2 text-blue-600 text-center"><a href="{{asset('storage/'.$lesson->file_lesson)}}"  download class="bg-green-500 rounded text-white font-bold py-1 px-4 hover:bg-green-600 ">تحميل</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>

@endsection

