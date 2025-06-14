@php
    $navigationLayout = auth()->user()->hasRole('supervisor') ? 'layouts.navigation-spv' : null;
@endphp

<x-app-layout navigation="{{ $navigationLayout }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notifications
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-4 md:px-4 lg:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @forelse ($notifications as $notification)
                    <div class="p-6 border-b border-gray-200 hover:bg-gray-50 transition">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">
                            {{ $notification->data['title'] }}
                        </h3>
                        <p class="text-gray-700 mb-2">
                            {{ $notification->data['message'] }}
                        </p>
                        <span class="text-xs text-gray-500">
                            {{ $notification->created_at->diffForHumans() }} -
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $notification->created_at->format('Y-m-d H:i:s') }}
                        </span>

                        @if (is_null($notification->read_at))
                            <div class="mt-2">
                                <form
                                    action="{{ route('dashboard.notifications.markAsRead', ['id' => $notification->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-blue-500 hover:underline">Mark as Read</button>
                                </form>
                            </div>
                        @endif
                    </div>

                @empty
                    <div class="p-6 text-gray-900 text-xl">
                        No notifications available.
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
