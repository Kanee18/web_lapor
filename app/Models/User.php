<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Impor untuk relasi
// Tidak perlu import Report dan Comment di sini jika hanya digunakan di return type hint method
// tapi jika Anda ingin memastikan atau menggunakannya di tempat lain, tidak masalah diimpor.

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Pastikan baris ini bersih dari spasi aneh di awal

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> // Di Laravel 10+, ini bisa juga list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambahkan jika Anda memiliki kolom 'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all of the reports for the User.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class); // App\Models\Report::class juga boleh
    }

    /**
     * Get all of the comments for the User.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class); // App\Models\Comment::class juga boleh
    }
}