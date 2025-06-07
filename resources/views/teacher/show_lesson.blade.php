<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة المحاضرات - المدرس</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-5xl mx-auto py-10 px-4">
        <div style="display: flex; justify-content:space-between">
            <h1 class="text-2xl font-bold text-blue-600 mb-6">إدارة المحاضرات</h1>
            <a href="{{route('show_teacher')}}" class="text-2xl font-medium text-red-600 mb-6">السابق -></a>
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
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">العنوان</th>
                        <th class="p-2 border">التاريخ</th>
                        <th class="p-2 border">الملف</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lessons as $lesson )
                        <tr>
                        <td class="border p-2">{{$lesson->id}}</td>
                        <td class="border p-2">{{$lesson->title_lesson}}</td>
                        <td class="border p-2">{{$lesson->date_lesson}}</td>
                        <td class="border p-2 text-blue-600"><a href="{{asset('storage/'.$lesson->file_lesson)}}"  download class="hover:underline">تحميل</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
