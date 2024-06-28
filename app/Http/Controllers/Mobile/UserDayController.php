<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\UserDaysRequest;
use App\Models\User;
use App\Models\UserDay;
use Illuminate\Http\Request;

class UserDayController extends Controller
{

    public function index()
    {
        $user_days = UserDay::whereUser_id(auth()->id())
            ->with('day')
            ->get();
        return response()->success($user_days);
    }


    public function store(UserDaysRequest $request)
    {
        $user = User::findOrFail(auth()->id(), ['id']);
        $user->user_days()->createMany($request->validated('user_days'));
        return response()->success('', 'تم الحفظ بنجاح');
    }

    public function update(UserDaysRequest $request, $user_day_id)
    {
        $user_day = UserDay::findOrFail($user_day_id);
        $user_day->update($request->validated());
        return response()->success('', 'تم التعديل بنجاح');
    }

    public function destroy($user_day_id)
    {
        $user_day = UserDay::findOrFail($user_day_id, 'id');
        $user_day->destroy($user_day_id);
        return response()->success('', 'تم الحذف بنجاح');
    }
}
