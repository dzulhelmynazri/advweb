<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Statistics Cards -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-lg font-semibold mb-2">Total Cars</div>
                    <div class="text-3xl font-bold">{{ $totalCars }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-lg font-semibold mb-2">Active Bookings</div>
                    <div class="text-3xl font-bold">{{ $activeBookings }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-lg font-semibold mb-2">Total Branches</div>
                    <div class="text-3xl font-bold">{{ $totalBranches }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-lg font-semibold mb-2">Total Users</div>
                    <div class="text-3xl font-bold">{{ $totalUsers }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.cars.create') }}" class="block w-full text-left px-4 py-2 bg-black text-white hover:bg-gray-800 rounded-md">Add New Car</a>
                        <a href="{{ route('admin.branches.create') }}" class="block w-full text-left px-4 py-2 bg-black text-white hover:bg-gray-800 rounded-md">Add New Branch</a>
                        <a href="{{ route('admin.bookings.index') }}" class="block w-full text-left px-4 py-2 bg-black text-white hover:bg-gray-800 rounded-md">View All Bookings</a>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Bookings</h3>
                    @if($recentBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentBookings as $booking)
                                <div class="border-b pb-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium">{{ $booking->user->name }}</p>
                                            <p class="text-sm text-gray-600">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                                            <p class="text-sm text-gray-500">{{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status === 'approved') bg-green-100 text-green-800
                                            @elseif($booking->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No recent bookings</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Car Management</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.cars.create') }}" class="block w-full text-left px-4 py-2 bg-black text-white hover:bg-gray-800 rounded-md">Add New Car</a>
                            <a href="{{ route('admin.cars.index') }}" class="block w-full text-left px-4 py-2 bg-black text-white hover:bg-gray-800 rounded-md">View All Cars</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
