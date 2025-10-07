@extends('teacher.layout.app')

@section('title')  تصحيح الواجبات @endsection

@section('content')
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded-xl shadow-md">

            <!-- 🔹 الهيدر -->
            <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-800">📚 {{__('messages.history')}}</h1>
                <a href="{{route('teacher.homeworkAction.show',$TeacherId)}}"
                   class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">
                    {{__('messages.previous-page')}}
                </a>
            </div>

            @if ($homeworks->isEmpty())
                <!-- رسالة فارغة -->
                <div class="text-center py-10">
                    <p class="text-red-600 font-semibold text-lg">🚫{{__('messages.no_homework')}}</p>
                </div>
            @else
                <!-- جدول الواجبات -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-right text-sm rounded-lg overflow-hidden">
                        <thead class="bg-gradient-to-r from-blue-100 to-blue-200 text-blue-900">
                            <tr>
                                <th class="px-4 py-3 border">{{__('messages.title')}}</th>
                                <th class="px-4 py-3 border">{{__('messages.required')}}</th>
                                <th class="px-4 py-3 border">{{__('messages.deadline')}}</th>
                                <th class="px-4 py-3 border">{{__('messages.grade')}}</th>
                                <th class="px-4 py-3 border">{{__('messages.solutions')}}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $time = now('africa/cairo');
                            @endphp
                            @foreach ($homeworks as $homework )
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3">{{$homework->title_homework}}</td>
                                    <td class="px-4 py-3">{{$homework->content_homework}}</td>
                                    <td class="px-4 py-3 text-gray-700 font-medium">
                                        {{ \Carbon\Carbon::parse($homework->deadline)->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="px-4 py-3 font-bold text-gray-800">{{$homework->homework_mark}}</td>
                                    <td class="px-4 py-3">
                                        @if ($time < $homework->deadline)
                                            <button type="button"
                                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg cursor-not-allowed opacity-70">
                                                {{__('messages.show')}}
                                            </button>
                                        @else
                                            <form action="{{route('teacher.homeworks.show',$TeacherId)}}" method="get">
                                                @csrf
                                                <button type="submit" name="homework_id" value="{{$homework->id}}"
                                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                                    {{__('messages.show')}}
                                                </button>
                                            </form>
                                        @endif
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
