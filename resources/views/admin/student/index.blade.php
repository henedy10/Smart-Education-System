<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ __('messages.page_direction') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <title>{{__('messages.students_list')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    <div class="mb-6 w-full max-w-3xl flex items-center gap-3">
        <!-- Search Input -->
        <input
            type="text"
            id="search"
            placeholder="{{__('messages.search_by_name')}} ...."
            class="flex-1 px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <!-- Add Student Button -->
        <a
            href="{{route('admin.student.create')}}"
            class="bg-green-600 text-white px-5 py-2 rounded-xl shadow hover:bg-green-700 transition font-medium cursor-pointer">
            + {{__('messages.add-student')}}
    </a>
        <a href="{{route('admin.student.index.trash')}}" class="text-lg"><i class="fa-solid fa-trash"></i></a><span>({{$count_students_trashed}})</span>
    </div>


    <!-- Table -->
    <div class="overflow-x-auto w-full max-w-6xl bg-white rounded-2xl shadow-md">
        <table class="w-full border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-4">#</th>
                    <th class="py-3 px-4">{{__('messages.name')}}</th>
                    <th class="py-3 px-4">{{__('messages.email')}}</th>
                    <th class="py-3 px-4">{{__('messages.class')}}</th>
                    <th class="py-3 px-4">{{__('messages.actions')}}</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-gray-700">
                @forelse ($students as $student)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 font-medium text-gray-600">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 font-semibold">{{ $student->user->name }}</td>
                        <td class="py-3 px-4 text-blue-600">{{ $student->user->email }}</td>
                        <td class="py-3 px-4">{{ $student->class }}</td>
                        <td class="py-3 px-4 text-center flex">
                            <form action="{{route('admin.student.trash',$student->user->id)}}" method="POST" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600 ml-2 transition">{{__('messages.delete')}}</button>
                            </form>

                                <a
                                href="{{route('admin.student.edit',$student->user->id)}}"
                                class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600 ml-2 transition">{{__('messages.edit')}}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-red-500 font-medium">
                            * {{__('messages.no_students')}}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete()
        {
            return confirm('Are you sure to delete it ?')
        }
    </script>

</body>
</html>
