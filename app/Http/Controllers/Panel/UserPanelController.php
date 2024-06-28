<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\TypeRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Paginate;

class UserPanelController extends Controller
{
    public function index()
    {
        $result = new Paginate(new User, 'users', request('page'));
        return response()->success($result
            ->orderBy('updated_at', 'DESC')
            ->where([['confirmed', true]])
            ->with(['university'])
            ->get());
    }

    public function show($user_id)
    {
        $user = User::whereId($user_id)->with('university')->firstOrFail();
        return response()->success($user);
    }

    public function update(Request $request, $user_id)
    {
        $user = User::withTrashed()->with('type_request')->whereId($user_id)->firstOrFail();
        $message = 'تم التفعيل بنجاح';

        if ($user->confirmed == true) {
            $message = 'تم الغاء التفعيل بنجاح';
            $user->update(['confirmed' => false]);
        } else {
            if ($user->type_request != null) {
                $user->update([
                    'confirmed'         => true,
                    'deleted_at'        => null,
                    'register_type'     => $user->type_request->new_register_type,
                    'card_image'        => $user->type_request->card_image
                ]);
                $type_request = TypeRequest::whereId($user->type_request->id)->delete();
            } else {
                $user->update(['confirmed' => true, 'deleted_at' => null]);
            }
        }
        return response()->success('', $message);
    }

    public function destroy($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->confirmed = false;
        $user->save();
        $user->delete();
        return response()->success('', 'تم تعطيل الحساب بنجاح');
    }

    public function deactivated_users()
    {
        $result = new Paginate(new User(), 'users', request('page'));
        return response()->success(
            $result
                ->where([['confirmed', false]])
                ->with(['type_request'])
                ->withTrashed()
                ->orderBy('updated_at', 'DESC')
                ->get()
        );
    }

    public function deactivated_users_count()
    {
        $count = User::withTrashed()->whereConfirmed(false)->count();
        return response()->success(['users_count' => $count]);
    }
}
