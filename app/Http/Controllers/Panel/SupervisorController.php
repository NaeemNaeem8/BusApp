<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\SupervisorRequest;
use App\Models\Supervisor;
use App\Services\GeneralServices;
use App\Services\Paginate;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{

    public function index()
    {
        $result = new Paginate(new Supervisor(), 'supervisors', request('page'));
        return response()->success($result->get());
    }


    public function store(SupervisorRequest $request)
    {
        Supervisor::create($request->prepar_data_store());
        return response()->success('', 'تم الانشاء بنجاح');
    }


    public function show($id)
    {
        //
    }


    public function update(SupervisorRequest $request, $supervisor_id)
    {
        $inputs = $request->validated();

        $supervisor = Supervisor::findOrFail($supervisor_id);

        if ($request->hasFile('image'))
            $inputs['image'] = GeneralServices::change_file($supervisor->image, 'supervisorImage', $inputs['image']);

        $supervisor->update($inputs);
        return response()->success('', 'تم التعديل بنجاح');
    }


    public function destroy($supervisor_id)
    {
        $supervisor = Supervisor::findOrFail($supervisor_id, 'id');
        $supervisor->delete();
        return response()->success('', 'تم التعطيل بنجاح');
    }

    public function deleted_account()
    {
        $result = new Paginate(new Supervisor(), 'supervisors', request('page'));
        return response()->success($result->onlyTrashed()->get());
    }

    public function restore_account($supervisor_id)
    {
        $supervisor = Supervisor::onlyTrashed()->whereId($supervisor_id)->firstOrFail('id');
        $supervisor->restore();
        return response()->success('', 'تم التفعيل بنجاح');
    }

    public function select_supervisors()
    {
        $supervisors = Supervisor::all(['id','name']);
        return response()->success($supervisors);
    }
}
