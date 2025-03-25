<?php

namespace App\ExcelFormulaBundle\Tests;

use App\ExcelFormulaBundle\Controller\FormulaController;
use App\ExcelFormulaBundle\Service\FormulaCalculator;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class FormulaControllerTest extends TestCase
{
    private FormulaController $controller;
    private FormulaCalculator&MockObject $formulaCalculator; // Spécifier le bon type

    protected function setUp(): void
    {
        // Créer un mock de FormulaCalculator
        $this->formulaCalculator = $this->createMock(FormulaCalculator::class);
        
        // Injecter le mock dans le contrôleur
        $this->controller = new FormulaController($this->formulaCalculator);
    }

    public function testCalculateValidFormula(): void
    {
        // Simuler un calcul valide
        $this->formulaCalculator->method('calculate')
            ->with('2+2')
            ->willReturn(4);

        // Requête simulée avec une formule
        $request = new Request([], [], [], [], [], [], json_encode(['formula' => '2+2']));

        // Exécution de la méthode du contrôleur
        $response = $this->controller->calculate($request);

        // Vérification du statut et du contenu JSON
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode(['result' => 4]), $response->getContent());
    }
}