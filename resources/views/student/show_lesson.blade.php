@extends('student.layout.app')

@section('title'){{__('messages.lessons')}}@endsection

@section('content')

@section('style', "bg-gradient-to-br from-gray-100 to-blue-50 font-cairo p-6 min-h-screen")
    <!-- ✅ Header -->
    <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <i data-lucide="video" class="w-6 h-6 text-blue-600"></i>
            <span class="text-lg font-bold text-gray-800">📺 {{__('messages.lessons')}} </span>
        </div>
        <a href="{{route('student.content.show', [$class, $subject])}}"
            class="w-full md:w-auto text-center border border-red-600 text-red-600 font-medium px-5 py-2 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">{{__('messages.previous-page')}}
        </a>
    </div>

    <!-- ✅ محتوى المحاضرات -->
    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6">
        @forelse ($lessons as $lesson)
            <!-- 🧪 محاضرة واحدة -->
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition border-r-4 border-blue-500">
                <div class="flex items-center gap-2 text-blue-600 mb-3">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                    <h2 class="text-lg font-semibold">{{$lesson->title_lesson}}</h2>
                </div>
                <div class="flex gap-2">
                    <a href="{{asset('storage/' . $lesson->file_lesson)}}" target="_blank"
                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">{{__('messages.show')}}</a>
                    <a href="{{asset('storage/' . $lesson->file_lesson)}}" download
                        class="bg-gray-200 text-gray-800 px-3 py-1 rounded hover:bg-gray-300 text-sm">{{__('messages.upload')}}</a>
                    <button onclick="handleUpload(this)" data-lesson-id="{{$lesson->id}}"
                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm flex items-center gap-1">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                        Summaries
                    </button>
                </div>

                <div id="result-{{$lesson->id}}" class="mt-2 hidden"></div>
            </div>
        @empty
            <h2 class="text-lg text-red-700 font-bold">* {{__('messages.no_lesson')}}</h2>
        @endforelse
    </div>
    <script>
        async function handleUpload(button) {
            const lessonId = button.getAttribute('data-lesson-id');
            const resultDiv = document.getElementById('result-' + lessonId);

            try {
                resultDiv.classList.remove('hidden');
                resultDiv.innerText = 'جاري المعالجة...';
                resultDiv.className = 'mt-2 text-sm text-blue-600 font-medium italic animate-pulse';

                const response = await fetch('{{ route('student.lesson.analysis') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        lesson_id: lessonId
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    resultDiv.innerText = data.summary;
                    resultDiv.className = 'mt-3 p-4 bg-blue-50 border-l-4 border-blue-500 text-gray-700 text-sm rounded shadow-sm whitespace-pre-wrap';
                } else {
                    resultDiv.innerText = 'حصل خطأ: ' + (data.error || 'Unknown error');
                    resultDiv.className = 'mt-2 text-sm text-red-600 font-medium';
                }

            } catch (error) {
                resultDiv.innerText = 'حصل خطأ في الاتصال: ' + error.message;
                resultDiv.className = 'mt-2 text-sm text-red-600 font-medium';
            }
        }
    </script>
@endsection