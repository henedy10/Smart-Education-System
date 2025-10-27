@extends('student.layout.app')

@section('title'){{__('messages.homeworks')}}@endsection

@section('content')

@section('style',"bg-gradient-to-br from-gray-100 to-blue-50 font-cairo p-6 min-h-screen")
        <!-- ✅ Header -->
        <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i data-lucide="file-text" class="w-6 h-6 text-red-600"></i>
                <span class="text-lg font-semibold text-gray-800">📚  {{__('messages.homeworks')}}</span>
            </div>
            <a href="{{route('student.content.show',[$class,$subject])}}" class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">{{__('messages.previous-page')}}</a>
        </div>
        <!-- ✅ قائمة الواجبات -->
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6">
            @forelse ($homeworks as $homework)
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition border-r-4 border-yellow-500">
                    <div class="flex items-center gap-2 text-yellow-600 mb-2">
                        <i data-lucide="clipboard-edit" class="w-5 h-5"></i>
                        <h2 class="text-lg font-semibold">{{$homework->title_homework}}</h2>
                    </div>

                    <p class="text-sm text-gray-700 mb-4">{{$homework->content_homework}}</p>
                    <p class="text-xs text-gray-500 mb-3"> {{__('messages.deadline')}}: {{$homework->deadline}}</p>
                    <div class="flex">
                        <a href="{{asset('storage/'.$homework->file_homework)}}" download class="bg-blue-600 text-white px-3 py-1 ml-2 rounded hover:bg-blue-500 text-sm">{{__('messages.download')}}</a>
                        <a href="{{asset('storage/'.$homework->file_homework)}}" target="_blank" class="bg-red-600 text-white px-3 py-1 ml-2 rounded hover:bg-red-500 text-sm">{{__('messages.show')}}</a>
                        @if (now('africa/cairo')<=$homework->deadline)
                            <form action="{{route('student.homeworkSolution.create',[$class,$subject])}}" method="GET">
                                <button type="submit" value="{{$homework->id}}" name="upload_homework" class="bg-green-600 text-white px-3 py-1 ml-2 rounded hover:bg-green-500 text-sm">{{__('messages.upload')}}</button>
                            </form>
                        @else
                            <form action="{{route('student.homeworkDetails.show',[$class,$subject])}}" method="GET">
                                <button type="submit" name="homework_id" value="{{$homework->id}}" class="bg-green-600 text-white px-3 py-1 ml-2 rounded hover:bg-green-500 text-sm">{{__('messages.grade')}}</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <h2 class="text-lg text-red-700 font-bold">  * {{__('messages.no_homework')}}</h2>
            @endforelse
        </div>
@endsection


