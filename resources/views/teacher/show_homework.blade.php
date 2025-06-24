
@extends('teacher.layout.app')

@section('title') الواجبات @endsection

@section('content')
<body class=" min-h-screen ">

    <div class="max-w-5xl bg-gray-200  mx-auto py-10 px-4">
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
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">

        <h1 class="text-lg font-bold text-gray-800">إدارة الواجبات</h1>
        <a href="{{route('show_teacher')}}" class="text-white bg-green-600 rounded px-6 py-2 hover:bg-green-700">الصفحة السابقة</a>

    </div>

        <!-- فورم رفع واجب جديد -->
        <form action="{{route('store_teacher',$TeacherId)}}" method="POST" enctype="multipart/form-data" class="space-y-4 mb-10">
            @csrf
            <h2 class="text-xl font-semibold text-gray-700">رفع واجب جديد</h2>

            <div>
                <label class="block mb-1 text-sm text-gray-600">عنوان الواجب</label>
                <input type="text" name="title_homework" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block mb-1 text-sm text-gray-600">المطلوب</label>
                <textarea name="content_homework" rows="3" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
            </div>

            <div>
                <label class="block mb-1 text-sm text-gray-600">اخر ميعاد للتسليم</label>
                <input type="datetime-local" name="deadline_homework" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block mb-1 text-sm text-gray-600">رفع ملف (pdf,doc,docx,zip,rar,jpg,png)</label>
                <input type="file" name="file_homework" class="w-full">
            </div>

            <button type="submit" name="upload" value="upload_homework" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                رفع الواجب
            </button>
        </form>

        <!-- جدول الواجبات السابقة -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">الواجبات التي تم رفعها</h2>
        <table class="w-full text-sm text-right table-auto border-collapse">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="p-3 border">العنوان</th>
                    <th class="p-3 border">المطلوب</th>
                    <th class="p-3 border">تاريخ الرفع</th>
                    <th class="p-3 border">الملف</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ( $homeworks as $homework )
                <tr>
                    <td class="p-3 border">{{$homework->title_homework}}</td>
                    <td class="p-3 border">{{$homework->content_homework}}</td>
                    <td class="p-3 border">{{$homework->updated_at}}</td>
                    <td class="p-3 border text-blue-600 ">
                        <a href="{{asset('storage/'.$homework->file_homework)}}" class="bg-red-500 rounded text-white font-bold py-2 px-4  " download>تحميل</a>
                        <a href="{{asset('storage/'.$homework->file_homework)}}" target="_blank" class="mr-2 bg-green-500 text-white font-bold py-2 px-4 rounded  ">مشاهدة</a>
                    </td>
                </tr>
                @endforeach
                <!-- ممكن تكرار الصفوف هنا حسب عدد الواجبات -->
            </tbody>
        </table>
    </div>

</body>

@endsection

