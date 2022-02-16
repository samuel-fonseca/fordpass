<?php

namespace App\Builders;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class TokenBuilder extends Builder
{
    public function notExpired(): self
    {
        return $this->where('expires_at', '>', Carbon::now());
    }
}
