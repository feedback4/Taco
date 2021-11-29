<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, hasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $states = ['القاهرة', 'الجيزة', 'الإسكندرية', 'الإسماعيليّة', 'أسوان', 'أسيوط', 'الأقصر', 'البحر الأحمر', 'بني سويف', 'البحيرة', 'بورسعيد', 'جنوب سيناء', 'الدقهلية', 'دمياط', 'سوهاج', 'السويس', 'الشرقيّة', 'شمال سيناء', 'الغربيّة', 'قنا', 'كفر الشيخ', 'مرسى مطروح', 'المنوفيّة', 'المنيا', 'الوادي الجديد'];


    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
//
//                ->orWhereHas('roles', fn($q) => $q->where('name','like', '%'.$search.'%'))
//                ->orWhereHas('branch', fn($q) => $q->where('name','like', '%'.$search.'%'));
    }
}
