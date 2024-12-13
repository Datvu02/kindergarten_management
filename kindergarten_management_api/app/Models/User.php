<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\RoleEnum;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_id',
        'user_name',
        'phone',
        'address',
        'emailParent',
        'yob',
        'authority',
        'phone_parent',
        'year_old',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'authority' => RoleEnum::class,
            'password' => 'hashed',
        ];
    }

    public function userClass(){
        return $this->belongsToMany(Classroom::class, 'user_class', 'user_id', 'class_name');
    }

    public function refreshToken(){
        return $this->belongsTo(RefreshToken::class);
    }

    public function userCheckIn(){
        return $this->hasMany(UserCheckIn::class, 'user_id', 'id');
    }
}
