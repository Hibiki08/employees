<?php

namespace App\Service\Import;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportService
{
    private UserRepository $userRepository;
    private StringParser $stringParser;
    private string $filePath;
    private string $fileExtension;

    const CSV_FILE_EXTENSION = 'csv';
    const BATCH_SIZE = 20;

    public function __construct(
        UserRepository $userRepository,
        StringParser $stringParser
    )
    {
        $this->userRepository = $userRepository;
        $this->stringParser = $stringParser;
    }

    public function setUploadedFile(UploadedFile $uploadedFile)
    {
        $this->filePath = $uploadedFile->getPathname();
        $this->fileExtension = $uploadedFile->getClientOriginalExtension();
    }

    public function import()
    {
        $fileData = $this->getFileData();
        if (!empty($fileData)) {
            $this->userRepository->createQueryBuilder('User')
                ->delete()
                ->getQuery()
                ->execute();
            $this->saveBatches($fileData);
        }
    }

    private function getFileData()
    {
        $fileData = [];
        if ($this->fileValidate()) {
            $file = fopen($this->filePath, "r");
            if ($file) {
                while (($string = fgetcsv($file)) !== false) {
                    $fileData[] = $string;
                }
                fclose($file);
            }
        }

        return $fileData;
    }

    /**
     * @return bool
     */
    private function fileValidate()
    {
        return $this->filePath && file_exists($this->filePath) && $this->fileExtension == self::CSV_FILE_EXTENSION;
    }

    private function saveBatches(array $fileData, $batchSize = self::BATCH_SIZE)
    {
        $entityManager = $this->userRepository->getEntityManager();
        $i = 1;
        foreach ($fileData as $fileDatum) {
            $stringParser = $this->stringParser->parse($fileDatum[0]);
            $userName = $stringParser->getUserName();
            $key = $stringParser->getUserKey();
            $parentKey = null;
            if (isset($fileDatum[1])) {
                $parentKey = $stringParser->parse($fileDatum[1])->getUserKey();
            }

            $user = UserRepository::createUser(
                $userName,
                $key,
                $parentKey
            );
            ++$i;
            $entityManager->persist($user);
            if (($i % $batchSize) === 0) {
                $entityManager->flush();
                $entityManager->clear();
            }
        }
        $entityManager->flush();
        $entityManager->clear();
    }
}
