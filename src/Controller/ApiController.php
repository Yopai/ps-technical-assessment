<?php

namespace App\Controller;

use App\Service\EmailGenerationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/')]
class ApiController extends AbstractController
{
    #[Route('generate-email')]
    public function generateEmail(EmailGenerationService $service, Request $request)
    {
        $inputs     = $request->request->all();
        $expression = $request->request->get('expression');
        $email      = $service->evaluate($expression, $inputs);

        return new JsonResponse(['data' => ['id' => $email, 'value' => $email]]);
    }

    #[Route('test')]
    public function test(EmailGenerationService $service, Request $request)
    {
        $result = '';
        header('Content-Type: text/plain');
        foreach ($this->getTests() as $name => $testData) {
            $inputs     = $testData->input;
            $expression = $testData->expression;
            $email      = $service->evaluate($expression, $inputs);
            $result .= $testData->expected;
            if ($email === $testData->expected) {
                $result .= "[OK]\n";
            }
            else {
                $result = "[KO : $email]\n";
            }
        }
        return new Response('Result : ' . $result);
    }

    private function getTests()
    {
        yield (object)[
            'input'      => [
                'input1' => 'Jean-Louis',
                'input2' => 'Jean-Charles Mignard',
                'input3' => 'external',
                'input4' => 'peoplespheres.fr',
                'input5' => 'fr',
            ],
            'expression' => "
                foreach word in input1:words
                    word:chars:1
                next
                '.'
                input2:words:-1:chars:1
                '@'
                input3
                '.'
                input4
                '.'
                input5
            ",
            'expected' => 'jl.jccharlesmignard@external.peoplespheres.fr'
        ];
    }

}
