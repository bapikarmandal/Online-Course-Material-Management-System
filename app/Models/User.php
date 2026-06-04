<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_STUDENT = 'student';
    public const ROLE_FACULTY = 'faculty';
    public const ROLE_ADMIN   = 'admin';

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'department', 'last_login_at', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function isAdmin(): bool   { return $this->role === self::ROLE_ADMIN; }
    public function isFaculty(): bool { return $this->role === self::ROLE_FACULTY; }
    public function isStudent(): bool { return $this->role === self::ROLE_STUDENT; }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class, 'uploaded_by');
    }

    public function downloadLogs(): HasMany
    {
        return $this->hasMany(DownloadLog::class);
    }
}