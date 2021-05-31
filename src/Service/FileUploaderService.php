<?php


namespace App\Service;

use App\Entity\Thumb;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService implements FileUploaderServiceInterface
{
    private string $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function profilThumb(UploadedFile $file, $user): Thumb
    {
        if (!$user->getThumb()) {
            $thumb = new Thumb();
        } else {
            $thumb = $user->getThumb();
        }

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = 'avatar.' . $file->guessExtension();
        $type = $file->getClientOriginalExtension();

        try {
            $file->move($this->getTargetDirectory() . $user->getId(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        $thumb->setOldName($originalFilename);
        $thumb->setNewName($fileName);
        $thumb->setType($type);

        return $thumb;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}