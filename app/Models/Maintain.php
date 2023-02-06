<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintain extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'maintain';
    protected $primaryKey = 'id';

    protected $attributes = [
        'ctime' => null,
    ];

    protected $fillable = [
        'id',
        'dormitoryid',
        'goodsname',
        'reason',
        'phone',
        'applytime',
        'ctime',
    ];

    public $timestamps = false;
    public $incrementing = true;
}
