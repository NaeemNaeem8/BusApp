<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ParkingRequest;
use App\Models\Parking;
use App\Services\GeneralServices;
use App\Services\Paginate;
use Illuminate\Http\Request;

class ParkingController extends Controller
{

    public function index(GeneralServices $services)
    {
        $result = new Paginate(new Parking, 'parkings', request('page'));
        return response()->success($result->get());
    }


    public function store(ParkingRequest $request)
    {
        Parking::create($request->validated());
        return response()->success('', 'تم الانشاء بنجاح');
    }


    public function show($id)
    {
        //
    }


    public function update(ParkingRequest $request, $parking_id)
    {
        $parking = Parking::findOrFail($parking_id);
        $parking->update($request->validated());
        return response()->success('', 'تم التعديل بنجاح');
    }


    public function destroy($id)
    {
        //
    }

    public function select_parkings()
    {
        $parkings = Parking::all(['id','name']);
        return response()->success($parkings);
    }
}
