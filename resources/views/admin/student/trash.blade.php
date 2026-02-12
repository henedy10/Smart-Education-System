@extends('layouts.admin')

@section('title', __('messages.students_list') . ' (Trash)')
@section('breadcrumb_current', __('messages.students'))
@section('page_title', 'Archive & Cleanup')

@section('content')
    <!-- Alerts & Notices -->
    <div class="space-y-4 mb-10">
        <!-- Success Messages -->
        @if (session('successDeleteMsg'))
            <div
                class="flex items-center gap-3 px-6 py-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <p class="text-sm font-bold">{{ session('successDeleteMsg') }}</p>
            </div>
        @elseif (session('successRestoreMsg'))
            <div
                class="flex items-center gap-3 px-6 py-4 bg-blue-50 border border-blue-100 text-blue-700 rounded-2xl shadow-sm animate-in fade-in slide-in-from-top-4 duration-500">
                <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                <p class="text-sm font-bold">{{ session('successRestoreMsg') }}</p>
            </div>
        @endif
    </div>

    <!-- Actions Header -->
    <div class="flex flex-col sm:flex-row justify-between items-end sm:items-center gap-6 mb-12">
        <div>
            <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Student Archive</h4>
            <p class="text-[10px] text-amber-500 font-bold uppercase tracking-widest">Items here will be permanently deleted
                after 30 days</p>
        </div>

        <a href="{{route('admin.student.index')}}"
            class="flex items-center gap-3 px-6 py-3 bg-white border border-gray-100 text-gray-500 rounded-2xl shadow-sm hover:bg-gray-50 hover:text-blue-600 transition-all group">
            <i data-lucide="arrow-{{ __('messages.page_direction') == 'rtl' ? 'right' : 'left' }}"
                class="w-4 h-4 group-hover:{{ __('messages.page_direction') == 'rtl' ? 'translate-x-1' : '-translate-x-1' }} transition-transform"></i>
            <span class="text-xs font-black uppercase tracking-widest">{{__('messages.previous-page')}}</span>
        </a>
    </div>

    <!-- Trash List -->
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden p-8 md:p-12">
        @livewire('trash-student')
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this permanently? This action cannot be undone.');
        }
    </script>
@endpush