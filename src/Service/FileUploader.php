<?php

namespace App\Service;

use App\Entity\Thumb;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $thumb = new Thumb();
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);

        $thumb->setNewName($safeFilename);
        $thumb->setOldName($originalFilename);
        $thumb->setPath($safeFilename);

        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();


        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $thumb;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
