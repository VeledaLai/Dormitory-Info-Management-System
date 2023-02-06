<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AccessCard;
use App\Models\Payment;
class Student extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'student';
    protected $primaryKey = 'studentid';
    protected $keyType = 'string';

    protected $attributes = [
        'dormitoryid' => null,
    ];

    protected $fillable = [
        'studentid',
        'name',
        'gender',
        'classes',
        'pwd',
        'status',
        'dormitoryid',
    ];

    public $timestamps = false;
    public $incrementing = false;

    public function accessCard(){
        return $this->hasOne(AccessCard::class);
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }

    public function dormitory(){
        return $this->hasOne(Dormitory::class);
    }
}
