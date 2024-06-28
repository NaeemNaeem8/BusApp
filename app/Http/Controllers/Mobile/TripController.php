<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Supervisor;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{

    public function index()
    {
        $supervisor = Supervisor::whereId(auth()->id())->first();

        abort_if(!$supervisor, 404, 'Invalid permission you must be supervisor');

        $ids = DB::table('trip_supervisors as ts')
            ->where('ts.supervisor_id', $supervisor->id)
            ->join('line_parkings as lp', 'lp.id', '=', 'ts.line_parking_id')
            ->join('line_trips as lt', 'lt.id', '=', 'lp.line_trip_id')
            ->get(['lt.line_id as line_id']);

        $line_id = [];

        foreach ($ids as $key => $value) {
            $line_id[]  = $value->line_id;
        }

        $line_id = array_unique($line_id);
        $line_id = array_map(fn ($val) => $val, $line_id);

        $pluck = DB::table('line_trips as lt')
            ->whereIn('lt.line_id', $line_id)
            ->join('line_parkings as lp', 'lp.line_trip_id', '=', 'lt.id')
            ->join('bookings as b', 'b.line_parking_id', '=', 'lp.id')
            ->where('b.created_at', date('Y-m-d'))
            ->select([DB::raw('count(b.id) as user_count', 'lp.id'), 'lp.id'])
            ->groupBy('lp.id')
            ->pluck('user_count', 'lp.id')->toArray();


        $trips = Trip::with([
            'trips' => fn ($q) => $q->whereIn('line_id', $line_id)->with([
                'parkings' => [
                    'parking'
                ]
            ])
        ])->get();

        $data = [];
        foreach ($trips as $trip_key => $trip) {
            $data[$trip_key] = [
                'type'              => $trip->type,
                'trip_start'        => $trip->trip_start->format('H:i A'),
                'parkings'          => []
            ];
            if (count($trip->trips) == 0) {
                unset($data[$trip_key]);
                continue;
            }
            foreach ($trip->trips as $key => $line_parking) {
                if (count($line_parking->parkings) == 0) {
                    unset($data[$trip_key]);
                    continue;
                }
                foreach ($line_parking->parkings as $key_parking => $parking) {
                    if (array_key_exists($parking->id, $pluck)) {
                        $data[$trip_key]['parkings'][$key_parking] = [
                            'parking_name'  => $parking->parking->name,
                            'count'         => $pluck[$parking->id]
                        ];
                    } else {
                        $data[$trip_key]['parkings'][$key_parking] = [
                            'parking_name'  => $parking->parking->name,
                            'count'         => 0
                        ];
                    }
                }
            }
        }
        $tt = array_values($data);
        return response()->success($tt);
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
