<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik';
    protected $primaryKey = 'idpemilik';
    public $incrementing = false; // Primary key is not auto-incrementing
    protected $keyType = 'int'; // Primary key type is integer
    
    protected $fillable = [
        'idpemilik',
        'iduser',
        'no_wa',
        'alamat'
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    public function pets()
    {
        return $this->hasMany(Pet::class, 'idpemilik', 'idpemilik');
    }
}
