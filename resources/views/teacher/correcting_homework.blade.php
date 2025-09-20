@extends('teacher.layout.app')

@section('title')  تصحيح الواجبات @endsection

@section('content')
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded-xl shadow-md">
            <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
                <h1 class="text-lg font-bold text-gray-800">الواجبات التي تم رفعها</h1>
                <a href="{{route('teacher.homeworkAction.show',$TeacherId)}}" class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
            </div>
            @if ($homeworks->isEmpty())
                <h2 class="text-red-500 font-bold">* لا يوجد واجبات حتي الأن</h2>
            @else

                <!-- جدول الواجبات -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 text-right text-sm">
                        <thead class="bg-blue-100 text-blue-800">
                            <tr>
                                <th class="px-4 py-2 border">اسم الواجب</th>
                                <th class="px-4 py-2 border">المطلوب</th>
                                <th class="px-4 py-2 border">اخر ميعاد للتسليم</th>
                                <th class="px-4 py-2 border">درجه الواجب</th>
                                <th class="px-4 py-2 border">رابط  حلول الطلاب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $time = now('africa/cairo');
                            @endphp
                            @foreach ($homeworks as $homework )
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 border">{{$homework->title_homework}}</td>
                                    <td class="px-4 py-2 border">{{$homework->content_homework}}</td>
                                    <td class="px-4 py-2 border">{{$homework->deadline}}</td>
                                    <td class="px-4 py-2 border">{{$homework->homework_mark}}</td>
                                    <td class="px-4 py-2 border text-blue-600 underline cursor-pointer">
                                        @if ($time<$homework->deadline)
                                            <button type="button" onclick="alert('يمكنك رؤية حلول الطلاب بعد انتهاء وقت التسليم')">
                                                اضغط هنا
                                            </button>
                                        @else
                                            <form action="{{route('teacher.homeworkSolutions.show',$TeacherId)}}" method="get">
                                                @csrf
                                                <button type="submit" name="homework_id" value="{{$homework->id}}">اضغط هنا</button>
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
