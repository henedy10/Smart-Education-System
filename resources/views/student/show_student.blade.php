@extends('student.layout.app')

@section('title'){{__('messages.courses')}}@endsection

@section('style',"bg-gradient-to-br from-gray-100 to-blue-50 font-cairo p-6 min-h-screen")

@section('content')

    <!-- ✅ شريط الطالب -->
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
            <span class="text-lg font-semibold text-gray-800">👋 {{__('messages.greeting')}}, <span id="studentName">{{$info['student']->user->name}}</span></span>
        </div>
        <form action="{{route("logout")}}" method="POST">
            @csrf
            <button type="submit" class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">{{__('messages.logout')}}</button>
        </form>
    </div>

    <!-- 👇 باقي الصفحة كما هي -->
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold text-center text-blue-700 mb-10"> {{__('messages.courses')}} 📚</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- كارت مادة -->
            @foreach ($info['teachers'] as $teacher )
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 border-t-4 border-blue-500 group relative overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center gap-2 text-blue-600 mb-3">
                            <i data-lucide="calculator" class="w-5 h-5"></i>
                            <h2 class="text-xl font-semibold">{{$teacher->subject}}</h2>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Teacher : {{$teacher->user->name}}</p>
                        <a href="{{route('student.content.show',[$teacher->class, $teacher->subject])}}"  class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm transition">
                            {{__('messages.show')}}
                        </a>
                    </div>
                </div>
            @endforeach
            <!-- باقي المواد زي ما هي ... -->
        </div>
    </div>
@endsection


