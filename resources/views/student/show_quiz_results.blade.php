@extends('student.layout.app')

@section('title'){{__('messages.results')}}@endsection

@section('content')

@section('style',"bg-gray-100 min-h-screen p-6 flex items-center justify-center")


    <div class="w-full max-w-4xl bg-white shadow-xl rounded-lg p-6">
        <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
            <a href="{{route('student.quizAction.show',[$class,$subject])}}"  class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300"> {{__('messages.previous-page')}}</a>
        </div>

        <!-- جدول النتائج -->
        <div class="w-full max-w-4xl mx-auto mt-6">
            @forelse ($results as $result)
                @if(now() >= $result->quiz->start_time)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6 border border-gray-200 transition hover:shadow-lg">
                        <div class="flex justify-between items-center px-6 py-4 bg-gray-50 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $result->quiz->title }}</h3>
                            <span class="text-sm text-gray-500">
                                {{ $result->quiz->start_time->format('Y-m-d H:i') }}
                            </span>
                        </div>

                        <div class="p-6">
                            <table class="min-w-full text-right text-sm text-gray-700">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-gray-600">{{ __('messages.title') }}</th>
                                        <th class="py-3 px-4 border-b border-gray-300 font-semibold text-gray-600">{{ __('messages.grade') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 border-b border-gray-200">{{ $result->quiz->title }}</td>
                                        <td class="py-3 px-4 border-b border-gray-200 font-semibold text-green-700">
                                            {{ $result->student_mark }}/{{ $result->quiz_mark }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-10">
                    <h2 class="text-lg text-red-700 font-bold">
                        * {{ __('messages.no_results') }}
                    </h2>
                </div>
            @endforelse
        </div>
    </div>

@endsection
