<?php

namespace App\ExcelFormulaBundle\Service;

class FormulaCalculator
{
    /**
     * Tableau des fonctions de calcul
     * Chaque fonction est mappée à son nom et son calcul
     */
    private $functions = [
        'moyenne' => 'calculateMoyenne',
        'somme' => 'calculateSomme',
        'produit' => 'calculateProduit',
        'max' => 'calculateMax',
        'min' => 'calculateMin',
        'arrondi' => 'calculateArrondi',
        'puissance' => 'calculatePuissance',
        'concat' => 'calculateConcat',
        'gauche' => 'calculateGauche',
        'droite' => 'calculateDroite',
        'date_ajoute' => 'calculateDateAjoute',
        'datedif' => 'calculateDateDif',
        'si' => 'calculateSi',
        'log' => 'calculateLog',
        'exp' => 'calculateExp',
        'sin' => 'calculateSin',
        'cos' => 'calculateCos',
        'tan' => 'calculateTan',
        'pi' => 'calculatePi'
    ];

    /**
     * Fonction principale pour effectuer un calcul en fonction de la formule donnée
     * Recherche la fonction correspondante dans la formule et exécute le calcul approprié
     */
    public function calculate(string $formula)
    {
        // Recherche la fonction dans la formule et récupère les arguments
        foreach ($this->functions as $functionName => $method) {
            if (preg_match('/' . $functionName . '\((.*)\)/', $formula, $matches)) {
                $args = $matches[1];
                return $this->$method($args);
            }
        }

        throw new \InvalidArgumentException('Formule inconnue ou mal formée');
    }

    /**
     * Fonction qui extrait les arguments d'une fonction à partir de la chaîne de caractères
     */
    private function extractArguments($args)
    {
        // Séparer les arguments par des virgules et nettoyer les espaces
        return array_map('trim', explode(',', $args));
    }

    /**
     * Fonction qui valide que tous les arguments sont des nombres
     */
    private function validateNumericArguments($args)
    {
        // Vérifier que tous les arguments sont des numéros
        foreach ($args as $arg) {
            if (!is_numeric($arg)) {
                throw new \InvalidArgumentException("Tous les arguments doivent être des chiffres");
            }
        }
        return array_map('floatval', $args); // Convertir en flottants
    }

    /**
     * Fonction qui calcul la moyenne d'une liste de nombre
     */
    private function calculateMoyenne($args)
    {
        $args = $this->extractArguments($args);
        $numbers = $this->validateNumericArguments($args);
        return array_sum($numbers) / count($numbers);
    }

    /**
     * Fonction qui calcul la somme d'une liste de nombre
     */
    private function calculateSomme($args)
    {
        $args = $this->extractArguments($args);
        $numbers = $this->validateNumericArguments($args);
        return array_sum($numbers);
    }

    /**
     * Fonction qui calcul le prduit d'une liste de nombre
     */
    private function calculateProduit($args)
    {
        $args = $this->extractArguments($args);
        $numbers = $this->validateNumericArguments($args);
        return array_product($numbers);
    }

    /**
     * Fonction qui trouve la valeur maximale parmi les arguments numériques
     */
    private function calculateMax($args)
    {
        $args = $this->extractArguments($args);
        $numbers = $this->validateNumericArguments($args);
        return max($numbers);
    }

    /**
     * Fonction qui trouve la valeur minimale parmi les arguments numériques
     */
    private function calculateMin($args)
    {
        $args = $this->extractArguments($args);
        $numbers = $this->validateNumericArguments($args);
        return min($numbers);
    }

    /**
     * Fonction qui arrondi un nombre avec une precision donnée
     */
    private function calculateArrondi($args)
    {
        $args = $this->extractArguments($args);
        $number = str_replace(',', '.', $args[0]); // Remplacer la virgule par un point pour la décimale

        if (!is_numeric($number)) {
            throw new \InvalidArgumentException('La première valeur doit être un nombre valide');
        }

        $number = floatval($number);
        
        // Vérifier si le second argument est bien un entier valide
        if (!isset($args[1]) || !ctype_digit($args[1])) {
            throw new \InvalidArgumentException('La précision doit être un nombre entier positif');
        }

        $precision = intval($args[1]);

        return round($number, $precision);
    }

    /**
     * Fonction qui calcul la puissanc d'un nombre en fonction de son exposant
     */
    private function calculatePuissance($args)
    {
        $args = $this->extractArguments($args);
        if (count($args) !== 2) {
            throw new \InvalidArgumentException("Vous devez entrer exactement deux valeurs (base, exposant)");
        }

        $base = floatval($args[0]);
        $exponent = floatval($args[1]);

        return pow($base, $exponent);
    }

    /**
     * Fonction qui concatène plusieurs chaîne de caractères
     */
    private function calculateConcat($args)
    {
        $args = $this->extractArguments($args);

        // S'assurer que tous les arguments sont des chaînes
        foreach ($args as $string) {
            if (is_numeric($string)) {
                throw new \InvalidArgumentException("Les arguments doivent être des chaînes de caractères, pas des chiffres");
            }
        }

        return implode('', $args);
    }

    /**
     * Fonction qui extrait les caractères à gauche d'une chaîne
     */
    private function calculateGauche($args)
    {
        return $this->calculateSubstring($args, 'left');
    }

    /**
     * Fonction qui extrait les caractères à droite d'une chaîne
     */
    private function calculateDroite($args)
    {
        return $this->calculateSubstring($args, 'right');
    }

    /**
     * Fonction qui extrait une sous-chaîne d'une chaîne donnée (gauche ou droite)
     */
    private function calculateSubstring($args, $side)
    {
        $args = $this->extractArguments($args);

        if (count($args) !== 2) {
            throw new \InvalidArgumentException("Vous devez entrer exactement deux valeurs (chaîne et longueur)");
        }

        $string = $args[0];
        $length = intval($args[1]);

        if (empty($string)) {
            throw new \InvalidArgumentException("La chaîne ne peut pas être vide");
        }

        if ($length < 0) {
            throw new \InvalidArgumentException("La longueur doit être un nombre entier positif");
        }

        if ($length > strlen($string)) {
            throw new \InvalidArgumentException("La longueur demandée est supérieure à la longueur de la chaîne");
        }

        return $side === 'left' ? substr($string, 0, $length) : substr($string, -$length);
    }

    /**
     * Fonction qui ajoute un nombre de jour à une date
     */
    private function calculateDateAjoute($args)
    {
        $args = $this->extractArguments($args);
        $date = trim($args[0]);
        $daysToAdd = (int)trim($args[1]);

        if (strtotime($date) === false) {
            throw new \InvalidArgumentException('La date fournie est invalide');
        }

        return date('Y-m-d', strtotime("$date +$daysToAdd days"));
    }

    /**
     * Fonction qui calcul la diffèrence en jours entre deux dates
     */
    private function calculateDateDif($args)
    {
        $args = $this->extractArguments($args);
        $startDate = trim($args[0]);
        $endDate = trim($args[1]);

        if (strtotime($startDate) === false || strtotime($endDate) === false) {
            throw new \InvalidArgumentException('Les dates fournies sont invalides');
        }

        return (strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24);
    }

    /**
     * Fonction qui évalue une condition logique et retourne une valeur en fonction du résultat
     */
    private function calculateSi($args)
    {
        $args = $this->extractArguments($args);
        if (count($args) < 3) {
            throw new \InvalidArgumentException('Nombre d\'arguments insuffisant pour la fonction SI');
        }

        $condition = trim($args[0]);
        $trueValue = trim($args[1]);
        $falseValue = trim($args[2]);

        return $this->evaluateCondition($condition) ? $trueValue : $falseValue;
    }

    /**
     * Fonction qui évalue la condition d'un test logique sous forme de chaîne
     */
    private function evaluateCondition(string $condition): bool
    {
        return preg_match('/(\d+)([<>=!]+)(\d+)/', $condition, $matches) &&
            version_compare($matches[1], $matches[3], $matches[2]);
    }

    /**
     * Fonction qui calcul le logarithme d'un nombre selon une base donnée
     */
    private function calculateLog($args)
    {
        $args = $this->extractArguments($args);
        $number = floatval($args[0]);
        $base = floatval($args[1] ?? M_E);

        if ($number <= 0) {
            throw new \InvalidArgumentException('Le nombre pour le logarithme doit être strictement positif');
        }

        if ($base <= 0 || $base == 1) {
            throw new \InvalidArgumentException('La base du logarithme doit être strictement positive et différente de 1');
        }

        return log($number, $base);
    }

    /**
     * Fonction qui calcul l'exponentielle d'un nombre
     */
    private function calculateExp($args)
    {
        return exp(floatval(trim($args[0])));
    }

    /**
     * Fonction qui calcul le sinus d'un angle
     */
    private function calculateSin($args)
    {
        return sin(floatval(trim($args[0])));
    }

    /**
     * Fonction qui calcul le cosinus d'un angle
     */
    private function calculateCos($args)
    {
        return cos(floatval(trim($args[0])));
    }

    /**
     * Fonction qui calcul la tangente d'un angle
     */
    private function calculateTan($args)
    {
       // Convertir en radians si nécessaire
        $radians = deg2rad($args);

        // Vérifier si l'angle est proche d'un multiple impair de π/2
        if (abs(cos($radians)) < 1e-10) {
            throw new \InvalidArgumentException("La tangente est indéfinie pour cet angle : $args degrés");
        }

        return tan($radians);
    }

    /**
     * Fonction qui retourne la valeur approximative de π
     */
    private function calculatePi($args = [])
    {
         // Vérifier si un argument a été passé, ce qui n'est pas permis pour cette fonction
        if (!empty($args)) {
            throw new \InvalidArgumentException("La fonction π ne prend aucun argument");
        }

        // Retourner la constante π
        return M_PI;
    }
}
