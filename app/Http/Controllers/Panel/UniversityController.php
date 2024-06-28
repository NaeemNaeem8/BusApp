<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\UniversityRequest;
use App\Models\University;
use App\Services\GeneralServices;
use Illuminate\Http\Request;

class UniversityController extends Controller
{

    public function index()
    {
        $result = University::withCount('users')->get();
        return response()->success($result);
    }

    public function store(UniversityRequest $request)
    {
        $inputs = $request->validated();
        if ($request->hasFile('logo'))
            $inputs['logo'] = $request->logo->store('universityLogo', 'public');
        University::create($inputs);
        return response()->success('', 'تم الانشاء بنجاح');
    }


    public function show($university_id)
    {
        $university = University::findOrFail($university_id);
        return response()->success($university);
    }


    public function update(UniversityRequest $request, $university_id)
    {
        $university = University::findOrFail($university_id);
        $inputs = $request->validated();
        if ($request->hasFile('logo'))
            $inputs['logo'] = GeneralServices::change_file($university->logo, 'universityLogo', $inputs['logo']);

        $university->update($inputs);

        return response()->success('', 'تم التعديل بنجاح');
    }

    public function destroy($university_id)
    {
        $university = University::findOrFail($university_id);
        $university->delete();
        return response()->success('', 'تم التعطيل بنجاح');
    }

    public function restore($university_id)
    {
        $university = University::onlyTrashed()->whereId($university_id)->firstOrFail();
        $university->restore();
        return response()->success('', 'تم التفعيل بنجاح');
    }

    public function deactivated_universities()
    {
        $universities = University::onlyTrashed()->get();
        return response()->success($universities);
    }
}
