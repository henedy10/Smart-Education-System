@extends('teacher.layout.app')

@section('title')  الحصص @endsection

@section('content')
<body class=" min-h-screen">
    <div class="max-w-5xl bg-gray-200  mx-auto py-10 px-4">
        <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
            <h1 class="text-lg font-bold">إدارة المحاضرات</h1>
            <a href="{{route('show_teacher')}}" class="text-white bg-green-600 rounded px-6 py-2 hover:bg-green-700">الصفحة السابقة</a>
        </div>

        <!-- رفع محاضرة جديدة -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-xl font-semibold mb-4 text-gray-700">رفع محاضرة جديدة</h2>
            <form action="{{route('store_teacher',$TeacherId)}}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 text-sm font-medium">عنوان المحاضرة</label>
                        <input type="text" name="title_lesson" class="w-full border rounded p-2 focus:outline-none focus:ring focus:ring-blue-200">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium">تحميل الملف</label>
                        <input type="file" name="file_lesson" class="w-full border rounded p-2">
                    </div>
                        <button type="submit" name="upload" value="upload_lesson" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                            <i class="fas fa-upload ml-1"></i> رفع المحاضرة
                        </button>
            </form>
        </div>

        <!-- عرض المحاضرات السابقة -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">المحاضرات التي تم رفعها</h2>
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-sm">
                        <th class="p-2 border">العنوان</th>
                        <th class="p-2 border">التاريخ</th>
                        <th class="p-2 border">الملف</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($lessons as $lesson )
                        <tr>
                        <td class="border p-2">{{$lesson->title_lesson}}</td>
                        <td class="border p-2">{{$lesson->date_lesson}}</td>
                        <td class="border p-2 text-blue-600"><a href="{{asset('storage/'.$lesson->file_lesson)}}"  download class="bg-red-500 rounded text-white font-bold py-1 px-4 no-underline ">تحميل</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

@endsection

