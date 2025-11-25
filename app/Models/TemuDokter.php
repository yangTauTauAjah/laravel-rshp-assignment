<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemuDokter extends Model
{
    protected $table = 'temu_dokter';
    protected $primaryKey = 'idreservasi_dokter';
    public $timestamps = false; // Using custom timestamp fields
    
    protected $fillable = [
        'no_urut',
        'waktu_daftar',
        'status',
        'idrole_user'
    ];
    
    protected $casts = [
        'waktu_daftar' => 'datetime',
        'status' => 'string'
    ];
    
    /**
     * Get the doctor (role_user) associated with this appointment
     */
    public function dokter()
    {
        return $this->belongsTo(RoleUser::class, 'idrole_user', 'idrole_user');
    }
    
    /**
     * Status constants
     */
    const STATUS_MENUNGGU = '0';
    const STATUS_SELESAI = '1';
    const STATUS_BATAL = '2';
    
    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_BATAL => 'Batal',
            default => 'Tidak Diketahui'
        };
    }
    
    /**
     * Scope for active appointments (not cancelled)
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', self::STATUS_BATAL);
    }
    
    /**
     * Scope for pending appointments
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }
}
