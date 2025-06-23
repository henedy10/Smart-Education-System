@extends('student.layout.app')

@section('title', 'رفع الواجب')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4">
    <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">رفع الواجب</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- اسم الواجب -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">اسم الواجب</label>
                <input type="text" name="title" id="title" required
                       class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>

            <!-- ملف الواجب -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">اختر ملف الواجب</label>
                <input type="file" name="file" id="file" required
                       class="w-full border border-gray-300 p-2 rounded bg-white file:bg-blue-600 file:text-white file:border-0 file:px-4 file:py-2 file:rounded file:cursor-pointer">
            </div>

            <!-- زر الإرسال -->
            <div class="text-center flex justify-between">
                <button type="submit"
                        class="bg-green-600 text-white font-semibold px-6 py-2 rounded hover:bg-green-700 transition">
                    رفع الواجب
                </button>
                <a href="{{route('show_student_homework',[$class,$subject])}}" class=" text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700 ">الصفحة السابقة</a>
            </div>
        </form>
    </div>
</div>
@endsection
