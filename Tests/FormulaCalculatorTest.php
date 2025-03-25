<?php

namespace App\ExcelFormulaBundle\Tests;

use App\ExcelFormulaBundle\Service\FormulaCalculator;
use PHPUnit\Framework\TestCase;

class FormulaCalculatorTest extends TestCase
{
    private $calculator;

    // Initialisation de la classe FormulaCalculator avant chaque test
    protected function setUp(): void
    {
        $this->calculator = new FormulaCalculator();
    }

    // Test pour la fonction moyenne
    public function testCalculateMoyenne()
    {
        $result = $this->calculator->calculate('moyenne(1,2,3,4)');
        $this->assertEquals(2.5, $result);
    }

    // Test pour la fonction somme
    public function testCalculateSomme()
    {
        $result = $this->calculator->calculate('somme(1,2,3)');
        $this->assertEquals(6, $result);
    }

    // Test pour la fonction produit
    public function testCalculateProduit()
    {
        $result = $this->calculator->calculate('produit(1,2,3)');
        $this->assertEquals(6, $result);
    }

    // Test pour la fonction max
    public function testCalculateMax()
    {
        $result = $this->calculator->calculate('max(1,2,3)');
        $this->assertEquals(3, $result);
    }

    // Test pour la fonction min
    public function testCalculateMin()
    {
        $result = $this->calculator->calculate('min(1,2,3)');
        $this->assertEquals(1, $result);
    }

    // Test pour la fonction arrondi
    public function testCalculateArrondi()
    {
        $result = $this->calculator->calculate('arrondi(1.234, 2)');
        $this->assertEquals(1.23, $result);
    }

    // Test pour la fonction puissance
    public function testCalculatePuissance()
    {
        $result = $this->calculator->calculate('puissance(2, 3)');
        $this->assertEquals(8, $result);
    }

    // Test pour la fonction concat
    public function testCalculateConcat()
    {
        $result = $this->calculator->calculate('concat(Hello,World)');
        $this->assertEquals('HelloWorld', $result);
    }

    // Test pour la fonction gauche
    public function testCalculateGauche()
    {
        $result = $this->calculator->calculate('gauche(Hello, 3)');
        $this->assertEquals('Hel', $result);
    }

    // Test pour la fonction droite
    public function testCalculateDroite()
    {
        $result = $this->calculator->calculate('droite(Hello, 3)');
        $this->assertEquals('llo', $result);
    }

    // Test pour la fonction date_ajoute
    public function testCalculateDateAjoute()
    {
        $result = $this->calculator->calculate('date_ajoute(2025-03-25, 10)');
        $this->assertEquals('2025-04-04', $result);
    }

    // Test pour la fonction datedif
    public function testCalculateDateDif()
    {
        $result = $this->calculator->calculate('datedif(2025-03-25, 2025-04-05)');
        $this->assertEquals(11, $result);
    }

    // Test pour la fonction si (condition vraie)
    public function testCalculateSiTrueCondition()
    {
        $result = $this->calculator->calculate('si(2>1, vrai, faux)');
        $this->assertEquals('vrai', $result);
    }

    // Test pour la fonction si (condition fausse)
    public function testCalculateSiFalseCondition()
    {
        $result = $this->calculator->calculate('si(1>2, vrai, faux)');
        $this->assertEquals('faux', $result);
    }

    // Test pour la fonction log
    public function testCalculateLog()
    {
        $result = $this->calculator->calculate('log(10, 10)');
        $this->assertEquals(1, $result);
    }

    // Test pour la fonction exp
    public function testCalculateExp()
    {
        $result = $this->calculator->calculate('exp(1)');
        $this->assertEquals(exp(1), $result);
    }

    // Test pour la fonction sin
    public function testCalculateSin()
    {
        $result = $this->calculator->calculate('sin(0)');
        $this->assertEquals(0, $result);
    }

    // Test pour la fonction cos
    public function testCalculateCos()
    {
        $result = $this->calculator->calculate('cos(0)');
        $this->assertEquals(1, $result);
    }

    // Test pour la fonction tan
    public function testCalculateTan()
    {
        $result = $this->calculator->calculate('tan(0)');
        $this->assertEquals(0, $result);
    }

    // Test pour la fonction pi
    public function testCalculatePi()
    {
        $result = $this->calculator->calculate('pi()');
        $this->assertEquals(M_PI, $result);
    }

    // Test pour une fonction avec des arguments invalides
    public function testInvalidFormula()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->calculate('inconnue(1,2)');
    }

    // Test pour une fonction avec un mauvais format de paramètre
    public function testInvalidArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->calculate('arrondi(1.234, abc)');
    }

    // Test pour une fonction log avec un argument négatif
    public function testInvalidLog()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->calculate('log(-10)');
    }

    // Test pour la fonction si avec un mauvais nombre d'arguments
    public function testInvalidSiArguments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->calculate('si(1>2)');
    }

    // Test pour la fonction tan avec un angle de 90 (cas de division par 0)
    public function testInvalidTan()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->calculate('tan(90)');
    }
}