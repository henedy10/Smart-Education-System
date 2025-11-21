<?php

namespace App\Traits;

trait UploadFile {

    public function uploadFile($studentName,$file)
    {
        $fileName = $studentName.'.'.$file->getClientOriginalExtension();
        $filePath = $file->storeAs('solutions_homework',$fileName,'public');

        return $filePath;
    }
}
