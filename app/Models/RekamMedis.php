<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';
    
    // This table has created_at but not updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'anamnesa',
        'temuan_klinis',
        'diagnosa',
        'idpet',
        'dokter_pemeriksa'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relationship to Pet
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    /**
     * Relationship to RoleUser (dokter pemeriksa / examining doctor)
     */
    public function dokterPemeriksa()
    {
        return $this->belongsTo(RoleUser::class, 'dokter_pemeriksa', 'idrole_user');
    }

    /**
     * Relationship to User through RoleUser (examining doctor user)
     */
    public function dokter()
    {
        return $this->hasOneThrough(
            User::class,
            RoleUser::class,
            'idrole_user', // Foreign key on role_user table
            'iduser', // Foreign key on user table
            'dokter_pemeriksa', // Local key on rekam_medis table
            'iduser' // Local key on role_user table
        );
    }

    /**
     * Relationship to DetailRekamMedis (medical record details)
     */
    public function detailRekamMedis()
    {
        return $this->hasMany(DetailRekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }
}
