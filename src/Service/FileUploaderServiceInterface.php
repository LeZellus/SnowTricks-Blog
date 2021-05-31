<?php

namespace App\Service;

use App\Entity\Thumb;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderServiceInterface
{
    public function profilThumb(UploadedFile $file, $user): Thumb;
}