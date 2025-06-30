@extends('student.layout.app')

@section('title')  الأسئلة - الاختبار @endsection

@section('content')
<body class="bg-gray-100 text-gray-800">

  <div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-xl shadow-md">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-blue-600">الأسئلة - اختبار: <span class="text-gray-800">الرياضيات</span></h1>
      <span class="text-sm text-gray-600">الوقت المتبقي: <span id="timer" class="font-bold text-red-600">{{$duration}}:00</span></span>
    </div>

    <form action="{{route('store_student_answers',[$class,$subject])}}" method="POST" id="quizForm">
        @csrf
        @foreach ($question as $Q)
            <div class="mb-6">
                <p class="font-semibold text-lg mb-2">{{$Q->title}}</p>
                <div class="space-y-2">
                    @foreach ($options[$Q->id] as $option)
                            <label class="block">
                                <input type="radio" name="answer[{{$Q->id}}]" value="{{$option->option_key}}" class="mr-2"> {{$option->option_title}}
                            </label>
                    @endforeach
                </div>
            </div>
        @endforeach

      <button type="submit" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
        إرسال الإجابات
      </button>
    </form>
  </div>

  <!-- عداد تنازلي بسيط -->
  <script>
    const startTime = new Date("{{ $start_time }}"); // من Laravel
    const duration = {{ $duration }}; // بالدقايق
    const endTime = new Date(startTime.getTime() + duration * 60000);

    function updateTimer() {
        const now = new Date();
        const remaining = Math.max(0, Math.floor((endTime - now) / 1000)); // بالثواني

        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;

        document.getElementById("timer").innerText = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        if (remaining <= 0) {
            clearInterval(timerInterval);
            alert("انتهى الوقت!");
            document.getElementById("quizForm").submit(); // يرسل الإجابات
        }
    }

    const timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
</script>
@endsection
