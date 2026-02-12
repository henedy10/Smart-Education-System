@extends('layouts.admin')

@section('title', __('messages.students_list'))
@section('breadcrumb_current', __('messages.students'))
@section('page_title', __('messages.students_list'))

@section('content')
    <!-- Alerts & Notices -->
    <div class="space-y-4 mb-10">
        <!-- Success Message -->
        @if (session('successDeleteMsg'))
            <div
                class="flex items-center gap-3 px-6 py-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <p class="text-sm font-bold">{{ session('successDeleteMsg') }}</p>
            </div>
        @endif

        <!-- Warning Message -->
        <div id="alert"
            class="hidden items-start gap-4 px-6 py-5 bg-amber-50 border border-amber-100 text-amber-800 rounded-2xl shadow-sm transition-all duration-300">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-600"></i>
            </div>
            <div class="pt-1">
                <h4 class="text-sm font-black uppercase tracking-widest mb-1">Retention Policy</h4>
                <p class="text-xs leading-relaxed opacity-80">
                    If you delete a student, their data can be retrieved again within <strong>30 days</strong>.
                    After that, it will be <strong>permanently removed</strong> from the system.
                </p>
            </div>
        </div>
    </div>

    <!-- Actions Header -->
    <div class="flex flex-col sm:flex-row justify-between items-end sm:items-center gap-6 mb-12">
        <div class="flex items-center gap-3">
            <button id="btn"
                class="group flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-100 text-gray-400 hover:text-amber-600 hover:bg-amber-50 hover:border-amber-100 rounded-xl transition-all shadow-sm">
                <i data-lucide="info" class="w-4 h-4"></i>
                <span class="text-[10px] font-black uppercase tracking-widest">Notice</span>
            </button>
            <a href="{{route('admin.student.index.trash')}}"
                class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-100 text-gray-400 hover:text-red-600 hover:bg-red-50 hover:border-red-100 rounded-xl transition-all shadow-sm">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                <span class="text-[10px] font-black uppercase tracking-widest">Trash</span>
            </a>
        </div>
        <div>
            <a href="{{route('admin.student.create')}}"
                class="flex items-center gap-3 px-6 py-3 bg-blue-600 text-white rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 hover:scale-[1.02] transition-all group">
                <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center">
                    <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                </div>
                <span class="text-xs font-black uppercase tracking-widest">{{__('messages.add-student')}}</span>
            </a>
            <a href="{{route('admin.index')}}"
                class="flex items-center gap-2 px-4 py-2 text-gray-500 hover:text-blue-600 transition-colors">
                <i data-lucide="arrow-{{ __('messages.page_direction') == 'rtl' ? 'right' : 'left' }}"
                    class="w-4 h-4"></i>
                <span class="text-[10px] font-black uppercase tracking-widest">{{__('messages.previous-page')}}</span>
            </a>
        </div>
    </div>

    <!-- Search & List -->
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden p-8 md:p-12">
        @livewire('search-student')
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let btn = document.getElementById('btn');
            let alert = document.getElementById('alert');

            if (btn && alert) {
                btn.addEventListener('click', function () {
                    alert.classList.toggle('hidden');
                    lucide.createIcons();
                });
            }
        });

        function confirmDelete() {
            return confirm('Are you sure you want to delete this student?');
        }
    </script>
@endpush
