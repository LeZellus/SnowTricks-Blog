<?php


namespace App\Service;

use App\Entity\Thumb;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploaderService implements FileUploaderServiceInterface
{
    private string $targetDirectory;
    private SluggerInterface $slugger;

    public function __construct(string $targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function uploadThumb(UploadedFile $uploadedFile, $param, $imageType): Thumb
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileType = $uploadedFile->getClientOriginalExtension();

        if ($imageType == 'profilThumb') {
            $fileName = 'avatar.' . $uploadedFile->guessExtension();
            $thumb = $param->getThumb() ? $param->getThumb() : new Thumb();

            /** Save the file into user pseudo name folder  */
            try {
                $uploadedFile->move($this->getTargetDirectory() . 'avatars/' . $param->getId(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

        } elseif ($imageType == 'mainThumb') {
            $thumb = $param->getMainThumb() ? $param->getMainThumb() : new Thumb();
            $fileName = $this->slugger->slug($originalFilename). uniqid() . '.' . $uploadedFile->guessExtension();

            /** Save the file into user pseudo name folder  */
            try {
                $uploadedFile->move($this->getTargetDirectory() . 'tricks/', $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
        }

        $thumb->setOldName($originalFilename);
        $thumb->setNewName($fileName);
        $thumb->setType($fileType);

        return $thumb;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}