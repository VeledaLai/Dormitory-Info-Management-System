<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormitoryRecord extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'dormitory_records';
    protected $primaryKey = 'dormitoryid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $attributes = [
        'remaining_beds' => null,
    ];

    protected $fillable = [
        'dormitoryid',
        'remaining_beds',
    ];

    public function dormitory(){
        return $this->belongsTo('App\Models\Dormitory','dormitoryid','dormitoryid');
    }
}
