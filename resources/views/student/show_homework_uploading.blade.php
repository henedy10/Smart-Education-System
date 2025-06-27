@extends('student.layout.app')

@section('title', 'رفع الواجب')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4">
    <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">رفع الواجب</h2>
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
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

        <form action="{{route('store_student_solution_homework')}}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <!-- ملف الواجب -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">اختر ملف حل الواجب</label>
                <input type="file" name="file" id="file"
                        class="w-full border border-gray-300 p-2 rounded bg-white file:bg-blue-600 file:text-white file:border-0 file:px-4 file:py-2 file:rounded file:cursor-pointer">
            </div>

            <!-- زر الإرسال -->
            <div class="text-center flex justify-between">
                <button type="submit"
                        value="{{$homework_id}}"
                        name="homework_id"
                        class="bg-green-600 text-white font-semibold px-6 py-2 rounded hover:bg-green-700 transition">
                    رفع الواجب
                </button>
                <a href="{{route('show_student_homework',[$class,$subject])}}" class=" text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700 ">الصفحة السابقة</a>
            </div>
        </form>
    </div>
</div>
@endsection
