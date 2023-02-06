<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessCard extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'access_card';
    protected $primaryKey = 'studentid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'studentid',
        'buildingid',
        'status',
    ];
    public function student(){
        return $this->belongsTo('Student','studentid','studentid');
    }

    public function dormitory(){
        return $this->belongsTo('Dormitory','buildingid','studentid');
    }
}
