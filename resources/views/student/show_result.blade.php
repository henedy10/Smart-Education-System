@extends('student.layout.app')

@section('title'){{__('messages.result')}}@endsection

@section('style',"bg-gray-100 min-h-screen flex items-center justify-center p-4")

@section('content')
    <div class="bg-white shadow-xl rounded-lg w-full max-w-md p-6">
        <h1 class="text-2xl font-bold text-center text-blue-700 mb-4">{{__('messages.result')}}</h1>

        <div class="mb-4 text-center">
            <p class="text-gray-700 text-lg">{{__('messages.name') }}: <span class="font-semibold text-black">{{$student->user->name}}</span></p>
            <p class="text-gray-700 text-lg">{{__('messages.title') }}: <span class="font-semibold text-black">{{$quiz->title}}</span></p>
        </div>

        <div class="bg-blue-100 text-blue-800 text-center py-4 rounded-lg mb-4">
            <p class="text-xl font-bold">{{__('messages.grade'). ":" .$studentMark ."/". $quiz->quiz_mark}}</p>
        </div>

        <div class="text-sm text-gray-600 text-center">
            <p>{{__('messages.assessment_quiz_msg')}}🎉</p>
        </div>

        <div class="mt-6 text-center">
            <a href="{{route('student.content.show',[$class,$subject])}}" class=" bg-green-500 p-2 rounded hover:text-white">{{__('messages.back_home')}}</a>
        </div>
    </div>
@endsection

