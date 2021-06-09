<?php

namespace App\Service;

use App\Entity\Thumb;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderServiceInterface
{
    public function uploadThumb(UploadedFile $uploadedFile, $entity , string $typeThumb): Thumb;
}