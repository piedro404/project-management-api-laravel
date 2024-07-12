<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class TaskFilter
{
    public static function filter_status(int $status, Collection $tasks, bool $inverse = false)
    {
        if (!$inverse) {
            return $tasks->filter(function ($task) use ($status) {
                return $task->status == $status && ($task->status != 2 ? !Carbon::parse($task->end_date)->isPast() : true);
            })->sortBy('end_date');
        }

        return $tasks->filter(function ($task) use ($status) {
            return $task->status != $status;
        })->sortBy('end_date');
    }

    public static function filter_expired(Collection $tasks)
    {
        return $tasks->filter(function ($task) {
            return $task->status != 2 && Carbon::parse($task->end_date)->isPast();
        })->sortBy('end_date');
    }

    public static function filter_month(Collection $tasks, string $column_date)
    {
        return $tasks->filter(function ($task) use ($column_date) {
            if (!$task->{$column_date}) {
                return false;
            }
            $date = Carbon::parse($task->{$column_date});
            return $date->isCurrentMonth();
        });
    }
}
