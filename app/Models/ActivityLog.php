<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'properties' => 'collection',
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public function causer()
    {
        return $this->morphTo();
    }

    public function performedOn(Model $model): static
    {
        $this->subject()->associate($model);

        return $this;
    }
}
