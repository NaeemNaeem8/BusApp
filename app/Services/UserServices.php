<?php

namespace App\Services;

use App\Models\TypeRequest;
use App\Models\User;

class UserServices
{
    public function Change_register(array $inputs, User $user): void
    {
        if (array_key_exists('card_image', $inputs))
            $inputs['card_image'] = $inputs['card_image']->store('TempCardImage', 'public');

        $inputs['new_register_type'] = $inputs['register_type'];
        $inputs['user_id'] = $user->id;
        unset($inputs['register_type']);
        TypeRequest::create($inputs);

        $user->confirmed = false;

        $user->save();

        $user->tokens()->delete();
    }

    public function update(array $inputs, User $user): void
    {
        if (array_key_exists('image', $inputs))
            $inputs['image'] = GeneralServices::change_file($user->image, 'usersImage', $inputs['image']);

        if (array_key_exists('card_image', $inputs))
            $inputs['card_image'] = GeneralServices::change_file(
                $user->card_image,
                'usersCardImage',
                $inputs['card_image']
            );

        $user->update($inputs);
    }

    public static function check_valid_type(User $user, $newType): bool
    {
        return ($user->getRawOriginal('register_type') == false && $newType == 'session')
            && ($user->getRawOriginal('register_type') == true && $newType == 'daily');
    }
}
