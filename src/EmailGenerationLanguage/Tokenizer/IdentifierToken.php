<?php

namespace App\EmailGenerationLanguage\Tokenizer;

class IdentifierToken extends ContinuousToken
{
    const RESERVED_FOREACH = 'foreach';
    const RESERVED_IN      = 'in';

    protected function isValidChar($char)
    {
        return ($char === '_')
               || ($char >= 'a' && $char <= 'z')
               || ($char >= 'A' && $char <= 'Z')
               || ($char >= '0' && $char <= '9');
    }
}
