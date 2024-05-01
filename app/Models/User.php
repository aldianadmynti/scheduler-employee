<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
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

    // relation
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function scheduller()
    {
        return $this->hasMany(Scheduller::class);
    }

    // get deadline scheduller
    public function getDeadlineScheduller()
    {
        return $this->hasMany(Scheduller::class)->where('end_date', '<', now());
    }

    public function getUnreadScheduller()
    {
        return $this->hasMany(Scheduller::class)->where('status_read', 'unread');
    }
}
