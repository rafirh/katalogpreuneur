<?php

namespace App\Policies;

use App\Models\Produk;
use App\Models\User;

class ProdukPolicy
{
    /**
     * Determine whether the user can view / manage the product in the student area.
     * Admins can always view; students only their own.
     */
    public function view(User $user, Produk $produk): bool
    {
        return $user->isAdmin() || $produk->user_id === $user->id;
    }

    public function update(User $user, Produk $produk): bool
    {
        return $produk->user_id === $user->id;
    }

    public function delete(User $user, Produk $produk): bool
    {
        return $produk->user_id === $user->id;
    }
}
