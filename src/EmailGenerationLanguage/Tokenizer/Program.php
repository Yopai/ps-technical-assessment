<?php

namespace App\EmailGenerationLanguage\Tokenizer;

class Program
{
    const TOKEN_EOL         = "\n";
    const TOKEN_EOF         = '##EOF##';
    const NEXT_CHAR_UNSHIFT = 'unshift';

    const CHAR_STRING_DELIMITER = "'";

    private        $chars;
    private ?Token $token = null;

    public function __construct($str)
    {
        $this->chars = mb_str_split($str, 1, 'UTF-8');
    }

    public function nextToken()
    {
        $this->token = null;

        $readNextChar = true;
        while ($readNextChar) {
            //echo 'readNextChar = '.var_export($readNextChar, true)."\n";
            $char = $this->nextChar();
            if (is_null($char)) {
                if (is_null($this->token)) {
                    return null;
                }
                break;
            }

            if ($this->token) {
                //echo '  continueToken'."\n";
                $readNextChar = $this->continueToken($char);
            } else {
                //echo '  startToken chr #'.ord($char)."\n";
                $readNextChar = $this->startToken($char);
                //echo '  result = '.var_export($readNextChar, true)."\n";
            }

            if ($readNextChar === self::NEXT_CHAR_UNSHIFT) {
                $this->unpopChar($char);
                $readNextChar = false;
            }
        }

        return $this->token;
    }

    private function nextChar()
    {
        if ( ! $this->chars) {
            return null;
        }

        return array_shift($this->chars);
    }

    private function unpopChar($char)
    {
        array_unshift($this->chars, $char);
    }

    /**
     * Let the token decide if it must consume the
     *
     * @param $char
     *
     * @return bool|string
     */
    private function continueToken($char)
    {
        return $this->token->add($char);
    }

    private function startToken($char)
    {
        if ($this->isSpaceChar($char)) {
            # just ignore and continue
            return true;
        }

        if ($char === self::CHAR_STRING_DELIMITER) {
            $this->token = new StringToken($char);

            return true;
        }

        # TODO : should be a factory
        if ($char === "\n" || $char === ';') {
            $this->token = new KeywordToken(self::TOKEN_EOL);

            return false;
        }

        if ($this->isOperatorChar($char)) {
            $this->token = new OperatorToken($char);

            return true;
        }

        if ($char === '-' || ($char >= '0' && $char <= '9')) {
            $this->token = new IntegerToken($char);

            return true;
        }

        if ($char === '_'
            || ($char >= 'a' && $char <= 'z')
            || ($char >= 'A' && $char <= 'Z')
        ) {
            $this->token = new IdentifierToken($char);

            return true;
        }


        throw new \Exception('Unexpected ' . $char);
    }

    private function isSpaceChar($char)
    {
        return in_array($char, [" ", "\t"], true);
    }

    private function isOperatorChar($char)
    {
        return OperatorToken::isValidFirstChar($char);
    }
}
