<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TActionHist extends Model
{
    use HasFactory;

    protected $table = 't_action_hist';

    protected $fillable = [
        'operation_type',
        'operation_dt',
        'user_id',
        'created_by',
        'updated_by'
    ];

    const LOGIN = 1;

    const LOGOUT = 2;

    const EXPIRED_TOKEN = 3;
}
