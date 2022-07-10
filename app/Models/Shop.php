<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','name','description','image','latitude','longitude','hour','address'];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
