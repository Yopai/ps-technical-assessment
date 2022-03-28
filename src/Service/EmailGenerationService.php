<?php

namespace App\Service;

use App\EmailGenerationLanguage\Interpreter;
class EmailGenerationService
{
    private Interpreter $interpreter;

    public function __construct()
    {
        $this->interpreter = new Interpreter();
    }

    /**
     * @param string   $expression
     * @param string[] $inputs
     *
     * @return string
     */
    public function evaluate(string $expression, array $inputs)
    {
        return implode('', iterator_to_array($this->interpreter->evaluate($expression, $inputs)));
    }
}
