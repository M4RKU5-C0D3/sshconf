<?php

namespace m4rku5\SSHConf;

use InvalidArgumentException;
use SplFileObject;
use SplObjectStorage;

class SSHConf
{
    /** @var SplFileObject $file */
    private SplFileObject $file;
    /** @var SplObjectStorage $content */
    private SplObjectStorage $content;

    public function __construct($filepath)
    {
        $this->content = new SplObjectStorage();
        $this->load($filepath)->parse();
    }

    private function load($filepath): self
    {
        if (!file_exists($filepath)) {
            throw new InvalidArgumentException(sprintf('%s does not exist', $filepath));
        }

        $this->file = new SplFileObject($filepath, 'r+');

        return $this;
    }

    private function parse(): void
    {
        /** @var SSHConfHost $host */
        $host = null;
        foreach ($this->file as $line) {
            $line = new SSHConfLine($line);
            if ($line->key() === 'Host') {
                $host = new SSHConfHost($line);
                $this->content->attach($host);
            } elseif ($host) {
                $host->attach($line);
            } else {
                $this->content->attach($line);
            }
            while ($this->content->valid()) {
                $this->content->next();
            }
        }
    }

    public function host(string $name): ?SSHConfHost
    {
        foreach ($this->content as $line) {
            if ($line instanceof SSHConfHost) {
                if ($line->name() === $name) {
                    return $line;
                }
            }
        }

        return null;
    }

    public function get(): SplObjectStorage
    {
        return $this->content;
    }
}
