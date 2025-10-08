<!DOCTYPE html>
<html lang="{{App()->getLocale()}}" dir="{{__('messages.page_direction')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center py-10">

    <!-- Success Message -->
    @if (session('successCreateMsg'))
        <div class="mb-6 w-full max-w-2xl px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl shadow text-center">
                {{ session('successCreateMsg') }}
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="w-full max-w-2xl flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Add New Student</h1>
        <a href="{{ route('admin.student.index') }}"
        class="bg-gray-700 text-white px-4 py-2 rounded-xl shadow hover:bg-gray-800 transition">
            ← Back
        </a>
    </div>

    <!-- Form Card -->
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
        <form class="space-y-6" method="POST" action="{{ route('admin.student.store') }}">
            @csrf
            <input type="hidden" name="user_as" value="student">

            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name"
                    placeholder="Enter student's full name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email"
                    placeholder="Enter student's email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" id="password"
                    placeholder="Enter student's password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Class -->
            <div>
                <label for="class" class="block text-gray-700 font-semibold mb-2">Class <span class="text-red-500">*</span></label>
                <select id="class" name="class"
                        class="w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select class</option>
                <option value="Class 1">Class 1</option>
                <option value="Class 2">Class 2</option>
                <option value="Class 3">Class 3</option>
                </select>
                @error('class')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl shadow transition">
                + Add Student
                </button>
            </div>
        </form>
    </div>

</body>
</html>
