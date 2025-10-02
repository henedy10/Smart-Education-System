<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{__('messages.page_direction')}}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{__('messages.change_password')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-50 to-blue-100 flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-md p-8 space-y-6 border border-gray-200">
        <h2 class="text-3xl font-extrabold text-center text-gray-800">{{__('messages.change_password')}}</h2>

        {{-- Flash Message --}}
        @if(session('message'))
            <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded-lg text-sm">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{route('Password.Update')}}" method="POST" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{__('messages.email')}}</label>
                <input type="email" name="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" />
                @error('email')
                    <span class="text-red-500 text-xs mt-1">* {{ $message }}</span>
                @enderror
            </div>

            {{-- New Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{__('messages.new_password')}}</label>
                <input type="password" name="NewPassword"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" />
                @error('NewPassword')
                    <span class="text-red-500 text-xs mt-1">* {{ $message }}</span>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{__('messages.confirm_password')}}</label>
                <input type="password" name="ConfirmPassword"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 transition" />
                @error('ConfirmPassword')
                    <span class="text-red-500 text-xs mt-1">* {{ $message }}</span>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2.5 rounded-lg hover:bg-indigo-700 transition duration-200 shadow-md font-semibold">
                {{__('messages.save')}}
            </button>
        </form>
    </div>

</body>
</html>
