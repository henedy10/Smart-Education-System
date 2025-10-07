@extends('student.layout.app')

@section('title'){{__('messages.quizzes')}}@endsection

@section('style',"bg-gray-100 min-h-screen flex items-center justify-center p-6")

@section('content')


    <div class="max-w-xl w-full bg-white rounded-lg shadow-lg p-6">
        <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
            <a href="{{route('student.content.show',[$class,$subject])}}"  class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300"> {{__('messages.previous-page')}}</a>
        </div>

        <div class="flex flex-col gap-6">
            <!-- زر الاختبارات المتاحة -->
            <a href="{{route('student.availableQuiz.show',[$class,$subject])}}"
                class="block w-full bg-green-500 hover:bg-green-600 text-white text-lg text-center py-4 rounded-lg shadow transition duration-300">
                {{__('messages.show_available_quizzes')}}
            </a>

            <!-- زر نتائج الامتحانات السابقة -->
            <a href="{{route('student.results.show',[$class,$subject])}}"
                class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-lg text-center py-4 rounded-lg shadow transition duration-300">
                {{__('messages.show_previous_results')}}
            </a>
        </div>
    </div>

@endsection
