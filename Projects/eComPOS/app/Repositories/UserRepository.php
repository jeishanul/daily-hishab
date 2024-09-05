<?php

namespace App\Repositories;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository extends Repository
{
    public static $path = "/users";
    public static function model()
    {
        return User::class;
    }

    public static function findByEmail($email)
    {
        return self::query()->where('email', $email)->first();
    }

    public static function getAccessToken(User $user)
    {
        $token = $user->createToken('user token');

        return [
            'auth_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => $token->token->expires_at->format('Y-m-d H:i:s'),
        ];
    }

    //User create
    public static function storeByRequest($request)
    {
        $profile = null;
        if ($request->hasFile('image')) {
            $media = MediaRepository::updateOrCreateByRequest(
                $request->image,
                self::$path,
                'Image'
            );
            $profile = $media->id;
        }

        return self::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => bcrypt($request->password),
            'media_id' => $profile
        ]);
    }

    //User Profile update
    public static function updateByRequest($request, User $user)
    {
        $media = $user->media;
        if ($request->hasFile('image')) {
            $media = MediaRepository::updateOrCreateByRequest(
                $request->image,
                self::$path,
                'Image',
                $media,
            );
        }
        self::update($user, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'media_id' => $media ? $media->id : null,
        ]);

        return $user;
    }

    public static function updateByPassword(ChangePasswordRequest $request, User $user): bool
    {
        return self::update($user, [
            'password' => bcrypt($request->password)
        ]);
    }

    public static function resetPassword(ResetPasswordRequest $request, User $user)
    {
        return self::update($user, [
            'password' => bcrypt($request->password)
        ]);
    }
    public static function emailVarifyAt(User $user)
    {
        return self::update($user, [
            'email_verified_at' => now()
        ]);
    }

    public static function searchByCustomer($search)
    {
        $customers = self::query()->role('customer')->when($search, function ($query) use ($search) {
            $query->where('name', 'Like', "%{$search}%");
            $query->orWhere('email', 'Like', "%{$search}%");
            $query->orWhere('phone_number', 'Like', "%{$search}%");
            $query->orWhere('company_name', 'Like', "%{$search}%");
            $query->orWhere('address', 'Like', "%{$search}%");
        })->get();

        return $customers;
    }
}
