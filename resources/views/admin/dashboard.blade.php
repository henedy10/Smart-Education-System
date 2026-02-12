@extends('layouts.admin')

@section('title', __('messages.dashboard'))
@section('page_title', __('messages.dashboard'))

@section('content')
    <!-- Welcome Section -->
    <div class="mb-14">
        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-blue-50 rounded-full text-blue-600 text-[10px] font-black uppercase tracking-[0.2em] mb-5">
            <div class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
            </div>
            {{__('messages.greeting')}}
        </div>
        <h3 class="text-5xl font-black text-gray-900 tracking-tighter leading-tight sm:max-w-xl">
            {{$info['user']->name}}
        </h3>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        <!-- Students Analytics -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-10">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                    <i data-lucide="graduation-cap" class="w-7 h-7"></i>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black text-blue-500 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-tighter">Active Learners</span>
                </div>
            </div>
            <h4 class="text-xs font-black text-gray-300 mb-2 uppercase tracking-[0.2em]">{{__('messages.num_students')}}</h4>
            <div class="flex items-end gap-3">
                <span class="text-6xl font-black text-gray-900 leading-none tracking-tighter">{{$info['count_students']}}</span>
                <div class="flex flex-col mb-1">
                    <span class="text-xs font-bold text-gray-400 mb-1 tracking-widest">TOTAL</span>
                </div>
            </div>
            <div class="mt-10 pt-8 border-t border-gray-50">
                <a href="{{route('admin.student.index')}}" class="text-sm font-black text-blue-600 hover:text-blue-700 flex items-center gap-2 group/link transition-all">
                    <span>{{ __('messages.show') ?? 'Explore Students' }}</span>
                    <i data-lucide="arrow-{{ __('messages.page_direction') == 'rtl' ? 'left' : 'right' }}" class="w-4 h-4 group-hover/link:translate-{{ __('messages.page_direction') == 'rtl' ? 'x-[-4px]' : 'x-[4px]' }} transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Teachers Analytics -->
        <div class="bg-white p-10 rounded-[2.5rem] border border-gray-100 shadow-sm hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-500 group">
            <div class="flex items-center justify-between mb-10">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500">
                    <i data-lucide="users-2" class="w-7 h-7"></i>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-tighter">Verified Staff</span>
                </div>
            </div>
            <h4 class="text-xs font-black text-gray-300 mb-2 uppercase tracking-[0.2em]">{{__('messages.num_teachers')}}</h4>
            <div class="flex items-end gap-3">
                <span class="text-6xl font-black text-gray-900 leading-none tracking-tighter">{{$info['count_teachers']}}</span>
                <span class="text-xs font-bold text-gray-400 mb-1 tracking-widest">TOTAL</span>
            </div>
            <div class="mt-10 pt-8 border-t border-gray-50">
                <a href="{{route('admin.teacher.index')}}" class="text-sm font-black text-emerald-600 hover:text-emerald-700 flex items-center gap-2 group/link transition-all">
                    <span>{{ __('messages.show') ?? 'Explore Teachers' }}</span>
                    <i data-lucide="arrow-{{ __('messages.page_direction') == 'rtl' ? 'left' : 'right' }}" class="w-4 h-4 group-hover/link:translate-{{ __('messages.page_direction') == 'rtl' ? 'x-[-4px]' : 'x-[4px]' }} transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Quick Tools Dark -->
        <div class="bg-gray-900 p-10 rounded-[2.5rem] shadow-2xl shadow-gray-900/20 text-white relative overflow-hidden group">
            <div class="relative z-10 h-full flex flex-col">
                <div class="mb-10">
                    <div class="w-12 h-1.5 bg-blue-600 rounded-full mb-4"></div>
                    <h4 class="font-black text-2xl tracking-tighter mb-2">Platform Tools</h4>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Action Center</p>
                </div>
                <div class="space-y-4 flex-1">
                    <a href="{{route('admin.student.create')}}" class="flex items-center justify-between p-5 bg-white/5 hover:bg-white/10 rounded-[1.5rem] transition-all border border-white/5 hover:border-white/10 group/btn">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center group-hover/btn:bg-blue-600 group-hover/btn:text-white transition-all">
                                <i data-lucide="user-plus" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest">{{__('messages.add-student')}}</span>
                        </div>
                        <i data-lucide="plus" class="w-4 h-4 text-gray-600 group-hover/btn:text-white transition-colors"></i>
                    </a>
                    <a href="{{route('admin.teacher.create')}}" class="flex items-center justify-between p-5 bg-white/5 hover:bg-white/10 rounded-[1.5rem] transition-all border border-white/5 hover:border-white/10 group/btn">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-600/20 text-emerald-400 flex items-center justify-center group-hover/btn:bg-emerald-600 group-hover/btn:text-white transition-all">
                                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                            </div>
                            <span class="text-xs font-black uppercase tracking-widest">{{__('messages.add-teacher')}}</span>
                        </div>
                        <i data-lucide="plus" class="w-4 h-4 text-gray-600 group-hover/btn:text-white transition-colors"></i>
                    </a>
                </div>
            </div>
            <!-- Abstract Decoration -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-600/10 rounded-full blur-[80px]"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-emerald-600/5 rounded-full blur-[80px]"></div>
        </div>
    </div>
@endsection
