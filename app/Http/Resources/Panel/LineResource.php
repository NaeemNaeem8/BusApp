<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class LineResource extends JsonResource
{

    public function toArray($request)
    {
        $buses = DB::table('line_trips')
            ->where('line_trips.id', $this->id)
            ->distinct()
            ->join('line_parkings as lp', 'lp.line_trip_id', '=', 'line_trips.id')
            ->join('trip_buses as tb', 'tb.line_parking_id', '=', 'lp.id')
            ->join('buses as b', 'tb.bus_id', '=', 'b.id')
            ->get(['b.*']);

        $drivers = DB::table('line_trips')
            ->where('line_trips.id', $this->id)
            ->distinct()
            ->join('line_parkings as lp', 'lp.line_trip_id', '=', 'line_trips.id')
            ->join('trip_buses as tb', 'tb.line_parking_id', '=', 'lp.id')
            ->join('drivers as d', 'tb.driver_id', '=', 'd.id')
            ->get(['d.*']);

        $supervisors = DB::table('line_trips')
            ->where('line_trips.id', $this->id)
            ->distinct()
            ->join('line_parkings as lp', 'lp.line_trip_id', '=', 'line_trips.id')
            ->join('trip_supervisors as ts', 'ts.line_parking_id', '=', 'lp.id')
            ->join('supervisors as s', 'ts.supervisor_id', '=', 's.id')
            ->get(['s.*']);


        return [
            'name'              => $this->line->name,
            'line_trip_id'      => $this->id,
            'buses'             => $buses,
            'drivers'           => $drivers,
            'supervisors'       => $supervisors,
            'parkings'          => ParkingResource::collection($this->parkings),
        ];
    }
}
