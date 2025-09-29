@extends('student.layout.app')

@section('title','المحاضرات الدراسيه')

@section('content')

@section('style',"bg-gradient-to-br from-gray-100 to-blue-50 font-cairo p-6 min-h-screen")
    <!-- ✅ Header -->
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i data-lucide="video" class="w-6 h-6 text-blue-600"></i>
            <span class="text-lg font-bold text-gray-800">📺 المحاضرات الدراسية</span>
        </div>
        <a href="{{route('student.content.show',[$class,$subject])}}" class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">الصفحة السابقة</a>
    </div>

    <!-- ✅ محتوى المحاضرات -->
    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6">
        @forelse ( $lessons as $lesson )
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
        @empty
            <h2 class="text-lg text-red-700 font-bold">  * لا توجد محاضرات حاليا  </h2>
        @endforelse
    </div>
@endsection


