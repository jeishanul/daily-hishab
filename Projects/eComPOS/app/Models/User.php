<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasFactory, HasRoles;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class);
    }

    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id')->withPivot('id', 'user_id', 'product_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Sale::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
