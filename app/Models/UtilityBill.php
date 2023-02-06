<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilityBill extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'utility_bill';
    protected $primaryKey = ['month','dormitoryid','year'];
    protected $keyType = 'string';

    protected $fillable = [
        'year',
        'month',
        'dormitoryid',
        'eletricfee',
        'waterfee',
        'status',
    ];

    public $timestamps = false;
    public $incrementing = false;
}
