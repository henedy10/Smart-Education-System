@extends('student.layout.app')

@section('title'){{__('messages.content')}}@endsection

@section('style',"bg-gradient-to-tr from-gray-100 to-blue-50 font-cairo p-6 min-h-screen")

@section('content')

    <!-- ✅ Header -->
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-lg font-semibold text-gray-800">{{__('messages.content')}}</span>
        </div>
        <a href="{{route('student.index')}}" class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300"> {{__('messages.previous-page')}}</a>
    </div>
    <!-- ✅ Dashboard Content -->
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- 🎓 المحاضرات -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition border-t-4 border-blue-500">
                <div class="flex items-center gap-3 mb-4 text-blue-600">
                <i data-lucide="video" class="w-6 h-6"></i>
                <h2 class="text-xl font-semibold">{{__('messages.lessons')}}</h2>
                </div>
                <p class="text-sm text-gray-600 mb-4">{{__("messages.lesson_msg")}}</p>
                <a href="{{route('student.lesson.show',[$class,$subject])}}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm" >{{__('messages.show')}}</a>
            </div>

            <!-- 📄 الواجبات -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition border-t-4 border-yellow-500">
                <div class="flex items-center gap-3 mb-4 text-yellow-600">
                <i data-lucide="file-text" class="w-6 h-6"></i>
                <h2 class="text-xl font-semibold">{{__('messages.homeworks')}}</h2>
                </div>
                <p class="text-sm text-gray-600 mb-4">{{__('messages.homework_msg')}}</p>
                <a href="{{route('student.homework.show',[$class,$subject])}}" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm"> {{__('messages.show')}}</a>
            </div>

            <!-- 📝 الامتحانات -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition border-t-4 border-green-500">
                <div class="flex items-center gap-3 mb-4 text-green-600">
                <i data-lucide="edit" class="w-6 h-6"></i>
                <h2 class="text-xl font-semibold">{{__('messages.quizzes')}}</h2>
                </div>
                <p class="text-sm text-gray-600 mb-4">{{__('messages.quiz_msg')}}</p>
                <a href="{{route('student.quizAction.show',[$class,$subject])}}" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm"> {{__('messages.show')}}</a>
            </div>
        </div>
    </div>
@endsection


