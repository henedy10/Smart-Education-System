<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ __('messages.page_direction') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers Table</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center p-10">
    <!-- زر الرجوع -->
    <div class="w-full max-w-6xl flex justify-start mb-6">
        <a href="{{route('admin.index')}}"
           class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            <!-- أيقونة سهم -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Home
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Teachers List</h1>

    <div class="mb-6 w-full max-w-3xl flex items-center gap-3">
        <!-- Search Input -->
        <input
            type="text"
            id="search"
            placeholder="Search by name..."
            class="flex-1 px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <!-- Add Teacher Button -->
        <a
            href="{{route('admin.teacher.create')}}"
            class="bg-green-600 text-white px-5 py-2 rounded-xl shadow hover:bg-green-700 transition font-medium">
            + Add Teacher
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto w-full max-w-6xl bg-white rounded-2xl shadow-md">
        <table class="w-full border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Name</th>
                    <th class="py-3 px-4 text-left">class</th>
                    <th class="py-3 px-4 text-left">Subject</th>
                    <th class="py-3 px-4 text-left">Email</th>
                    <th class="py-3 px-4 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-gray-700">
                @forelse ($teachers as $teacher)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 font-medium text-gray-600">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 font-semibold">{{ $teacher->user->name }}</td>
                        <td class="py-3 px-4 font-semibold">{{ $teacher->class }}</td>
                        <td class="py-3 px-4">{{ $teacher->subject }}</td>
                        <td class="py-3 px-4 text-blue-600">{{ $teacher->user->email }}</td>
                        <td class="py-3 px-4 text-center">
                            <button class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600 ml-2 transition">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-red-500 font-medium">
                            * There are no teachers
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
