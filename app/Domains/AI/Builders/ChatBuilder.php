<?php

namespace App\Domains\AI\Builders;

use App\Domains\User\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method \App\Domains\AI\Models\Chat first($columns = ['*'])
 */
class ChatBuilder extends Builder
{
    public function forUser(User $user): self
    {
        return $this->where('user_id', $user->id);
    }

    public function active(): self
    {
        return $this->where('active_until', '>=', Carbon::now());
    }
}
