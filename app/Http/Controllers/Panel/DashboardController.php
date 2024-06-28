<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\University;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $day = request('day') == null ? date('Y-m-d') : request('day');
        $day = Carbon::parse($day)->format('Y-m-d');
        $universities = University::withCount([
            'bookings' => fn ($q) =>
            $q->where('bookings.created_at', $day)
        ])->get();
        return response()->success($universities);
    }

    public function line_count()
    {
        $day = request('day') == null ? date('Y-m-d') : request('day');
        $day = Carbon::parse($day)->format('Y-m-d');
        $trip = Trip::whereHas('trips.parkings')
            ->whereHas('trips.parkings.trip_buses')
            ->whereHas('trips.parkings.trip_supervisors')
            ->with([
                'lines' => fn ($q) => $q->with([
                    'line_parkings' => fn ($q)
                    => $q->with('parking')->withCount([
                        'bookings' => fn ($q) =>
                        $q->where('bookings.created_at', $day)
                    ])
                ]),
                'day' => fn ($q) => $q->withTrashed()
            ])
            ->get();
        return response()->success($trip);
    }
}
