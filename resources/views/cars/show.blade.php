<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Car Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Car Image -->
                        <div>
                            <img src="{{ $car->image_url ?? 'https://via.placeholder.com/600x400' }}"
                                 alt="{{ $car->brand }} {{ $car->model }}"
                                 class="w-full h-64 object-cover rounded-lg">
                        </div>

                        <!-- Car Details -->
                        <div>
                            <h3 class="text-2xl font-bold mb-2">{{ $car->brand }} {{ $car->model }}</h3>
                            <div class="space-y-2">
                                <p><span class="font-medium">Type:</span> {{ $car->carType->name }}</p>
                                <p><span class="font-medium">Transmission:</span> {{ $car->transmission }}</p>
                                <p><span class="font-medium">Plate Number:</span> {{ $car->plate_number }}</p>
                                <p><span class="font-medium">Branch:</span> {{ $car->branch->name }}</p>
                                <p><span class="font-medium">Daily Rate:</span> RM{{ number_format($car->daily_rate, 2) }}</p>
                                <p><span class="font-medium">Availability:</span>
                                    <span class="{{ $car->is_available ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $car->is_available ? 'Available' : 'Not Available' }}
                                    </span>
                                </p>
                            </div>

                            <!-- Booking Form -->
                            @if($car->is_available)
                                <form action="{{ route('bookings.store') }}" method="POST" class="mt-6">
                                    @csrf
                                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                            <input type="date" name="start_date" id="start_date"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                   min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                                   required>
                                        </div>
                                        <div>
                                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                            <input type="date" name="end_date" id="end_date"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                   min="{{ date('Y-m-d', strtotime('+3 days')) }}"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            Book Now
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            startDateInput.addEventListener('change', function() {
                const startDate = new Date(this.value);
                const minEndDate = new Date(startDate);
                minEndDate.setDate(minEndDate.getDate() + 1);

                endDateInput.min = minEndDate.toISOString().split('T')[0];
                if (endDateInput.value && new Date(endDateInput.value) < minEndDate) {
                    endDateInput.value = minEndDate.toISOString().split('T')[0];
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
