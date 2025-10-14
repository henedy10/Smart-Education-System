<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ __('messages.page_direction') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <title>{{__('messages.students_list')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center p-10">

    <!-- Success Message -->
    @if (session('successDeleteMsg'))
        <div class="mb-6 w-full max-w-2xl px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl shadow text-center">
                {{ session('successDeleteMsg') }}
            </div>
        </div>
    @endif

    <div class="w-full">
        <div class="p-3 rounded-xl flex flex-row-reverse gap-1">
            <!-- الزرار في اليمين -->
            <button id="btn"
            class="bg-red-500 text-white rounded-full w-6 h-6 text-sm font-semibold  hover:bg-red-600 transition">
            !
            </button>

        <!-- الرسالة -->
        <p id="alert"
            class="hidden text-sm text-red-800 bg-red-100 px-4 py-2 rounded-lg leading-relaxed transition-all duration-300">
            ⚠️ <strong>Warning:</strong> If you delete a student, their data can be retrieved again within
            <strong>30 days</strong>. After that, it will be permanently deleted automatically.
        </p>

        </div>
    </div>

    <!-- زر الرجوع -->
    <div class="w-full max-w-6xl flex justify-start mb-6">
        <a href="{{route('admin.index')}}"
            class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            <!-- أيقونة سهم -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            {{__('messages.previous-page')}}
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-8">{{__('messages.students_list')}}</h1>
    @livewire('search-student')


    <script>

        let btn   = document.getElementById('btn')
        let alert = document.getElementById('alert')

        function confirmDelete()
        {
            return confirm('Are you sure to delete it ?')
        }

        btn.addEventListener('click',function(){
            alert.classList.toggle('hidden')
        })

    </script>
    @livewireScripts
</body>
</html>
