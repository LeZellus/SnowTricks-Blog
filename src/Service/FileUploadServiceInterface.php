<?php


namespace App\Service;


use App\Entity\Thumb;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploadServiceInterface
{
    public function upload(UploadedFile $file): Thumb;
}