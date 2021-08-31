<?php

namespace App\Providers;

use App\Enums\RoleStateType;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class SalesErpUserAuthProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $query = $this->createModel()->newQuery();
        $query = $query->where([
            ['email', $credentials['email']],
            ['role_id', $credentials['role_id']],
        ]);
        if ($credentials['role_id'] == RoleStateType::MANAGERMENT || $credentials['role_id'] == RoleStateType::SALER || $credentials['role_id'] == RoleStateType::SHIP) {
            // $query = $query->whereHas('company');
        }
        return $query->first();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param Authenticatable $authenticatable
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $authenticatable, array $credentials)
    {
        return Hash::check($credentials['password'], $authenticatable->password);
    }
}
