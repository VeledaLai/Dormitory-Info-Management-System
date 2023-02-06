<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'dormitory';
    protected $primaryKey = 'dormitoryid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'dormitoryid',
        'buildingid',
        'room_num',
        'bed_num',
    ];

    public function manager()
    {
        return $this->belongsTo('DormitoryRecord', 'dormitoryid', 'dormitoryid');
    }

    public function dormitoryRecord()
    {
        return $this->hasOne('DormitoryRecord', 'dormitoryid', 'dormitoryid');
    }

    public function accessCard()
    {
        return $this->hasMany('DormitoryRecord', 'buildingid', 'dormitoryid');
    }
}
