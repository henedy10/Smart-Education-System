@extends('teacher.layout.app')

@section('title') {{__('messages.results')}}@endsection

@section('content')

<body class="min-h-screen">

    <div class="container mx-auto p-6 bg-gray-100">
        <div class="bg-white rounded-xl shadow-md p-6">

            <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-800">{{__('messages.quizzes')}}</h2>
                <a href="{{route('teacher.index')}}" class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">{{__('messages.previous-page')}}</a>
            </div>

            <div class="flex flex-col sm:flex-row  items-center gap-4 mb-6">
                @if ($quizzes->isEmpty())
                    <h2 class="text-red-500 font-bold">* {{__('messages.no_results')}}</h2>
                @else
                <div>
                    <select id="quizFilter" class="border border-gray-300 rounded p-2 w-full sm:w-64">
                        <option value="all">{{__('messages.quizzes')}}</option>
                        @foreach ( $quizzes as $quiz )
                            <option value="{{$quiz->title}}">{{$quiz->title}}</option>
                        @endforeach
                    </select>
                </div>
                <button onclick="filterTable()"
                        class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                {{__('messages.filter')}}
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-700 border border-gray-200 rounded">
                    <thead class="bg-blue-100 text-blue-800">
                        <tr>
                            <th class="p-3 border border-gray-200">{{__('messages.title')}}</th>
                            <th class="p-3 border border-gray-200">{{__('messages.grade')}}</th>
                            <th class="p-3 border border-gray-200">{{__('messages.date')}}</th>
                            <th class="p-3 border border-gray-200">{{__('messages.duration')}}</th>
                            <th class="p-3 border border-gray-200">{{__('messages.results')}}</th>
                        </tr>
                    </thead>
                    <tbody id="resultsTable">
                        @foreach ($quizzes as $quiz )
                            <tr data-quiz="{{$quiz->title}}" class="hover:bg-gray-50 transition">
                                <td class="p-3 border"><span class="text-red-500">{{$quiz->title}}</span></td>
                                <td class="p-3 border"><span class="text-red-500">{{$quiz->quiz_mark}}</span></td>
                                <td class="p-3 border"><span class="text-red-500">{{$quiz->start_time}}</span></td>
                                <td class="p-3 border"><span class="text-red-500">{{$quiz->duration}}</span></td>
                                <td class="p-3 border">
                                    @if (now('africa/cairo')<$quiz->start_time->copy()->addMinutes($quiz->duration)->format('Y-m-d H:i:s'))
                                        <button type="submit" onclick="alert('لا يمكن رؤيه النتائج الا بعد انتهاء وقت الامتحان')"  class="text-green-600 font-semibold">{{__('messages.show')}}</button>
                                    @else
                                        <form action="{{route('teacher.quizResults.show',$TeacherId)}}" method="GET">
                                            <button type="submit" name="quiz_id" value="{{$quiz->id}}" class="text-green-600 font-semibold">{{__('messages.show')}}</button>
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
