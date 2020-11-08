<?php

namespace m4rku5\SSHConf;

class SSHConfLine
{
    /** @var string $line */
    private $line;
    /** @var string $key */
    private $key;
    /** @var string $value */
    private $value;
    /** @var boolean $comment */
    private $comment;

    public function __construct($line)
    {
        $this->line = $line;
        $this->parse();
    }

    public function parse()
    {
        if (preg_match('/^(#?)\s*([^\s]*)\s+(.*)\s*$/', $this->line, $matches) === false) {
            throw new \RuntimeException('could not parse line: ' . $this);
        }
    }

    public function __toString(): string
    {
        return $this->line;
    }
}
