@extends('student.layout.app')

@section('title'){{__('messages.quiz')}}@endsection

@section('style',"bg-gray-100 text-gray-800")

@section('content')


    <div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">{{__('messages.quiz')}}</h1>
            <span class="text-sm text-gray-600">{{__('messages.time_remaining')}}<span id="timer" class="font-bold text-red-600">{{$quiz->duration}}:00</span></span>
        </div>

        <form action="{{route('student.answers.store',[$class,$subject])}}" method="POST" id="quizForm">
            @csrf
            @foreach ($quiz->questions as $Q)
                <div class="mb-6">
                    <p class="font-semibold text-lg mb-2">{{$Q->title}}</p>
                    <div class="space-y-2">
                        @foreach ($Q->options as $option)
                            <label class="block">
                                <input type="radio" name="answer[{{$Q->id}}]" value="{{$option->option_key}}" class="mr-2"> {{$option->option_title}}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

        <button type="submit" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
            {{__('messages.submit')}}
        </button>
        </form>
    </div>

    <!-- عداد تنازلي بسيط -->
    <script>
        const startTime = new Date("{{ $quiz->start_time }}"); // من Laravel
        const duration = {{ $quiz->duration }}; // بالدقايق
        const endTime = new Date(startTime.getTime() + duration * 60000);

        function updateTimer() {
            const now = new Date();
            const remaining = Math.max(0, Math.floor((endTime - now) / 1000)); // بالثواني

            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;

            document.getElementById("timer").innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

            if (remaining <= 0) {
                clearInterval(timerInterval);
                alert({{__('messages.time_finish')}});
                document.getElementById("quizForm").submit(); // يرسل الإجابات
            }
        }

        const timerInterval = setInterval(updateTimer, 1000);
        updateTimer();
    </script>
@endsection
