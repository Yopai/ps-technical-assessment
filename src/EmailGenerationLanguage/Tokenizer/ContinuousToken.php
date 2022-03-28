<?php

namespace App\EmailGenerationLanguage\Tokenizer;

/**
 * Consumes chars while they're valid for this token
 * Reject at the first non valid character encountered
 */
abstract class ContinuousToken extends Token
{
    private $value = '';

    public function __construct($char)
    {
        $this->value = $char;
    }

    public function add($char)
    {
        if ($this->isValidChar($char)) {
            $this->value .= $char;

            return true;
        }

        return Program::NEXT_CHAR_UNSHIFT;
    }

    public function getValue()
    {
        return $this->value;
    }

    abstract protected function isValidChar($char);
}
