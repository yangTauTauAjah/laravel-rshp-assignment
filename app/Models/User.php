<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'iduser';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function roleUsers()
    {
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }

    public function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole', 'iduser', 'idrole')
            ->withPivot('status')
            ->wherePivot('status', 1);
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('nama_role', $roleName)->exists();
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('nama_role', (array) $roles)->exists();
    }

    // Permission checking methods based on role definitions
    
    /**
     * Check if user is Administrator (full access)
     */
    public function isAdministrator()
    {
        return $this->hasRole('Administrator');
    }

    /**
     * Check if user is Dokter (view-only access)
     */
    public function isDokter()
    {
        return $this->hasRole('Dokter');
    }

    /**
     * Check if user is Resepsionis (CRUD access to specific modules)
     */
    public function isResepsionis()
    {
        return $this->hasRole('Resepsionis');
    }

    /**
     * Check if user is Perawat (permissions TBD)
     */
    public function isPerawat()
    {
        return $this->hasRole('Perawat');
    }

    /**
     * Check if user can access admin panel
     * (Administrator, Dokter, Resepsionis, Perawat)
     */
    public function canAccessAdmin()
    {
        return $this->hasAnyRole(['Administrator', 'Dokter', 'Resepsionis', 'Perawat']);
    }

    /**
     * Check if user can perform CREATE operations
     * Administrator: Yes
     * Dokter: No
     * Resepsionis: Yes (specific modules)
     * Perawat: TBD
     */
    public function canCreate($module = null)
    {
        if ($this->isAdministrator()) {
            return true; // Full access
        }

        if ($this->isDokter()) {
            return false; // View-only
        }

        if ($this->isResepsionis()) {
            // Can create in: jenis-hewan, pet, pemilik, tindakan-terapi
            $allowedModules = ['jenis-hewan', 'pet', 'pemilik', 'tindakan-terapi'];
            return $module ? in_array($module, $allowedModules) : true;
        }

        return false;
    }

    /**
     * Check if user can perform UPDATE operations
     */
    public function canEdit($module = null)
    {
        if ($this->isAdministrator()) {
            return true; // Full access
        }

        if ($this->isDokter()) {
            return false; // View-only
        }

        if ($this->isResepsionis()) {
            // Can edit in: jenis-hewan, pet, pemilik, tindakan-terapi
            $allowedModules = ['jenis-hewan', 'pet', 'pemilik', 'tindakan-terapi'];
            return $module ? in_array($module, $allowedModules) : true;
        }

        return false;
    }

    /**
     * Check if user can perform DELETE operations
     */
    public function canDelete($module = null)
    {
        if ($this->isAdministrator()) {
            return true; // Full access
        }

        if ($this->isDokter()) {
            return false; // View-only
        }

        if ($this->isResepsionis()) {
            // Can delete in: jenis-hewan, pet, pemilik, tindakan-terapi
            $allowedModules = ['jenis-hewan', 'pet', 'pemilik', 'tindakan-terapi'];
            return $module ? in_array($module, $allowedModules) : true;
        }

        return false;
    }

    /**
     * Check if user can VIEW specific module
     */
    public function canView($module = null)
    {
        if ($this->isAdministrator()) {
            return true; // Full access
        }

        if ($this->isDokter()) {
            // Can view: jenis-hewan, pet, pemilik, tindakan-terapi
            $allowedModules = ['jenis-hewan', 'pet', 'pemilik', 'tindakan-terapi'];
            return $module ? in_array($module, $allowedModules) : true;
        }

        if ($this->isResepsionis()) {
            // Can view: jenis-hewan, pet, pemilik, tindakan-terapi
            $allowedModules = ['jenis-hewan', 'pet', 'pemilik', 'tindakan-terapi'];
            return $module ? in_array($module, $allowedModules) : true;
        }

        return false;
    }

    /**
     * Check if user can manage users (user management module)
     */
    public function canManageUsers()
    {
        return $this->isAdministrator();
    }

    /**
     * Check if user can manage roles
     */
    public function canManageRoles()
    {
        return $this->isAdministrator();
    }
}
