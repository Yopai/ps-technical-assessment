<?php

namespace App\EmailGenerationLanguage\Tokenizer;

class AllowedCharsToken extends ContinuousToken
{
    private $allowedChars;

    public function __construct($char, $allowedChars)
    {
        $this->allowedChars = $allowedChars;
        parent::__construct($char);
    }

    protected function isValidChar($char)
    {
        return in_array($char, $this->allowedChars, true);
    }
}
