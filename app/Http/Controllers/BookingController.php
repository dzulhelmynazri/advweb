<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['car', 'car.carType', 'car.branch'])
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after:tomorrow',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::findOrFail($validated['car_id']);

        // Check if car is available
        if (!$car->is_available) {
            return back()->with('error', 'This car is not available for booking.');
        }

        // Check for overlapping bookings
        $overlappingBooking = Booking::where('car_id', $car->id)
            ->where('status', 'approved')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->exists();

        if ($overlappingBooking) {
            return back()->with('error', 'This car is already booked for the selected dates.');
        }

        // Check if the customer has reached the booking limit
        $customerBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->count();

        if ($customerBookings >= 2) {
            session()->flash('booking_limit_exceeded', 'You have reached the maximum limit of two bookings for the same rental period.');
            return back()->with('error', 'You have reached the maximum limit of two bookings for the same rental period.');
        }

        // Calculate total price
        $days = (strtotime($validated['end_date']) - strtotime($validated['start_date'])) / (60 * 60 * 24);
        $totalPrice = $car->daily_rate * $days;

        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'car_id' => $validated['car_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking created successfully. Please wait for admin approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create booking. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        $booking->load(['car', 'car.carType', 'car.branch']);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'car', 'car.carType', 'car.branch'])
            ->latest()
            ->paginate(10);

        return view('bookings.admin-index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        try {
            DB::beginTransaction();

            $booking->update(['status' => $validated['status']]);

            if ($validated['status'] === 'approved') {
                // Check for overlapping bookings again
                $overlappingBooking = Booking::where('car_id', $booking->car_id)
                    ->where('id', '!=', $booking->id)
                    ->where('status', 'approved')
                    ->where(function ($query) use ($booking) {
                        $query->whereBetween('start_date', [$booking->start_date, $booking->end_date])
                            ->orWhereBetween('end_date', [$booking->start_date, $booking->end_date])
                            ->orWhere(function ($q) use ($booking) {
                                $q->where('start_date', '<=', $booking->start_date)
                                    ->where('end_date', '>=', $booking->end_date);
                            });
                    })
                    ->exists();

                if ($overlappingBooking) {
                    throw new \Exception('This car is already booked for the selected dates.');
                }
            }

            DB::commit();

            return back()->with('success', 'Booking status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
