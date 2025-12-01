<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{__('messages.page_direction')}}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.3.2/css/flag-icons.min.css" />
    <title>{{__('messages.login')}}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-50 to-blue-100 flex items-center justify-center min-h-screen font-sans">

    <div class="absolute top-5 right-5 flex gap-3">
        @foreach ( config('lang.supported') as $locale => $lang )
            <a href="{{route('SetLocale',$lang['locale'])}}" class="px-3 py-1 rounded-lg bg-gray-200 hover:bg-gray-300 text-sm flex items-center gap-2">
                <img src="{{asset('flags/'.$lang['flag'])}}" alt="{{$lang['name']}}" width="22" class="inline-block">
                {{$lang['name']}}
            </a>
        @endforeach
    </div>

    <div class="bg-white shadow-2xl rounded-2xl w-full max-w-md p-8 space-y-6 border border-gray-200">
        <h2 class="text-3xl font-extrabold text-center text-gray-800">{{__('messages.login')}}</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{route('login')}}" method="POST" class="space-y-5">
            @csrf

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{__('messages.email')}}</label>
                <input type="email" name="email" value="{{old('email')}}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                @error('email')
                    <span class="text-red-500 text-xs mt-1">* {{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{__('messages.password')}}</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
                @error('password')
                    <span class="text-red-500 text-xs mt-1">* {{ $message }}</span>
                @enderror
            </div>

            {{-- Remember Me + Forgot Password --}}
            <div class="flex items-center justify-between text-sm">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember_me" class="form-checkbox text-blue-600 rounded">
                    <span class="ml-2 text-gray-600">{{__('messages.remember_me')}} </span>
                </label>
                <a href="{{route('password.request')}}" class="text-blue-600 hover:underline">
                    {{__('messages.forget_password')}}
                </a>
            </div>

            {{-- Submit Button --}}
            <button type="submit" 
                class="w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md font-semibold">
                {{__('messages.login')}}
            </button>
        </form>
    </div>

</body>
</html>
