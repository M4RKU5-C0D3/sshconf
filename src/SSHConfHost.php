<?php

namespace m4rku5\SSHConf;

class SSHConfHost
{
    /** @var string[] $lines */
    private $lines;
    /** @var string $key */
    private $name;
    /** @var boolean $comment */
    private $comment;

    public function __construct(array $lines)
    {
        $this->lines = $lines;
        $this->parse();
    }

    public function parse()
    {
        // TODO@MM: implement...
    }

    public function __toString(): string
    {
        return implode('', $this->lines);
    }
}
