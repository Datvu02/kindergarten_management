<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCheckIn extends Model
{
    protected $table = "user_check_in";

    protected $fillable = [
        "id",
        "user_id",
        "created_by",
        "check_in_today",
        "check_in_yesterday",
    ];
    public function user(){
        return $this->hasOne(User::class, "id","user_id");
    }
}
