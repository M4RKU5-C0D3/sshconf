<?php

namespace m4rku5\SSHConf;

use SplFileObject;
use SplObjectStorage;

class SSHConf
{
    /** @var array $config */
    private $config;
    /** @var SplFileObject $file */
    private $file;
    /** @var SplObjectStorage $content */
    private $content;

    public function __construct($filepath)
    {
        $this->content = new SplObjectStorage();
        $this->load($filepath)->parse();
    }

    private function load($filepath): self
    {
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $filepath));
        }

        $this->file = new SplFileObject($filepath, 'r+');

        return $this;
    }

    public function parse(): self
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
            while ($this->content->valid()) $this->content->next();
        }
        return $this;
    }

    public function host(string $name): ?SSHConfHost
    {
        foreach ($this->content as $line) {
            if ($line instanceof SSHConfHost) {
                /** @var SSHConfHost $line */
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
