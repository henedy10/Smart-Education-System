<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->title,
            'start_time'   => $this->start_time,
            'duration'     => $this->duration,
            'quiz_mark'    => $this->quiz_mark,
            'questions'    => QuestionResource::collection($this->whenLoaded('questions')),
        ];
    }
}
