<?php

namespace App\EmailGenerationLanguage\Tokenizer;

class StringToken extends Token
{
    private $delimiterChar;
    private $escapeChar = '\\';
    private $escaping;
    private $value      = '';

    public function __construct($delimiterChar)
    {
        $this->delimiterChar = $delimiterChar;
        $this->escaping      = false;
    }

    public function add($char)
    {
        if ($this->escaping) {
            $this->value    .= match ($char) {
                $this->delimiterChar => $char,
                'n' => "\n",
                $this->escapeChar => $this->escapeChar,
                default => throw new \Exception("Only \\, \n and \' or \" escape sequences are allowed in a string"),
            };
            $this->escaping = false;

            return true;
        }

        if ($char === $this->delimiterChar) {
            return false;
        }

        if ($char === $this->escapeChar) {
            $this->escaping = true;

            return true;
        }
    }

    public function getValue()
    {
        return $this->value;
    }
}
