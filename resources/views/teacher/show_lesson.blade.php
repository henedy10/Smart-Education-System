@extends('teacher.layout.app')

@section('title')  {{__('messages.lessons')}} @endsection

@section('content')
<body class="min-h-screen bg-gray-100">
    <div class="max-w-5xl mx-auto py-10 px-4">

        <!-- Header -->
        <div class="bg-white shadow-md rounded-2xl p-6 mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-gray-800">📚 {{__('messages.lessons')}}</h1>
            <a href="{{route('teacher.index')}}"
               class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-6 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">
                {{__('messages.previous-page')}}
            </a>
        </div>

        <!-- رفع محاضرة جديدة -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
            @if(session('success'))
                <div class="mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg p-3 text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <h2 class="text-xl font-semibold mb-6 text-gray-700">{{__('messages.new-upload-lesson')}}</h2>
            <form action="{{route('teacher.lessons.store',$TeacherId)}}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- عنوان المحاضرة -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-600"> {{__('messages.title')}}</label>
                    <input type="text" name="title_lesson"
                           class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    @error('title_lesson')
                        <p class="text-red-500 text-sm mt-1">* {{ $message }}</p>
                    @enderror
                </div>

                <!-- ملف المحاضرة -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-600"> {{__('messages.upload')}}</label>
                    <input type="file" name="file_lesson"
                           class="w-full border rounded-lg p-3 bg-gray-50">
                    @error('file_lesson')
                        <p class="text-red-500 text-sm mt-1">* {{ $message }}</p>
                    @enderror
                </div>

                <!-- زرار -->
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-xl shadow transition-all duration-300">
                    <i class="fas fa-upload ml-2"></i> {{__('messages.upload')}}
                </button>
            </form>
        </div>

        <!-- عرض المحاضرات السابقة -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6 text-gray-700">{{__('messages.history')}}</h2>

            @if ($lessons->isEmpty())
                <p class="text-red-600 font-medium">* {{__('messages.no_lesson')}}</p>
            @else
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-sm text-gray-700">
                                <th class="p-3 border">{{__('messages.title')}}</th>
                                <th class="p-3 border text-center">{{__('messages.file')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $lesson)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border p-3">{{$lesson->title_lesson}}</td>
                                    <td class="border p-3 text-center">
                                        <a href="{{asset('storage/'.$lesson->file_lesson)}}" download
                                           class="inline-block border border-green-600 text-green-600 font-medium px-5 py-1.5 rounded-lg hover:bg-green-600 hover:text-white transition-all duration-300">
                                           {{__('messages.upload')}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>


@endsection

