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

    /**
     * @param UploadedFile $uploadedFile
     * @param $paramEntity
     * @param string $uploadType
     * @return Thumb
     */
    public function uploadThumb(UploadedFile $uploadedFile, $paramEntity, string $uploadType): Thumb
    {
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileType = $uploadedFile->getClientOriginalExtension();


        if ($uploadType == "profilThumb") {
            $thumb = $paramEntity->getThumb() ? $paramEntity->getThumb() : new Thumb();
            $fileName = 'avatar.' . $uploadedFile->guessExtension();

            /** Save the file into user pseudo name folder  */
            try {
                $uploadedFile->move($this->getTargetDirectory() . 'avatars/' . $paramEntity->getId(), $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $thumb->setIsMain(false);

        } elseif ($uploadType == "mainThumb") {
            $thumb = new Thumb();
            $fileName = $this->slugger->slug($originalFilename) . uniqid() . '.' . $uploadedFile->guessExtension();

            /** Save the file into user pseudo name folder  */
            try {
                $uploadedFile->move($this->getTargetDirectory() . 'tricks/', $fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $thumb->setIsMain(false);
        };

        $thumb->setNewName($fileName);
        $thumb->setType($fileType);

        return $thumb;
    }

    /**
     * @param Thumb $thumb
     * @return Thumb
     */
    public function saveImage(Thumb $thumb): Thumb
    {
        $uploadedFile = $thumb->getFile();
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileType = $uploadedFile->getClientOriginalExtension();
        $fileName = $safeFilename . '-' . md5(uniqid()) . '.' . $uploadedFile->guessExtension();
        //$path= $this->getTargetDirectory() . 'tricks/';

        try {
            $uploadedFile->move($this->getTargetDirectory() . 'tricks/', $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        // Donner le path et le nom au fichier dans la base de données
        $thumb->setType($fileType);
        $thumb->setNewName($fileName);
        $thumb->setPath($originalFilename);

        return $thumb;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}