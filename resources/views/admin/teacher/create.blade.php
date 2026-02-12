@extends('layouts.admin')

@section('title', __('messages.add-teacher'))
@section('breadcrumb_current', __('messages.teachers'))
@section('page_title', __('messages.add-teacher'))

@section('content')
    <!-- Success Message -->
    @if (session('successCreateMsg'))
        <div class="mb-10 animate-in fade-in slide-in-from-top-4 duration-500">
            <div
                class="flex items-center gap-3 px-6 py-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <p class="text-sm font-bold">{{ session('successCreateMsg') }}</p>
            </div>
        </div>
    @endif

    <!-- Form Container -->
    <div class="max-w-4xl">
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <!-- Form Header -->
            <div class="px-10 py-8 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <div>
                    <h4 class="text-lg font-black text-gray-900 tracking-tighter">Registration Form</h4>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Enter teacher
                        credentials and information</p>
                </div>
                <a href="{{route('admin.teacher.index')}}"
                    class="flex items-center gap-2 px-4 py-2 text-gray-500 hover:text-blue-600 transition-colors">
                    <i data-lucide="arrow-{{ __('messages.page_direction') == 'rtl' ? 'right' : 'left' }}"
                        class="w-4 h-4"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">{{__('messages.previous-page')}}</span>
                </a>
            </div>

            <form class="p-10 md:p-12 space-y-8" method="POST" action="{{route('admin.teacher.store')}}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                            {{__('messages.name')}} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 {{ __('messages.page_direction') == 'rtl' ? 'right-4' : 'left-4' }} flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i data-lucide="user" class="w-4 h-4"></i>
                            </div>
                            <input type="text" name="name" id="name" required
                                class="w-full h-14 bg-gray-50/50 border border-gray-100 rounded-2xl {{ __('messages.page_direction') == 'rtl' ? 'pr-12' : 'pl-12' }} px-6 text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/5 transition-all outline-none">
                        </div>
                        @error('name')
                            <p class="text-[10px] text-red-500 font-bold px-1 uppercase tracking-tight">{{$message}}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                            {{__('messages.email')}} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 {{ __('messages.page_direction') == 'rtl' ? 'right-4' : 'left-4' }} flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i data-lucide="mail" class="w-4 h-4"></i>
                            </div>
                            <input type="email" name="email" id="email" required
                                class="w-full h-14 bg-gray-50/50 border border-gray-100 rounded-2xl {{ __('messages.page_direction') == 'rtl' ? 'pr-12' : 'pl-12' }} px-6 text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/5 transition-all outline-none">
                        </div>
                        @error('email')
                            <p class="text-[10px] text-red-500 font-bold px-1 uppercase tracking-tight">{{$message}}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                            {{__('messages.password')}} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 {{ __('messages.page_direction') == 'rtl' ? 'right-4' : 'left-4' }} flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                class="w-full h-14 bg-gray-50/50 border border-gray-100 rounded-2xl {{ __('messages.page_direction') == 'rtl' ? 'pr-12' : 'pl-12' }} px-6 text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/5 transition-all outline-none">
                        </div>
                        @error('password')
                            <p class="text-[10px] text-red-500 font-bold px-1 uppercase tracking-tight">{{$message}}</p>
                        @enderror
                    </div>

                    <!-- Class -->
                    <div class="space-y-2">
                        <label for="class" class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                            {{__('messages.class')}} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 {{ __('messages.page_direction') == 'rtl' ? 'right-4' : 'left-4' }} flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i data-lucide="book-open" class="w-4 h-4"></i>
                            </div>
                            <input type="text" id="class" name="class" required
                                class="w-full h-14 bg-gray-50/50 border border-gray-100 rounded-2xl {{ __('messages.page_direction') == 'rtl' ? 'pr-12' : 'pl-12' }} px-6 text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/5 transition-all outline-none">
                        </div>
                        @error('class')
                            <p class="text-[10px] text-red-500 font-bold px-1 uppercase tracking-tight">{{$message}}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div class="space-y-2 md:col-span-2">
                        <label for="subject" class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                            {{__('messages.subject')}} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative group">
                            <div
                                class="absolute inset-y-0 {{ __('messages.page_direction') == 'rtl' ? 'right-4' : 'left-4' }} flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                                <i data-lucide="award" class="w-4 h-4"></i>
                            </div>
                            <input type="text" id="subject" name="subject" required
                                class="w-full h-14 bg-gray-50/50 border border-gray-100 rounded-2xl {{ __('messages.page_direction') == 'rtl' ? 'pr-12' : 'pl-12' }} px-6 text-sm font-bold text-gray-900 focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-600/5 transition-all outline-none">
                        </div>
                        @error('subject')
                            <p class="text-[10px] text-red-500 font-bold px-1 uppercase tracking-tight">{{$message}}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit"
                        class="w-full h-16 bg-blue-600 text-white rounded-3xl shadow-xl shadow-blue-100 hover:bg-blue-700 hover:scale-[1.01] transition-all font-black uppercase tracking-widest text-xs flex items-center justify-center gap-3">
                        <i data-lucide="save" class="w-4 h-4 text-white"></i>
                        {{__('messages.add-teacher')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection