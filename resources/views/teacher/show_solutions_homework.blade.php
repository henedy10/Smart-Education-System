@extends('teacher.layout.app')

@section('title'){{__('messages.solutions')}}@endsection

@section('content')
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
                <h1 class="text-lg font-bold text-gray-800">{{__('messages.solutions')}}</h1>
                <a href="{{route('teacher.homeworkCorrection.show',$TeacherId)}}" class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">{{__('messages.previous-page')}}</a>
            </div>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="overflow-x-auto">
                @if ($solutions->isEmpty())
                <p class="text-lg text-red-700 font-bold">* {{__('messages.no_homeworkSolutions')}}</p>
                @else
                <table class="min-w-full bg-white border border-gray-200 text-right text-sm">
                    <thead class="bg-blue-100 text-blue-800">
                        <tr>
                            <th class="px-4 py-2 border">{{__('messages.name')}}</th>
                            <th class="px-4 py-2 border">{{__('messages.solutions')}}</th>
                            <th class="px-4 py-2 border">{{__('messages.grade')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solutions as $solution)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border">{{$solution->student->user->name}}</td>
                            <td class="px-4 py-2 border">
                                <a href="{{asset('storage/'.$solution->homework_solution_file)}}" target="_blank"
                                    class="bg-red-600 text-white px-3 py-1 ml-2 rounded hover:bg-red-500 text-sm">{{__('messages.show')}}</a>
                                    <a href="{{asset('storage/'.$solution->homework_solution_file)}}" download target="_blank"
                                        class="bg-blue-600 text-white px-3 py-1 ml-2 rounded hover:bg-blue-500 text-sm">{{__('messages.upload')}}</a>
                                    </td>
                                    <td class="px-4 py-2 border">
                                        @if ($solution->correction_status)
                                            <form action="{{route('teacher.homeworkGrades.update',$solution->student_id)}}" method="POST">
                                                @csrf
                                                <div class="flex">
                                                    <input type="number" name="student_mark"  class="border border-amber-600 w-full p-2 ml-1.5" min="0" max="{{$solution->homework->homework_mark}}">
                                                    <button type="submit" name="homework_id" value="{{$solution->homework_id}}" class="bg-green-600 text-white px-3 py-1 ml-2 rounded hover:bg-green-500 p-2">{{__('messages.modification')}}</button>
                                                </div>
                                                <span class="text-danger"> @error('student_mark') {{"* ".$message}} @enderror </span>
                                            </form>
                                        @else
                                            <form action="{{route('teacher.homeworkGrades.store',$solution->student_id)}}" method="POST">
                                                @csrf
                                                <div class="flex">
                                                    <input type="hidden" name="solution_id" value="{{$solution->id}}">
                                                    <input type="number" name="student_mark" class="border border-amber-600 w-full p-2 ml-1.5" min="0" max="{{$solution->homework->homework_mark}}">
                                                    <button type="submit" name="homework_id" value="{{$solution->homework_id}}" class="bg-green-600 text-white px-3 py-1 ml-2 rounded hover:bg-green-500 p-2">{{__('messages.correct')}}</button>
                                                </div>
                                                <span class="text-danger"> @error('student_mark') {{"* ".$message}} @enderror </span>
                                            </form>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                @endif
            </div>
        </div>
    </div>
</body>
@endsection
