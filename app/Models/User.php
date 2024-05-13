<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $createRules = [
        'email' => 'unique:App\Models\User,email',
        'name' => 'required',
        'password' => 'required'
    ];

    public static function getUpdateRule($id)
    {
        return [
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
        ];
    }

    public function password(): Attribute
    {
        return Attribute::make(
            get: fn($val) => $val,
            set: fn($val) => Hash::make($val)
        );
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id')->select([
            'id', 'name'
        ]);
    }

    function isAdmin() {
//        return $this->hasRole(config('permission.super_admin_role'));
        return true;
    }

    protected function getDefaultGuardName(): string
    {
        return 'web';
    }

}
