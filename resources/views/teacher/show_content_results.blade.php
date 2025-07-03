@extends('teacher.layout.app')

@section('title') نتائج الطلاب @endsection

@section('content')

<body class="min-h-screen">

    <div class="container mx-auto p-6 bg-gray-100">
        <div class="bg-white rounded-xl shadow-md p-6">

            <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800">نتائج الطلاب</h2>
                <a href="{{route('show_results',$TeacherId)}}" class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
            </div>

            <div class="overflow-x-auto">
                @if ($results->isEmpty())
                <p class="text-red-500">* لا يوجد نتائج للامتحانات حاليا</p>
                @else
                <table class="w-full text-sm text-right text-gray-700 border border-gray-200 rounded">
                    <thead class="bg-blue-100 text-blue-800">
                        <tr>
                            <th class="p-3 border border-gray-200">اسم الطالب </th>
                            <th class="p-3 border border-gray-200">درجة الطالب</th>
                            <th class="p-3 border border-gray-200">النسبة المئوية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $results as $result )
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 border">{{$result->student->user->name}}</td>
                                    <td class="p-3 border">{{$result->student_mark}}</td>
                                    <td class="p-3 border">{{round(($result->student_mark/$result->quiz_mark)*100,2)}}%</td>
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
