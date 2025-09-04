@extends('student.layout.app')

@section('title','الواجبات الدراسيه ')

@section('content')

@section('style',"bg-gradient-to-br from-gray-100 to-blue-50 font-cairo p-6 min-h-screen")
        <!-- ✅ Header -->
        <div class="bg-white shadow rounded-lg p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i data-lucide="file-text" class="w-6 h-6 text-red-600"></i>
                <span class="text-lg font-semibold text-gray-800">📚 الواجبات الدراسية</span>
            </div>
            <a href="{{route('content.show',[$class,$subject])}}" class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700">الصفحة السابقة</a>
        </div>

        <!-- ✅ قائمة الواجبات -->
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-6">
            @forelse ($homeworks as $homework)
                <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition border-r-4 border-yellow-500">
                    <div class="flex items-center gap-2 text-yellow-600 mb-2">
                        <i data-lucide="clipboard-edit" class="w-5 h-5"></i>
                        <h2 class="text-lg font-semibold">{{$homework->title_homework}}</h2>
                    </div>

                    <p class="text-sm text-gray-700 mb-4">{{$homework->content_homework}}</p>
                    <p class="text-xs text-gray-500 mb-3">تاريخ التسليم: {{$homework->deadline}}</p>

                    <div class="flex">
                        <a href="{{url('storage/public/'.$homework->file_homework)}}" download class="bg-blue-600 text-white px-3 py-1 ml-2 rounded hover:bg-blue-500 text-sm">تحميل</a>
                        <a href="{{url('storage/public/'.$homework->file_homework)}}" target="_blank" class="bg-red-600 text-white px-3 py-1 ml-2 rounded hover:bg-red-500 text-sm">مشاهده</a>
                        @if ($currentTime<=$homework->deadline)
                            <form action="{{route('student.homeworkUpload.show',[$class,$subject])}}" method="GET">
                                @csrf
                                <button type="submit" value="{{$homework->id}}" name="upload_homework" class="bg-green-600 text-white px-3 py-1 ml-2 rounded hover:bg-green-500 text-sm">رفع الواجب</button>
                            </form>
                        @else
                            <form action="{{route('student.homeworkDetails.show',[$class,$subject])}}" method="GET">
                                @csrf
                                <button type="submit" name="homework_id" value="{{$homework->id}}" class="bg-green-600 text-white px-3 py-1 ml-2 rounded hover:bg-green-500 text-sm">تقييمك</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <h2 class="text-lg text-red-700 font-bold">  * لا يوجد واجبات حاليا  </h2>
            @endforelse
        </div>
@endsection


