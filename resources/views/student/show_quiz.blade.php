@extends('student.layout.app')

@section('title','الكويزات المتاحة')

@section('style',"bg-gray-100 p-6")

@section('content')


    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-lg font-bold text-gray-800"> الإمتحانات الدراسيه</span>
        </div>
        <a href="{{route('student.quizAction.show',[$class,$subject])}}"  class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">الصفحة السابقة</a>
    </div>
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">الكويزات المتاحة</h1>
        @livewire('quiz-availability',['quiz'=>$quiz,'class'=>$class,'subject'=>$subject])
    </div>

@endsection
