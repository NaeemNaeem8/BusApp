<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\LineTripRequest;
use App\Models\LineTrip;
use App\Models\Trip;
use Illuminate\Http\Request;

class LineTripController extends Controller
{

    public function index()
    {
        $line_trips = Trip::whereId(request('id'))->with('lines')->firstOrFail();
        return response()->success($line_trips);
    }


    public function store(Request $request)
    {
    }


    public function show($id)
    {

    }


    public function update(LineTripRequest $request, $line_trip_id)
    {
        $lineTrip = LineTrip::findOrFail($line_trip_id);
        $lineTrip->update(['line_id' => $request->line_id]);
        return response()->success('', 'تم التعديل بنجاح');
    }


    public function destroy($line_trip_id)
    {
        $lineTrip = LineTrip::findOrFail($line_trip_id);
        $lineTrip->delete();
        return  response()->success('', 'تم العطيل بنجاح');
    }
}
