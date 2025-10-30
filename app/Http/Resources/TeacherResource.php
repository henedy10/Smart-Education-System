<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data'             => new UserResource($this->whenLoaded('user')),
            'class'            => $this->class,
            'subject'          => $this->subject,
            'lessons_count'    => $this->whenCounted('lessons'),
            'homeworks_count'  => $this->whenCounted('homeworks'),
            'quizzes_count'    => $this->whenCounted('quizzes'),
        ];
    }
}
