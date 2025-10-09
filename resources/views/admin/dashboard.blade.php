<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{__('messages.page_direction')}}">
<head>
    <meta charset="UTF-8">
    <title>{{__('messages.dashboard')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
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
                <a href="{{route('admin.teacher.index')}}" class="block py-2 px-4 rounded hover:bg-blue-100 text-gray-700"><i class="fas fa-chalkboard-teacher mr-2"></i> {{__('messages.teachers')}}</a>
                <a href="{{route('admin.student.index')}}" class="block py-2 px-4 rounded hover:bg-green-100 text-gray-700"><i class="fas fa-tasks mr-2"></i> {{__('messages.students')}}</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6 ">
            <button class="md:hidden mb-4 text-blue-600" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i> {{__('messages.menu')}}
            </button>
            <div class="bg-white shadow-md rounded-2xl p-6 mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
                <!-- Left: Avatar + Name -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 text-xl font-bold shadow">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">{{__('messages.greeting')}} 👋</p>
                        <h2 class="text-xl font-semibold text-gray-800">
                            <span id="adminName">{{$dashboard->name}}</span>
                        </h2>
                    </div>
                </div>

                <!-- Right: Logout -->
                <form action="{{route("LogOut")}}" method="GET" class="w-full md:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full md:w-auto px-6 py-2 border border-red-600 text-red-600 rounded-xl font-medium hover:bg-red-600 hover:text-white transition-all duration-300">
                            {{__('messages.logout')}}
                    </button>
                </form>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-blue-600 mb-2">{{__('messages.num_students')}}</h3>
                    <p class="text-3xl font-semibold text-blue-800">{{$count_students}}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-green-600 mb-2">{{__('messages.num_teachers')}}</h3>
                    <p class="text-3xl font-semibold text-green-800">{{$count_teachers}}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('sidebar-hidden');
        }
        lucide.createIcons();
    </script>
</body>


</html>
