<?php

namespace App\ExcelFormulaBundle\Controller;

use App\ExcelFormulaBundle\Service\FormulaCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class FormulaController extends AbstractController
{
    private FormulaCalculator $formulaCalculator;

    public function __construct(FormulaCalculator $formulaCalculator)
    {
        $this->formulaCalculator = $formulaCalculator;
    }

    #[Route('/formula/calculate', name: 'excel_formula_calculate', methods: ['POST'])]
    public function calculate(Request $request): JsonResponse
    {
        // Décoder les données JSON envoyées par le frontend
        $data = json_decode($request->getContent(), true);

        // Vérifier si les données sont bien reçues
        if (null === $data || !isset($data['formula'])) {
            return new JsonResponse(['error' => 'Aucune formule fournie'], 400);
        }

      // Récupérer la formule
      $formula = $data['formula'];

      try {
          // Appeler la méthode de calcul via le service FormulaCalculator
          $result = $this->formulaCalculator->calculate($formula);
          return new JsonResponse(['result' => $result]);
      } catch (\InvalidArgumentException $e) {
          return new JsonResponse(['error' => $e->getMessage()], 400);
      } catch (\Exception $e) {
          return new JsonResponse(['error' => 'Erreur interne: ' . $e->getMessage()], 500);
      }
   }
}