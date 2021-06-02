<?php

namespace App\Service;

use App\Entity\Thumb;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderServiceInterface
{
    public function uploadThumb(UploadedFile $file, $user,string $typeThumb): Thumb;
}