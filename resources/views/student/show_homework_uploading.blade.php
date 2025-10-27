@extends('student.layout.app')

@section('title'){{__('messages.upload_homework_solution')}}@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@section('content')
    <div class="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4">
        <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">{{__('messages.upload_homework_solution')}}</h2>
                    @if(session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('danger'))
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                            {{ session('danger') }}
                        </div>
                    @endif
                    @if(session('failed'))
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                            {{ session('failed') }}
                        </div>
                    @endif


            <form action="{{route('student.homeworkSolution.store',[$class,$subject])}}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- ملف الواجب -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">{{__('messages.choose file')}}</label>
                    <input type="file" name="file" id="file"
                    class="w-full border border-gray-300 p-2 rounded bg-white file:bg-blue-600 file:text-white file:border-0 file:px-4 file:py-2 file:rounded file:cursor-pointer">
                </div>
                <div class="text-red-600">
                    @error('file')
                        {{"* ".$message}}
                    @enderror
                </div>
                <!-- زر الإرسال -->
                    <div class="text-center flex justify-between">
                        <button type="submit"
                            value="{{$homework_id}}"
                            name="homework_id"
                            class="bg-green-600 text-white font-semibold px-6 py-2 rounded hover:bg-green-700 transition">
                                {{__('messages.upload')}}
                        </button>
                    </div>
                <div>
                    <a href="{{route('student.homework.show',[$class,$subject])}}" class=" text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700 ">{{__('messages.previous-page')}}</a>
                </div>

            </form>
        </div>
    </div>
@endsection
