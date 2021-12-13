<?php

namespace App\Services\Exchange\Locker;


class LockHandler
{
    /**
     * @var resource
     */
    private  $lockFileHandler;
    private string $statusFilePath;


    public function __construct(
        private string $statusPath,
        private string $statusFileName
    ){
        $this->statusFilePath = $statusPath .'/' . $statusFileName;
    }


    public function lock(): bool
    {
        $this->checkDirectory();
        $this->lockFileHandler = fopen($this->statusFilePath, 'w');
        if (!$this->lockFileHandler) {
            throw new LockerException("Can't create lock file");
        }

        return flock($this->lockFileHandler, LOCK_EX | LOCK_NB);
    }


    public function unlock(): void
    {
        flock($this->lockFileHandler, LOCK_UN);
        fclose($this->lockFileHandler);
    }


    private function checkDirectory(): void
    {
        if(is_dir($this->statusPath)){
           return;
        }

        if (!mkdir($concurrentDirectory = $this->statusPath, 0777, true) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
    }
}

