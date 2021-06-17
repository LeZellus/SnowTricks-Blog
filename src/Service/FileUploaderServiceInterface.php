<?php

namespace App\Service;

use App\Entity\Thumb;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderServiceInterface
{
    public function uploadThumb(UploadedFile $uploadedFile, $paramEntity, string $uploadType): Thumb;
    public function saveImage(Thumb $thumb): Thumb;
}