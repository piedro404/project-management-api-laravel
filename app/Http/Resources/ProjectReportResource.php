<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Filters\TaskFilter;

class ProjectReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $tasks = $this->tasks;

        $tasks_pending = TaskFilter::filter_status(0, $tasks);
        $tasks_progress = TaskFilter::filter_status(1, $tasks);
        $tasks_concluded = TaskFilter::filter_status(2, $tasks);
        $tasks_expired = TaskFilter::filter_expired($tasks);

        $average_days_tasks_concluded = $tasks_concluded->map(function ($task) {
            $created_at = Carbon::parse($task->created_at);
            $concluded_at = Carbon::parse($task->concluded_at);
            return $created_at->diffInMinutes($concluded_at);
        })->avg();

        $tasks_created_month = TaskFilter::filter_month($tasks, "created_at");
        $tasks_concluded_month = TaskFilter::filter_month($tasks, "concluded_at");
        $tasks_not_concluded_month = TaskFilter::filter_month(TaskFilter::filter_status(2, $tasks, true), "end_date");

        $total_number_tasks = [
            'tasks' => $this->tasks->count(),
            'tasks_pending' => $tasks_pending->count(),
            'tasks_progress' => $tasks_progress->count(),
            'tasks_concluded' => $tasks_concluded->count(),
            'tasks_expired' => $tasks_expired->count(),
        ];

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "user" => new UserResource($this->user),
            "title" => $this->title,
            "description" => $this->description,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "tasks" => TaskResource::collection($this->tasks),
            'tasks_pending' => TaskResource::collection($tasks_pending),
            'tasks_progress' => TaskResource::collection($tasks_progress),
            'tasks_expired' => TaskResource::collection($tasks_expired),
            'tasks_concluded' => TaskResource::collection($tasks_concluded),
            'report' => [
                'total_number' => [
                    'tasks' => $total_number_tasks['tasks'],
                    'tasks_pending' => $total_number_tasks['tasks_pending'],
                    'tasks_progress' => $total_number_tasks['tasks_progress'],
                    'tasks_expired' => $total_number_tasks['tasks_expired'],
                    'tasks_concluded' => $total_number_tasks['tasks_concluded'],
                ],
                'percentage' => [
                    'tasks_pending' => round(($total_number_tasks['tasks_pending'] / $total_number_tasks['tasks']) * 100, 2),
                    'tasks_progress' => round(($total_number_tasks['tasks_progress'] / $total_number_tasks['tasks']) * 100, 2),
                    'tasks_expired' => round(($total_number_tasks['tasks_expired'] / $total_number_tasks['tasks']) * 100, 2),
                    'tasks_concluded' => round(($total_number_tasks['tasks_concluded'] / $total_number_tasks['tasks']) * 100, 2),
                ],
                'current_month' => [
                    'tasks_created' => $tasks_created_month->count(),
                    'tasks_concluded' => $tasks_concluded_month->count(),
                    'tasks_not_concluded' => $tasks_not_concluded_month->count(),
                ],
                'average' => [
                    'average_days_tasks_concluded' => $average_days_tasks_concluded,
                ],
            ],
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
}
