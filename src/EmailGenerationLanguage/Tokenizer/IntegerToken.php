<?php

namespace App\EmailGenerationLanguage\Tokenizer;

class IntegerToken extends ContinuousToken
{
    protected function isValidChar($char)
    {
        return ($char >= '0' && $char <= '9');
    }
}
