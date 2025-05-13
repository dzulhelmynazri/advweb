<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Cars') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form action="{{ route('cars.index') }}" method="GET" class="flex gap-4">
                    <div class="w-full">
                        <label for="branch" class="block text-sm font-medium text-gray-700">Branch</label>
                        <select name="branch" id="branch" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All Branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full">
                        <label for="type" class="block text-sm font-medium text-gray-700">Car Type</label>
                        <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All Types</option>
                            @foreach($carTypes as $type)
                                <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full">
                        <label for="transmission" class="block text-sm font-medium text-gray-700">Transmission</label>
                        <select name="transmission" id="transmission" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All</option>
                            <option value="Auto" {{ request('transmission') == 'Auto' ? 'selected' : '' }}>Automatic</option>
                            <option value="Manual" {{ request('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                        <button type="submit">
                        <x-bi-filter class="w-6 h-6"/>
                        </button>
                </form>
            </div>

            <!-- Car Grid -->
            @if($cars->isEmpty())
                <div class="w-full text-center text-gray-500">
                    no data available
                </div>
            @else
            <div class="flex flex-wrap gap-4">
                @foreach($cars as $car)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                        <div class="p-6">
                            <!-- <div class="aspect-w-16 aspect-h-9 mb-4">
                                <img src="{{ $car->image_url ?? 'https://via.placeholder.com/300x200' }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-48 object-cover rounded-lg">
                            </div> -->
                            <h3 class="text-lg font-semibold">{{ $car->brand }} {{ $car->model }}</h3>
                            <p class="text-gray-600">{{ $car->carType->name }}</p>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm"><span class="font-medium">Transmission:</span> {{ $car->transmission }}</p>
                                <p class="text-sm"><span class="font-medium">Branch:</span> {{ $car->branch->name }}</p>
                                <p class="text-sm"><span class="font-medium">Daily Rate:</span> RM{{ number_format($car->daily_rate, 2) }}</p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('cars.show', $car) }}" class="block w-full text-center  text-black   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Pagination -->
            <div class="mt-6">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
