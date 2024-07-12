<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tasks = $this->tasks;

        $tasks_pending = $this->filter_status(0, $tasks);
        $tasks_progress = $this->filter_status(1, $tasks);
        $tasks_concluded = $this->filter_status(2, $tasks);
        $tasks_expired = $this->filter_expired($tasks);

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "title" => $this->title,
            "description" => $this->description,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "tasks" => TaskResource::collection($this->tasks),
            'tasks_pending' => TaskResource::collection($tasks_pending),
            'tasks_progress' => TaskResource::collection($tasks_progress),
            'tasks_concluded' => TaskResource::collection($tasks_concluded),
            'tasks_expired' => TaskResource::collection($tasks_expired),
            "start_date_format" => $this->start_date ? [
                "date" => Carbon::parse($this->start_date)->format('d/m/Y'),
                "time" => Carbon::parse($this->start_date)->format('H:i'),
            ] : null,
            "end_date_format" => $this->end_date ? [
                "date" => Carbon::parse($this->end_date)->format('d/m/Y'),
                "time" => Carbon::parse($this->end_date)->format('H:i'),
            ] : null,
            "term" => $this->end_date ?
                ($this->status == 2 ? "Concluído" : (Carbon::parse($this->end_date)->isPast() ? "Expirado"
                    : "Termina " . Carbon::parse($this->end_date)->diffForHumans()))
                : null,
            "created_at_format" => [
                "date" => Carbon::parse($this->created_at)->format('d/m/Y'),
                "time" => Carbon::parse($this->created_at)->format('H:i'),
            ],
            "updated_at_format" => [
                "date" => Carbon::parse($this->updated_at)->format('d/m/Y'),
                "time" => Carbon::parse($this->updated_at)->format('H:i'),
            ],
        ];
    }

    private function filter_status(int $status, $tasks)
    {
        return $tasks->filter(function ($task) use ($status) {
            return $task->status == $status && !Carbon::parse($task->end_date)->isPast();
        })->sortBy('end_date');
    }

    private function filter_expired($tasks)
    {
        return $tasks->filter(function ($task) {
            return $task->status != 3 && Carbon::parse($task->end_date)->isPast();
        })->sortBy('end_date');
    }
}
