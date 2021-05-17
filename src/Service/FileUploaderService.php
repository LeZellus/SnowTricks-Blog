<?php

namespace App\Service;

use App\Entity\Thumb;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploaderService implements FileUploadServiceInterface
{
    private string $targetDirectory;
    private SluggerInterface $slugger;

    public function __construct(string $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload($file): Thumb
    {
        try {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);

            $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            $file->move($this->getTargetDirectory(), $fileName);

            $thumb = new Thumb();
            $thumb->setName($fileName);
            $thumb->setSize(filesize($this->getTargetDirectory() . $fileName));

            return $thumb;
        } catch (FileException $e) {
            throw new FileException();
        }
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}
