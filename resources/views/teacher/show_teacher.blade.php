@extends('teacher.layout.app')

@section('title')  لوحه التحكم @endsection

@section('content')
    <style>
    .sidebar {
        transition: all 0.3s ease-in-out;
    }
    .sidebar-hidden {
        transform: translateX(100%);
    }
    </style>
<body class="bg-gray-100 min-h-screen">
    <div class="flex flex-col md:flex-row">

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar w-full md:w-64 bg-white shadow-lg p-4 space-y-4">
            <div class="flex justify-between items-center">
                <button class="md:hidden text-gray-600" onclick="toggleSidebar()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="space-y-2">
                <a href="{{route('show_teacher_lessons',$teacher)}}" class="block py-2 px-4 rounded hover:bg-blue-100 text-gray-700"><i class="fas fa-chalkboard-teacher mr-2"></i> محاضراتي</a>
                <a href="{{route('choose_action_homework',$teacher)}}" class="block py-2 px-4 rounded hover:bg-green-100 text-gray-700"><i class="fas fa-tasks mr-2"></i> الواجبات</a>
                <a href="{{route('create_teacher_quiz',$teacher)}}" class="block py-2 px-4 rounded hover:bg-yellow-100 text-gray-700"><i class="fas fa-file-alt mr-2"></i> الامتحانات</a>
                <a href="{{route('show_results',$teacher)}}" class="block py-2 px-4 rounded hover:bg-red-200 text-gray-700"><i class="fas fa-chart-line mr-2"></i> النتائج</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 ">
            <button class="md:hidden mb-4 text-blue-600" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i> القائمة
            </button>
            <div class="flex justify-between bg-white shadow rounded-lg p-4 mb-6 ">
                <div class="flex items-center gap-3">
                    <i data-lucide="user" class="w-6 h-6 text-blue-600"></i>
                    <span class="text-lg font-semibold text-gray-800">👋 مرحبًا، <span id="studentName">{{$teacher->user->name}}</span></span>
                </div>
                <form action="{{route("log_out_student")}}" method="GET">
                    @csrf
                    <button type="submit" class="text-white bg-red-600 rounded px-6 py-2 hover:bg-red-700"> تسجيل الخروج</button>
                </form>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-blue-600 mb-2">عدد المحاضرات</h3>
                    <p class="text-3xl font-semibold text-blue-800">{{$num_lessons}}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-green-600 mb-2">عدد الواجبات</h3>
                    <p class="text-3xl font-semibold text-green-800">{{$num_homeworks}}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-yellow-600 mb-2">عدد الامتحانات</h3>
                    <p class="text-3xl font-semibold text-yellow-800">{{$num_quizzes}}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('sidebar-hidden');
        }
    </script>
</body>

@endsection

