<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file_homework'     => $this->file_homework,
            'content_homework'  => $this->content_homework,
            'deadline'          => $this->deadline,
            'title_homework'    => $this->title_homework,
            'homework_mark'     => $this->homework_mark,
            'data'              => $this->whenLoaded('teacher')
        ];
    }
}
