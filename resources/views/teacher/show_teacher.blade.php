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
                <a href="{{route('teacher.lessons.show',$teacher)}}" class="block py-2 px-4 rounded hover:bg-blue-100 text-gray-700"><i class="fas fa-chalkboard-teacher mr-2"></i> المحاضرات</a>
                <a href="{{route('teacher.homeworkAction.show',$teacher)}}" class="block py-2 px-4 rounded hover:bg-green-100 text-gray-700"><i class="fas fa-tasks mr-2"></i> الواجبات</a>
                <a href="{{route('teacher.quizzes.create',$teacher)}}" class="block py-2 px-4 rounded hover:bg-yellow-100 text-gray-700"><i class="fas fa-file-alt mr-2"></i> الامتحانات</a>
                <a href="{{route('teacher.quizzes.show',$teacher)}}" class="block py-2 px-4 rounded hover:bg-red-200 text-gray-700"><i class="fas fa-chart-line mr-2"></i> النتائج</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 ">
            <button class="md:hidden mb-4 text-blue-600" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i> القائمة
            </button>
            <div class="bg-white shadow-md rounded-2xl p-6 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Left: Avatar + Name -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xl font-bold shadow">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">مرحبًا 👋</p>
                        <h2 class="text-xl font-semibold text-gray-800">
                            <span id="studentName">{{$teacher->user->name}}</span>
                        </h2>
                    </div>
                </div>

                <!-- Right: Logout -->
                <form action="{{route("LogOut")}}" method="GET" class="w-full md:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full md:w-auto px-6 py-2 border border-red-600 text-red-600 rounded-xl font-medium hover:bg-red-600 hover:text-white transition-all duration-300">
                        تسجيل الخروج
                    </button>
                </form>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-blue-600 mb-2">عدد المحاضرات</h3>
                    <p class="text-3xl font-semibold text-blue-800">{{$teacher->lessons_count}}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-green-600 mb-2">عدد الواجبات</h3>
                    <p class="text-3xl font-semibold text-green-800">{{$teacher->homeworks_count}}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-yellow-600 mb-2">عدد الامتحانات</h3>
                    <p class="text-3xl font-semibold text-yellow-800">{{$teacher->quizzes_count}}</p>
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

