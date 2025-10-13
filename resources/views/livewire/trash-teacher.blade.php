<div class="w-full max-w-6xl mx-auto bg-white rounded-2xl shadow-lg p-6">
    <!-- Search Input -->
    <div class="mb-6 flex items-center justify-between">
        <input
            type="text"
            wire:model.live="query"
            id="search"
            placeholder="{{__('messages.search_by_name')}}..."
            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
        >
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left">
            <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white">
                <tr>
                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wide">#</th>
                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wide">{{__('messages.name')}}</th>
                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wide">{{__('messages.email')}}</th>
                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wide">{{__('messages.class')}}</th>
                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wide">{{__('messages.subject')}}</th>
                    <th class="py-3 px-4 font-semibold text-sm uppercase tracking-wide text-center">{{__('messages.actions')}}</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($teachers as $teacher)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 px-4 text-gray-500">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 font-semibold text-gray-800">{{ $teacher->name }}</td>
                        <td class="py-3 px-4 text-blue-600 font-medium">{{ $teacher->email }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $teacher->teacher->class }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $teacher->teacher->subject }}</td>
                        <td class="py-3 px-4 text-center flex justify-center space-x-2">
                            <form action="{{route('admin.teacher.restore',$teacher->id)}}" method="POST">
                                @csrf
                                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                                    {{__('messages.restore')}}
                                </button>
                            </form>

                            <form action="{{route('admin.teacher.forceDelete',$teacher->id)}}" method="POST" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                                    {{__('messages.delete')}}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-red-500 font-medium text-sm">
                            * {{__('messages.no_teachers')}}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
