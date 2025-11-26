<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dokter extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'dokter';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'iddokter';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'alamat',
        'no_hp',
        'bidang_dokter',
        'jenis_kelamin',
        'iduser'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'jenis_kelamin' => 'string',
    ];

    /**
     * Get the user that owns the dokter profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    /**
     * Get the full name from the related user.
     */
    public function getNamaAttribute()
    {
        return $this->user?->nama;
    }

    /**
     * Get the email from the related user.
     */
    public function getEmailAttribute()
    {
        return $this->user?->email;
    }

    /**
     * Scope to get active doctors (users with active status).
     */
    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('status', 1);
        });
    }

    /**
     * Scope to filter by gender.
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('jenis_kelamin', $gender);
    }

    /**
     * Scope to filter by specialization field.
     */
    public function scopeBySpecialization($query, $bidang)
    {
        return $query->where('bidang_dokter', 'like', '%' . $bidang . '%');
    }
}
