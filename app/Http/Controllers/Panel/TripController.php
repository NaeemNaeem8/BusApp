<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\LineParkingsRequest;
use App\Http\Requests\Panel\SerachTripRequest;
use App\Http\Requests\Panel\TripRequest;
use App\Http\Resources\Panel\TripResource;
use App\Models\LineTrip;
use App\Models\Trip;
use App\Services\GeneralServices;
use App\Services\Paginate;
use App\Services\TripServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{

    public function index()
    {
        $result = new Paginate(new Trip, 'trips', request('page'));
        $result = $result->with(['day:id,name,deleted_at','trips' =>  Trip::is_completed()])->get();
        $result['data'] = TripResource::collection($result['data']);
        return response()->success($result);
    }



    public function store(TripRequest $request, TripServices $services)
    {
        $services->store($request->except('lines_id'), $request->validated('lines_id'));
        return response()->success('', 'تم الانشاء بنجاح');
    }


    public function show($trip_id)
    {
        $line_trip = LineTrip::whereId('01gm34wwg64r0naddz0vgw3bjt')
            ->lineTrip()
            ->firstOrFail();
        return response()->success($line_trip);
    }


    public function update(TripRequest $request, $trip_id)
    {
        $trip = Trip::findOrFail($trip_id);
        $trip->update($request->validated());
        return response()->success('', 'تم التعديل بنجاح');
    }


    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();
        return response()->success('', 'تم التعطيل بنجاح');
    }

    /*
        - search by
            start time
            day
            type
    */
    public function search(SerachTripRequest $request, TripServices $service)
    {
        $result = $service->search($request->validated());
        return response()->success(TripResource::collection($result));
    }

    public function line_parkings(LineParkingsRequest $request)
    {
        DB::table('line_parkings')->insert($request->get_date());
        return response()->success($request->get_date());
    }
}
