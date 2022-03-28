<?php

namespace App\EmailGenerationLanguage\Tokenizer;

class OperatorToken extends ContinuousToken
{
    const OPERATOR_RANGE = '..';
    const OPERATOR_PIPE  = ':';
    private static $operators = [
        '(',
        ')',
        ':',
        '..',
    ];

    public function isValidChar($char)
    {
        foreach (self::$operators as $operator) {
            if (str_starts_with($operator, $this->getValue() . $char)) {
                return true;
            }
        }

        return false;
    }

    public static function isValidFirstChar($char)
    {
        foreach (self::$operators as $operator) {
            if (str_starts_with($operator, $char)) {
                return true;
            }
        }

        return false;
    }
}
