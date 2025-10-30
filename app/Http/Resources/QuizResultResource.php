<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'        => $this->quiz->title,
            'student_mark' => $this->student_mark,
            'quiz_mark'    => $this->quiz_mark,
        ];
    }
}
