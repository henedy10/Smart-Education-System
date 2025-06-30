@extends('teacher.layout.app')

@section('title') نتائج الطلاب @endsection

@section('content')

<body class="min-h-screen">

    <div class="container mx-auto p-6 bg-gray-100">
        <div class="bg-white rounded-xl shadow-md p-6">

            <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800">قائمة الإمتحانات</h2>
                <a href="{{route('show_teacher')}}" class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
            </div>

            <div class="flex flex-col sm:flex-row  items-center gap-4 mb-6">
                <div>
                    <select id="quizFilter" class="border border-gray-300 rounded p-2 w-full sm:w-64">
                        <option value="all">كل الاختبارات</option>
                        @foreach ( $quizzes as $quiz )
                            <option value="{{$quiz->title}}">{{$quiz->title}}</option>
                        @endforeach
                    </select>
                </div>
                <button onclick="filterTable()"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                فلترة
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-700 border border-gray-200 rounded">
                    <thead class="bg-blue-100 text-blue-800">
                        <tr>
                            <th class="p-3 border border-gray-200">الاختبار</th>
                            <th class="p-3 border border-gray-200">درجه الامتحان</th>
                            <th class="p-3 border border-gray-200">تاريخ الامتحان</th>
                            <th class="p-3 border border-gray-200">نتائج الطلاب</th>
                        </tr>
                    </thead>
                    <tbody id="resultsTable">
                        @foreach ($quizzes as $quiz )

                            @php
                                    $start = \Carbon\Carbon::parse($quiz->start_time);
                            @endphp
                            <tr data-quiz="{{$quiz->title}}" class="hover:bg-gray-50 transition">
                                <td class="p-3 border">{{$quiz->title}}</td>
                                <td class="p-3 border">{{$quiz->quiz_mark}}</td>
                                <td class="p-3 border">{{$quiz->start_time}}</td>
                                <td class="p-3 border">
                                    @if ($time<$start->copy()->addMinutes($quiz->duration)->format('Y-m-d H:i:s'))
                                        <button type="submit" onclick="alert('لا يمكن رؤيه النتائج الا بعد انتهاء وقت الامتحان')"  class="text-green-600 font-semibold">اضغط هنا</button>
                                    @else
                                        <form action="{{route('show_content_results',$TeacherId)}}" method="GET">
                                            @csrf
                                            <button type="submit" name="quiz_id" value="{{$quiz->id}}" class="text-green-600 font-semibold">اضغط هنا</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

  <!-- ✅ JavaScript للفلترة -->
    <script>
        function filterTable() {
        const selectedQuiz = document.getElementById('quizFilter').value;
        const rows = document.querySelectorAll('#resultsTable tr');

        rows.forEach(row => {
            const quiz = row.getAttribute('data-quiz');
            if (selectedQuiz === 'all' || quiz === selectedQuiz) {
            row.style.display = '';
            } else {
            row.style.display = 'none';
            }
        });
        }
    </script>
</body>

@endsection
