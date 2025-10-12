<div class="flex flex-col items-center w-full p-4">
    <!-- Top Bar -->
    <div class="mb-6 w-full max-w-6xl flex flex-wrap items-center justify-between gap-3">
        <!-- Search Input -->
        <input
            type="text"
            id="search"
            wire:model.live="query"
            placeholder="{{__('messages.search_by_name')}} ...."
            class="flex-1 min-w-[220px] px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
        >

        <!-- Buttons -->
        <div class="flex items-center gap-3">
            <a
                href="{{route('admin.student.create')}}"
                class="bg-green-600 text-white px-5 py-2 rounded-xl shadow hover:bg-green-700 transition font-medium cursor-pointer"
            >
                + {{__('messages.add-student')}}
            </a>

            <a
                href="{{route('admin.student.index.trash')}}"
                class="text-lg text-red-600 hover:text-red-700 flex items-center gap-1"
            >
                <i class="fa-solid fa-trash"></i>
                <span>({{$count_students_trashed}})</span>
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto w-full max-w-6xl bg-white rounded-2xl shadow-md border border-gray-200">
        <table class="min-w-full border-collapse text-sm md:text-base">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">{{__('messages.name')}}</th>
                    <th class="py-3 px-4 text-left">{{__('messages.email')}}</th>
                    <th class="py-3 px-4 text-left">{{__('messages.class')}}</th>
                    <th class="py-3 px-4 text-center">{{__('messages.actions')}}</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-gray-700">
                @forelse ($students as $student)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 font-medium text-gray-600 text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 font-semibold">{{ $student->user->name }}</td>
                        <td class="py-3 px-4 text-blue-600">{{ $student->user->email }}</td>
                        <td class="py-3 px-4">{{ $student->class }}</td>
                        <td class="py-3 px-4">
                            <div class="flex justify-center gap-2">
                                <a
                                    href="{{route('admin.student.edit',$student->user->id)}}"
                                    class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600 transition"
                                >
                                    {{__('messages.edit')}}
                                </a>

                                <form
                                    action="{{route('admin.student.trash',$student->user->id)}}"
                                    method="POST"
                                    onsubmit="return confirmDelete()"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600 transition"
                                    >
                                        {{__('messages.delete')}}
                                    </button>
                                </form>
                            </div>
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
</div>
