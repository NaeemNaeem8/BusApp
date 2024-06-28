<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Casts\RegisterType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids,SoftDeletes;


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'card_image',
        'confirmed',
        'register_type',
        'university_id',
        'deleted_at'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'register_type' => RegisterType::class,
        'deleted_at'    => 'boolean',
        'confirmed'    => 'boolean',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (trim($value) === '')
                    return;
                return bcrypt($value);
            }
        );
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class)->withTrashed();
    }


    public function user_days(): HasMany
    {
        return $this->hasMany(UserDay::class,'user_id');
    }


    public function type_request(): HasOne
    {
        return $this->hasOne(TypeRequest::class, 'user_id', 'id');
    }
}
