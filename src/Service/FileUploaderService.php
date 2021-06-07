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

    public function uploadThumb(UploadedFile $file, $param, $imageType): Thumb
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        if ($imageType == 'profilThumb') {
            $fileName = 'avatar.' . $file->guessExtension();

            /** Check if user already get image  */
            if (!$param->getThumb()) {
                $thumb = new Thumb();
            } else {
                $thumb = $param->getThumb();
            }

            /** Save the file into user pseudo name folder  */
            try {
                $file->move($this->getTargetDirectory() . 'avatars/' . $param->getId(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

        } elseif ($imageType == 'mainThumb') {
            $thumb = new Thumb();
            $fileName = $this->slugger->slug($originalFilename). uniqid() . '.' . $file->guessExtension();

            /** Save the file into user pseudo name folder  */
            try {
                $file->move($this->getTargetDirectory() . 'tricks/', $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
        }

        $type = $file->getClientOriginalExtension();

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