<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Car') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.cars.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('Brand')" />
                                <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full" :value="old('brand')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('brand')" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" :value="__('Model')" />
                                <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('model')" />
                            </div>

                            <!-- Plate Number -->
                            <div>
                                <x-input-label for="plate_number" :value="__('Plate Number')" />
                                <x-text-input id="plate_number" name="plate_number" type="text" class="mt-1 block w-full" :value="old('plate_number')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('plate_number')" />
                            </div>

                            <!-- Transmission -->
                            <div>
                                <x-input-label for="transmission" :value="__('Transmission')" />
                                <select id="transmission" name="transmission" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Transmission</option>
                                    <option value="Auto" {{ old('transmission') == 'Auto' ? 'selected' : '' }}>Automatic</option>
                                    <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('transmission')" />
                            </div>

                            <!-- Car Type -->
                            <div>
                                <x-input-label for="car_type_id" :value="__('Car Type')" />
                                <select id="car_type_id" name="car_type_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Car Type</option>
                                    @foreach($carTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('car_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('car_type_id')" />
                            </div>

                            <!-- Branch -->
                            <div>
                                <x-input-label for="branch_id" :value="__('Branch')" />
                                <select id="branch_id" name="branch_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('branch_id')" />
                            </div>

                            <!-- Daily Rate -->
                            <div>
                                <x-input-label for="daily_rate" :value="__('Daily Rate (RM)')" />
                                <x-text-input id="daily_rate" name="daily_rate" type="number" step="0.01" class="mt-1 block w-full" :value="old('daily_rate')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('daily_rate')" />
                            </div>

                            <!-- Availability -->
                            <div>
                                <x-input-label for="is_available" :value="__('Availability')" />
                                <select id="is_available" name="is_available" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="1" {{ old('is_available', true) ? 'selected' : '' }}>Available</option>
                                    <option value="0" {{ !old('is_available', true) ? 'selected' : '' }}>Not Available</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('is_available')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Add Car') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
