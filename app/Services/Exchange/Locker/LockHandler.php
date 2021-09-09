<?php

namespace App\Services\Exchange\Locker;


/**
 * Class LockHandler
 * @package App\Services\Exchange\Locker
 */
class LockHandler
{
    /**
     * @var string
     */
    private string $statusFilePath;

    /**
     * @var resource
     */
    private $lockFileHandler;

    /**
     * @param string $statusFilePath
     */
    public function __construct(string $statusFilePath)
    {
        $this->statusFilePath = $statusFilePath;
    }

    /**
     * Lock status file.
     * @return bool
     * @throws LockerException
     */
    public function lock()
    {
        $this->lockFileHandler = fopen($this->statusFilePath, 'w');
        if (!$this->lockFileHandler) {
            throw new LockerException("Can't create lock file");
        }

        return flock($this->lockFileHandler, LOCK_EX | LOCK_NB);
    }

    /**
     * Unlock status file.
     */
    public function unlock()
    {
        flock($this->lockFileHandler, LOCK_UN);
        fclose($this->lockFileHandler);
    }
}
