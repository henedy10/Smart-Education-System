@extends('student.layout.app')

@section('title'){{__('messages.assessment')}}@endsection

@section('style',"bg-gray-100 flex items-center justify-center min-h-screen p-4")

@section('content')

    <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-6 border-t-4 border-blue-600">
        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">{{__('messages.assessment_title')}}</h2>
        @if (is_null($homeworkDetails))
                <p class="text-red-600 text-bold">* {{__('messages.no_assessment')}}</p>
        @else
            @if (is_null($homeworkDetails->homeworkGrade))
                <p class="text-red-500 text-bold">* {{__('messages.no_assessment')}}</p>
            @else
                <div class="space-y-3 text-gray-700">
                    <div class="flex justify-between">
                        <span class="font-semibold">  {{__('messages.file')}} :</span>
                        <a href="{{asset('storage/'.$homeworkDetails->homework_solution_file)}}"
                        target="_blank"
                        class=" bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded"
                        >
                            {{__('messages.show')}}
                        </a>
                    </div>

                    <div class="flex justify-between">
                        <span class="font-semibold">{{__('messages.grade')}} :</span>
                        <span class="text-green-600 font-bold">{{$homeworkDetails->homeworkGrade->student_mark}} / {{$homeworkDetails->homework->homework_mark}}</span>
                    </div>
                </div>
            @endif
        @endif

        <div class="mt-6 text-center">
            <a href="{{route('student.homework.show',[$class,$subject])}}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded">
                {{__('messages.previous-page')}}
            </a>
        </div>

    </div>
@endsection
