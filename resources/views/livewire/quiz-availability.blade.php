
<div wire:poll.5s="checkAvailability">
    @if ($isAvailable)
        <ul class="space-y-4">
            <li class="bg-gray-50 p-4 rounded shadow flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-semibold">{{$quiz->title}}</h2>
                    <p class="text-sm text-gray-600">عدد الأسئلة :{{$num_questions}} </p>
                    <p class="text-sm text-gray-600">الوقت : {{$quiz->duration}}</p>
                </div>
                <a href="{{route('quizContent.show',[$class,$subject])}}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    ابدأ الاختبار
                </a>
            </li>
        </ul>
    @else
        <h2 class="text-lg text-red-700">  * {{__('messages.no_quiz')}} </h2>
    @endif
</div>
