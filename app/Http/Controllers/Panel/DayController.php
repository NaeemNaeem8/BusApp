<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Day;
use Illuminate\Http\Request;

class DayController extends Controller
{

    public function index()
    {
        $days =  Day::all(['id','name']);
        return response()->success($days);
    }

    // public function update(Request $request, $day_id)
    // {
    //     $day = Day::onlyTrashed()->whereId($day_id)->firstOrFail();
    //     $day->update(['deleted_at' => null]);
    //     return response()->success('', 'تم التفعيل بنجاح');
    // }

    public function destroy($day_id)
    {
        $day = Day::findOrFail($day_id);
        $day->delete();
        return  response()->success('', 'تم التعطيل بنجاح');
    }

    public function restore_day($day_id)
    {
        $day = Day::withTrashed()->whereId($day_id)->firstOrFail('id');
        $day->restore();
        return response()->success('', 'تم التفعيل بنجاح');
    }

    public function deleted_day()
    {
        $days =  Day::onlyTrashed()->get(['id','name']);
        return response()->success($days);
    }
}
