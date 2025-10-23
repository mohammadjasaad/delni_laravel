<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    /**
     * تحقق من أن المستخدم يملك المتجر
     */
    public function update(User $user, Store $store): bool
    {
        return $user->id === $store->user_id;
    }

    /**
     * تحقق من إمكانية حذف المتجر
     */
    public function delete(User $user, Store $store): bool
    {
        return $user->id === $store->user_id;
    }
}
