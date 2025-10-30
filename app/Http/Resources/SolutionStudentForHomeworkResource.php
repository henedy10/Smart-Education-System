<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionStudentForHomeworkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'homework_solution_file' => $this->homework_solution_file,
            'student_grade'          => new HomeworkGradeResource($this->whenLoaded('homeworkGrade')),
        ];
    }
}
