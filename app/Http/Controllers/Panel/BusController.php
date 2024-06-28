<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\BusRequest;
use App\Models\Bus;
use App\Services\Paginate;
use Illuminate\Http\Request;

class BusController extends Controller
{

    public function index()
    {
        $result  = new Paginate(new Bus, 'buses', request('page'));
        return response()->success($result->get());
    }


    public function store(BusRequest $request)
    {
        Bus::create($request->validated());
        return response()->success('', 'تم الانشاء بنجاح');
    }


    public function show($id)
    {
        //
    }


    public function update(BusRequest $request, $bus_id)
    {
        $bus = Bus::findOrFail($bus_id);
        $bus->update($request->validated());
        return response()->success('', 'تم التعديل بنجاح');
    }


    public function destroy($id)
    {
        //
    }

    public function select_buses()
    {
        $buses = Bus::all();
        return response()->success($buses);
    }
}
