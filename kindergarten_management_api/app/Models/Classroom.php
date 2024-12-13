<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    
    protected $table = "Classroom";

    protected $fillable = [
        "class_name",
        "homeroom_teacher_id",
    ];
    
    public function userClass(){
        return $this->belongsToMany(User::class, 'user_class', 'class_name', 'user_id');
    }

    public function homeroomTeacher(){
        return $this->hasOne(User::class,'homeroom_teacher_id');
    }
}
