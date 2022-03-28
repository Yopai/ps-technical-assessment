<?php

namespace App\EmailGenerationLanguage;

use Parser\IdentifierToken;
use Parser\OperatorToken;
use Parser\Token;

class Evaluation
{
    const STATE_NONE = 0;

    private          $current = null;
    /** @var string[] */
    private array $inputs;
    private          $state   = self::STATE_NONE;

    public function __construct($inputs)
    {
        $this->inputs = $inputs;
    }

    public function add($token)
    {
        if ($token instanceof IdentifierToken) {
            $this->addIdentifier($token);
        }
        elseif ($token instanceof OperatorToken) {
            $this->operator = $token->getValue();
        }
    }

    private function getInput($name)
    {
        if (!isset($this->inputs[$name])) {
            throw new \RuntimeException('Unknown identifier '.$name);
        }

        return $this->inputs[$name];
    }

    private function addIdentifier(Token $token) {
        $identifier = $token->getValue();
        if ($this->current) {
            if (!$this->operator) {
                throw new \RuntimeException('Unexpected identifier '.$identifier);
            }
        }

        $this->current = $this->getInput($token->getValue());
        $this->operator = null;
    }

    private function drill($current, $identifier)
    {
    }
}
