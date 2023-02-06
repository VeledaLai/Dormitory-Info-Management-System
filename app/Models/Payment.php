<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'payment';
    protected $primaryKey = ['studentid','year'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'studentid',
        'year',
        'status',
    ];

    public function Student(){
        return $this->belongsTo(accessCard::class,'studentid','studentid');
    }

    public function CheckIn(){
        return $this->hasOne(CheckIn::class,'studentid','studentid');
    }
}
