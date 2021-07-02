<?php namespace App\Models;

use App\Models\Features\PasswordSetter;
use Illuminate\Foundation\Auth\User;

class AdminUser extends User
{
    use PasswordSetter;

    protected $hidden = ['password', 'remember_token'];
    protected $fillable = ['username', 'password', 'active', 'allowed_ips', 'admin_role_id'];
    protected $casts = [
        'active' => 'boolean',
        'super' => 'boolean',
        'allowed_ips' => 'array',
    ];
}
