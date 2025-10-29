<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            'teacher-data'  => new TeacherResource($this->whenLoaded('teacher')),
            'file_lesson'   => $this->file_lesson,
            'title_lesson'  => $this->title_lesson,
        ];
    }
}
