<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Car;
use App\Models\CarType;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::query()->with(['carType', 'branch']);

        // Apply filters
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }

        if ($request->filled('type')) {
            $query->where('car_type_id', $request->type);
        }

        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }

        $cars = $query->where('is_available', true)
            ->latest()
            ->paginate(9);

        $branches = Branch::all();
        $carTypes = CarType::all();

        return view('cars.index', compact('cars', 'branches', 'carTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $carTypes = CarType::all();
        return view('cars.create', compact('branches', 'carTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:cars',
            'transmission' => 'required|in:Auto,Manual',
            'car_type_id' => 'required|exists:car_types,id',
            'branch_id' => 'required|exists:branches,id',
            'daily_rate' => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        Car::create($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->load(['carType', 'branch']);
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $branches = Branch::all();
        $carTypes = CarType::all();
        return view('cars.edit', compact('car', 'branches', 'carTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:cars,plate_number,' . $car->id,
            'transmission' => 'required|in:Auto,Manual',
            'car_type_id' => 'required|exists:car_types,id',
            'branch_id' => 'required|exists:branches,id',
            'daily_rate' => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $car->update($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Car updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Car deleted successfully.');
    }
}
