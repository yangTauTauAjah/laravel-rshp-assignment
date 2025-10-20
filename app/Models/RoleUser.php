<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';
    protected $primaryKey = 'idrole_user';
    protected $fillable = [
        'iduser',
        'idrole',
        'status'
    ];
    public $timestamps = false;

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }    public function role()
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }

    /**
     * Relationship to RekamMedis (medical records where this role_user is the examining doctor)
     */
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'dokter_pemeriksa', 'idrole_user');
    }
}
