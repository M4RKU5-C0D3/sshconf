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
        $this->line = trim($line, "\n\r");
        $this->parse();
    }

    private function parse(): self
    {
        if (empty($this->line)) return $this;
        if (preg_match('/^(#?)(\s*[^\s]*)\s+(.*)\s*$/', $this->line, $matches) === false) {
            throw new \RuntimeException('could not parse line: ' . $this);
        }
        $this->comment = ($matches[1] == '#');
        if ($this->comment) {
            $this->value = trim($matches[2] . $matches[3]);
        } else {
            $this->key = trim($matches[2]);
            $this->value = trim($matches[3]);
        }
        return $this;
    }

    public function key(string $key = null)
    {
        if ($key === null) {
            return $this->key;
        } else {
            str_replace($this->key, $key, $this->line);
            $this->parse();
        }
    }

    public function value(string $value = null)
    {
        if ($value === null) {
            return $this->value;
        } else {
            str_replace($this->value, $value, $this->line);
            $this->parse();
        }
    }

    public function comment(bool $comment = null)
    {
        if ($comment === null) {
            return $this->comment;
        } else {
            //  TODO@MM: implement...
            $this->parse();
        }
    }

    public function __toString(): string
    {
        return $this->line;
    }
}
