<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>واجبات المدرس</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6 font-sans">

    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-6">
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
    <div style="display: flex; justify-content:space-between">

        <h1 class="text-2xl font-bold text-blue-600 mb-6">إدارة الواجبات</h1>
        <a href="{{route('show_teacher')}}" class="text-2xl font-medium text-red-600 mb-6">السابق -></a>
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
                    <th class="p-3 border">#</th>
                    <th class="p-3 border">العنوان</th>
                    <th class="p-3 border">المطلوب</th>
                    <th class="p-3 border">تاريخ الرفع</th>
                    <th class="p-3 border">الملف</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ( $homeworks as $homework )
                <tr>
                    <td class="p-3 border">{{$homework->id}}</td>
                    <td class="p-3 border">{{$homework->title_homework}}</td>
                    <td class="p-3 border">{{$homework->content_homework}}</td>
                    <td class="p-3 border">{{$homework->updated_at}}</td>
                    <td class="p-3 border text-blue-600 underline">
                        <a href="{{asset('storage/'.$homework->file_homework)}}" download>تحميل</a>
                        <a href="{{asset('storage/'.$homework->file_homework)}}" target="_blank" class="mr-2">مشاهدة</a>
                    </td>
                </tr>
                @endforeach
                <!-- ممكن تكرار الصفوف هنا حسب عدد الواجبات -->
            </tbody>
        </table>
    </div>

</body>
</html>
