<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = ["Pendente", "Em progresso", "Concluida"];

        return [
            "id" => $this->id,
            "project_id" => $this->project_id,
            "title" => $this->title,
            "description" => $this->description,
            "status" => $this->status,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "concluded_at" => $this->concluded_at,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "status_description" => $status[$this->status],
            "start_date_format" => $this->start_date ? [
                "date" => Carbon::parse($this->start_date)->format('d/m/Y'),
                "time" => Carbon::parse($this->start_date)->format('H:i'),
            ] : null,
            "end_date_format" => $this->end_date ? [
                "date" => Carbon::parse($this->end_date)->format('d/m/Y'),
                "time" => Carbon::parse($this->end_date)->format('H:i'),
            ] : null,
            "term" => $this->end_date ?
                ($this->status == 2 ? "Concluído " . Carbon::parse($this->concluded_at)->diffForHumans() : (Carbon::parse($this->end_date)->isPast() ? "Expirado"
                        : "Termina " . Carbon::parse($this->end_date)->diffForHumans()))
                : null,
            "concluded_at_format" => $this->concluded_at ? [
                "date" => Carbon::parse($this->concluded_at)->format('d/m/Y'),
                "time" => Carbon::parse($this->concluded_at)->format('H:i'),
            ] : null,
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
