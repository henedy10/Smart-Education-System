@extends('teacher.layout.app')

@section('title')   اداره الواجبات @endsection

@section('content')
<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="bg-white shadow-md rounded-2xl p-6 m-6 flex flex-col md:flex-row items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">📘 إدارة الواجبات</h1>
        <a href="{{route('teacher.index')}}"
           class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-6 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">
           الصفحة السابقة
        </a>
    </div>

    <!-- Content -->
    <div class="flex items-center justify-center p-6">
        <div class="bg-white rounded-2xl shadow-xl p-10 w-full max-w-3xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- 📝 رفع واجب جديد -->
                <a href="{{route('teacher.homeworks.create',$TeacherId)}}"
                   class="block p-8 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-2xl shadow hover:shadow-lg hover:scale-105 transition-all duration-300 group">
                    <div class="text-blue-700 text-5xl mb-3 group-hover:scale-110 transition">📤</div>
                    <h2 class="text-xl font-semibold text-blue-900">رفع واجب جديد</h2>
                    <p class="text-sm text-blue-700 mt-2">أضف واجبًا جديدًا للطلاب بسهولة</p>
                </a>

                <!-- ✅ تصحيح الواجبات -->
                <a href="{{route('teacher.homeworkCorrection.show',$TeacherId)}}"
                   class="block p-8 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-2xl shadow hover:shadow-lg hover:scale-105 transition-all duration-300 group">
                    <div class="text-green-700 text-5xl mb-3 group-hover:scale-110 transition">✅</div>
                    <h2 class="text-xl font-semibold text-green-900">تصحيح حلول الطلاب</h2>
                    <p class="text-sm text-green-700 mt-2">عرض ومراجعة واجبات الطلاب بسهولة</p>
                </a>

            </div>
        </div>
    </div>

</body>

@endsection
