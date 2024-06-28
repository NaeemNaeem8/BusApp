<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\RegisterTypeRequest;
use App\Http\Requests\Mobile\UserDaysRequest;
use App\Http\Requests\Mobile\UserRequest;
use App\Http\Resources\Mobile\UserResource;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $user = User::whereId(auth()->id())->with(['university'])->firstOrFail();
        return response()->success(new UserResource($user));
    }

    public function update(UserRequest $request, UserServices $services)
    {
        $user = User::whereId(auth()->id())->firstOrFail();
        $services->update($request->validated(), $user);
        return response()->success('', 'تم التعديل بنجاح');


    }


    public function destroy($user_id)
    {
        $user = User::whereId($user_id)->firstOrFail('id');
        $user->delete();
        return response()->success('', 'تم الحذف بنجاح');
    }

    public function restore_account(Request $request)
    {
        $request->validate([
            'email'         => ['email', 'required'],
            'password'      => ['required', 'string', 'min:8']
        ]);

        $user = User::onlyTrashed()->whereEmail($request->email)->firstOrFail();

        if (!Hash::check($request->password, $user->password))
            return  response()->error('wrong email or password', 401);

        $user->restore();

        $user->confirmed = false;

        $user->save();

        return response()->success('', 'تمت استعادة الحساب بنجاح');
    }

    public function change_register_type(RegisterTypeRequest $request, UserServices $services)
    {
        $user = User::findOrFail(auth()->id());

        abort_if(
            UserServices::check_valid_type($user, $request->register_type),
            422,
            'your registration type is already selected'
        );

        $services->Change_register($request->validated(), $user);

        return response()->success('', 'تم تقديم طلبك سوف يتم معالجة الطلب باسرع وقت');
    }



}
