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

    public function __construct(SSHConfLine $line)
    {
        $this->attach($line);
        $this->name = $line->value();
        $this->comment = $line->comment();
    }

    public function attach(SSHConfLine $line)
    {
        $this->lines[] = $line;
    }

    public function name(string $name = null)
    {
        if ($name === null) {
            return $this->name;
        } else {
            // TODO@MM: implement...
        }
    }

    public function __toString(): string
    {
        return implode('', $this->lines);
    }
}
