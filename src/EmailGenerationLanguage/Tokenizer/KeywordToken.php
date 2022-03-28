<?php

namespace App\EmailGenerationLanguage\Tokenizer;

class KeywordToken extends Token
{
    private $value = '';

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
