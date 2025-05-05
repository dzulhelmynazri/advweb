<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Car Details -->
                        <div>
                            <h3 class="text-lg font-semibold">Car Information</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Brand & Model:</span> <span class="text-gray-500">{{ $booking->car->brand }} {{ $booking->car->model }}</span></p>
                                <p><span class="font-medium">Type:</span> <span class="text-gray-500">{{ $booking->car->carType->name }}</span></p>
                                <p><span class="font-medium">Transmission:</span> <span class="text-gray-500">{{ $booking->car->transmission }}</span></p>
                                <p><span class="font-medium">Branch:</span> <span class="text-gray-500">{{ $booking->car->branch->name }}</span></p>
                                <p><span class="font-medium">Daily Rate:</span> <span class="text-gray-500">RM{{ number_format($booking->car->daily_rate, 2) }}</span></p>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div>
                            <h3 class="text-lg font-semibold mt-4">Booking Information</h3>
                            <div class="space-y-4">

                                    <p class="font-medium">Status: <span class="text-gray-500"> {{ ucfirst($booking->status) }}</span> </p>

                                <div>
                                    <p class="font-medium">Rental Period: </p>
                                    <p class="text-gray-500">From: {{ $booking->start_date->format('M d, Y') }}</p>
                                    <p class="text-gray-500">To: {{ $booking->end_date->format('M d, Y') }}</p>
                                    <p class="text-gray-500">Duration: {{ $booking->start_date->diffInDays($booking->end_date) }} days</p>
                                </div>

                                <div>
                                    <p class="font-medium">Total Price</p>
                                    <p class="text-2xl font-bold text-indigo-600">RM{{ number_format($booking->total_price, 2) }}</p>
                                </div>

                                @if($booking->notes)
                                    <div>
                                        <p class="font-medium">Notes</p>
                                        <p class="text-gray-600">{{ $booking->notes }}</p>
                                    </div>
                                @endif

                                @if(auth()->user()->isAdmin() && $booking->status === 'pending')
                                    <div class="border-t pt-4 mt-4">
                                        <h4 class="font-medium mb-2">Update Status</h4>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.bookings.index') : route('bookings.index') }}"
                           class="text-indigo-600 hover:text-indigo-900">
                            &larr; Back to {{ auth()->user()->isAdmin() ? 'All Bookings' : 'My Bookings' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
