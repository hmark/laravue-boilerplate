<?php

namespace App\Services;

use App\Enums\ActivityType;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLoggerService
{
    protected ?ActivityLog $activity = null;

    protected function getActivity(): ActivityLog
    {
        if (!$this->activity) {
            $this->activity = new ActivityLog();
        }

        return $this->activity;
    }

    public function on(Model $model): static
    {
        $this->getActivity()->subject()->associate($model);

        return $this;
    }

    public function by(User | Model $model): static
    {
        $this->getActivity()->causer()->associate($model);

        return $this;
    }

    public function withProperties(array $properties): static
    {
        $this->getActivity()->properties = collect($properties);

        return $this;
    }

    public function log(ActivityType $type): ActivityLog
    {
        $activity = $this->activity;
        $activity->type = $type->value;
        $activity->save();

        $this->activity = null;

        return $activity;
    }
}
