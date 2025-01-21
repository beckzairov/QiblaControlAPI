<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Agreement;
use Illuminate\Support\Facades\Log;

class AgreementPolicy
{
    /**
     * Determine if the user can view an agreement.
     */
    public function view(User $user, Agreement $agreement)
    {
        // All authenticated users can view agreements
        return true;
    }

    /**
     * Determine if the user can update an agreement.
     */
    public function update(User $user, Agreement $agreement)
    {
        // Admins and Managers can update anything
        if ($user->hasRole('Admin') || $user->hasRole('Manager')) {
            return true;
        }

        // Sale Operators can update agreements but NOT the responsible_user_id
        if ($user->hasRole('Sale Operator')) {
            Log::info('Sale Operator has access');
            return true;
        }

        // Specialists or others cannot update agreements
        return false;
    }

    /**
     * Determine if the user can update the responsible_user_id.
     */
    public function updateResponsibleUser(User $user, Agreement $agreement)
    {
        // Only Admins can change the responsible_user_id
        return $user->hasRole('Admin');
    }

    /**
     * Determine if the user can delete agreements.
     */
    public function delete(User $user, Agreement $agreement)
    {
        // Only Admins can delete agreements
        return $user->hasRole('Admin');
    }
}
