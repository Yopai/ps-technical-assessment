<?php

namespace App\EmailGenerationLanguage;

use App\EmailGenerationLanguage\Tokenizer\IdentifierToken;
use App\EmailGenerationLanguage\Tokenizer\OperatorToken;
use App\EmailGenerationLanguage\Tokenizer\Program;
use App\EmailGenerationLanguage\Tokenizer\Token;

class Expression
{
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getValue()
    {
        return $this->token->getValue();
    }
}

class Interpreter
{
    private ?Program $program;
    private ?Token   $previouslyReadToken;

    public function evaluate($programString, $inputs)
    {
        $this->program = new Program($programString);
        /* returns the list of all tokens - only for test */
        while ($token = $this->program->nextToken()) {
            yield str_pad(str_replace("\n", '\n', $token->getValue()), 20)." [".get_class($token)."]\n";
        }

        /*
        $this->previouslyReadToken = null;
        while ($expression = $this->getNextExpression()) {
            $output = $expression->evaluate($inputs);
            if ( ! is_null($output)) {
                yield $output;
            };
        }
        */
    }

    public function getNextExpression($inputs)
    {
        $token = $this->nextToken();
        if ( ! $token) {
            return null;
        }

        $expression = new Expression;

        return $this->handleToken($token);
    }

    private function handleToken(Token $token)
    {
        if ($token instanceof IdentifierToken) {

            if ($this->isKeyword($token->getValue())) {
                return $this->handleKeyword($token);
            }

            return new IdentifierExpression($token->getValue());
        } elseif ($token instanceof OperatorToken) {
            return $this->handleKeyword($token);
        }
        throw new \Exception('Unexpected ' . get_class($token) . ' token');
    }

    private function nextToken()
    {
        if ($this->previouslyReadToken) {
            $result                    = $this->previouslyReadToken;
            $this->previouslyReadToken = null;

            return $result;
        }

        return $this->program->nextToken();
    }

    private function unreadToken($token)
    {
        $this->previouslyReadToken = $token;
    }

    private function isKeyword(string $identifier)
    {
        static $keywords = ['foreach'];

        return in_array(strtolower($identifier), $keywords);
    }
}
