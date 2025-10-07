@extends('student.layout.app')

@section('title'){{__('messages.results')}}@endsection

@section('content')

@section('style',"bg-gray-100 min-h-screen p-6 flex items-center justify-center")


    <div class="w-full max-w-4xl bg-white shadow-xl rounded-lg p-6">
        <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
            <a href="{{route('student.quizAction.show',[$class,$subject])}}"  class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300"> {{__('messages.previous-page')}}</a>
        </div>

        <!-- جدول النتائج -->
        <div class="overflow-x-auto">
            @forelse ($results as $result)
                <table class="min-w-full bg-white border border-gray-300 rounded">
                    <thead class="bg-gray-100 text-right text-sm">
                        <tr>
                            <th class="py-3 px-4 border-b">{{__('messages.title')}} </th>
                            <th class="py-3 px-4 border-b">{{__('messages.grade')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(now()>=$result->quiz->start_time)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{$result->quiz->title}}</td>
                                <td class="py-3 px-4 border-b font-semibold text-green-700">{{$result->student_mark}}/{{$result->quiz_mark}}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @empty
                <h2 class="text-lg text-red-700 font-bold">* {{__('messages.no_results')}}</h2>
            @endforelse
        </div>
    </div>

@endsection
