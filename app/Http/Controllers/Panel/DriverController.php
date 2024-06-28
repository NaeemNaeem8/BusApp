<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\DriverRequest;
use App\Models\Driver;
use App\Services\GeneralServices;
use App\Services\Paginate;
use Illuminate\Http\Request;

class DriverController extends Controller
{

    public function index()
    {
        $result = new Paginate(new Driver, 'drivers', request('page'));
        return response()->success($result->get());
    }


    public function store(DriverRequest $request)
    {
        $inputs = $request->validated();
        if ($request->hasFile('image'))
            $inputs['image'] = $request->image->store('DriversImage', 'public');

        Driver::create($inputs);
        return response()->success('', 'تم الانشاء بنجاح');
    }


    public function show($id)
    {
        //
    }


    public function update(DriverRequest $request, $driver_id)
    {
        $driver = Driver::findOrFail($driver_id);
        $inputs = $request->validated();
        if ($request->hasFile('image'))
            $inputs['image'] = GeneralServices::change_file($driver->image, 'DriversImage', $inputs['image']);

        $driver->update($inputs);
        return response()->success('', 'تم التعديل بنجاح');
    }


    public function destroy($id)
    {
        //
    }

    public function select_drivers()
    {
        $drivers = Driver::all(['id','name']);
        return response()->success($drivers);
    }
}
