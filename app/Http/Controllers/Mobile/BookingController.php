<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\BookingRequest;
use App\Models\Booking;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = DB::table('trips as t')
            ->join('line_trips as lt', function ($q) {
                $q->on('lt.trip_id', '=', 't.id')
                    ->join('lines', 'lines.id', '=', 'lt.line_id');
            })
            ->join('line_parkings as lp', function ($q) {
                $q->on('lp.line_trip_id', '=', 'lt.id')
                    ->join('parkings as p', 'p.id', '=', 'lp.parking_id');
            })
            ->join('bookings as b', 'b.line_parking_id', '=', 'lp.id')
            ->where('b.user_id', auth()->id())
            ->orderByDesc('b.created_at')
            ->get([
                'lines.name as line_name', 'p.name as parking_name',
                't.*','b.id as booking_id', 'b.created_at as book_created'
            ]);

        return response()->success($bookings);
    }

    public function store(BookingRequest $request)
    {
        $message = 'تم الحجز بنجاح';

        Booking::create([
            'line_parking_id' => $request->line_parking_id,
            'user_id'         => auth()->id()
        ]);

        if ($request->warnings)
            $message = $message . ' مع العلم ان جميع المقاعد محجوزة';

        return response()->success('', $message);
    }

    public function update(Request $request, $book_id)
    {
        $validator = Validator::make(['book_id' => $book_id], [
            'book_id' => 'required|exists:bookings,id'
        ]);
        if ($validator->fails()) {
            return response()->error($validator->errors()->first());
        }
        $book = Booking::findOrFail($book_id);
        if (Carbon::parse($book->created_at)->format('Y-m-d') != date('Y-m-d')) {
            return response()->error('هذه الرحلة ليست اليوم لايمكنك تاكيدها');
        }
        $book->update(['status' => true]);
        return response()->success('', 'تم التاكيد بنجاح');

    }
}
