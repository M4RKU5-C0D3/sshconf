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
        foreach ($this->file as $line) {
            $this->content->attach(new SSHConfLine($line));
        }
        return $this;
    }

    public function get(): SplObjectStorage
    {
        return $this->content;
    }
}
