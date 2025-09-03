@extends('student.layout.app')

@section('title','الكويزات المتاحة')

@section('style',"bg-gray-100 p-6")

@section('content')


    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-lg font-bold text-gray-800"> الإمتحانات الدراسيه</span>
        </div>
        <a href="{{route('student.quizAction.show',[$class,$subject])}}"  class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
    </div>
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">الكويزات المتاحة</h1>
        @livewire('quiz-availability',['quiz'=>$quiz,'class'=>$class,'subject'=>$subject])
    </div>

@endsection
