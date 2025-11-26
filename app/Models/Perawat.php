<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perawat extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'perawat';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'idperawat';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'alamat',
        'no_hp',
        'jenis_kelamin',
        'pendidikan',
        'iduser'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'jenis_kelamin' => 'string',
    ];

    /**
     * Get the user that owns the perawat profile.
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
     * Scope to get active nurses (users with active status).
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
     * Scope to filter by education level.
     */
    public function scopeByEducation($query, $pendidikan)
    {
        return $query->where('pendidikan', 'like', '%' . $pendidikan . '%');
    }
}
