<?php

namespace App\Models;

use App\Builders\TokenBuilder;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    /*******************************************
    * Configuration
    *******************************************/

    protected $guarded = [];

    public static function query(): Builder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): TokenBuilder
    {
        return new TokenBuilder($query);
    }

    /*******************************************
    * Accessors
    *******************************************/

    /**
     * Caluclates expires_at value from seconds
     * to current date plus the value in seconds
     *
     * @param  int|null $value
     * @return void
     */
    public function setExpiresAtAttribute(?int $value): void
    {
        if (! empty($value)) {
            $this->attributes['expires_at'] = Carbon::now()->addSeconds($value);
        }
    }

    /**
     * Caluclates expires_at value from seconds
     * to current date plus the value in seconds
     *
     * @param  int|null $value
     * @return void
     */
    public function setRefreshExpiresAtAttribute(?int $value): void
    {
        if (! empty($value)) {
            $this->attributes['refresh_expires_at'] = Carbon::now()->addSeconds($value);
        }
    }
}
