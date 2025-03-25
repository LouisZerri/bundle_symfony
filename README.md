# ExcelFormulaBundle 📊📈⚙️

## Introduction 🌟

Bienvenue dans **ExcelFormulaBundle** ! Ce bundle Symfony offre un ensemble puissant de fonctions pour calculer des formules mathématiques et textuelles, similaires à celles d'Excel. Il prend en charge diverses opérations mathématiques, manipulations de chaînes, calculs de dates et fonctions logiques. Que vous travailliez avec des nombres, des chaînes de texte ou des dates, ce bundle rend le calcul des formules facile et intuitif.

## Installation 🚀

Pour installer le **ExcelFormulaBundle** dans votre projet Symfony, suivez les étapes ci-dessous :

1. **Récupérer le bundle dans le depot git :**
    Placez-vous dans le dossier /src de votre projet Symfony et ouvrez-le dans un terminal. Exécutez la commande suivante pour installer le bundle :
    ```bash
    git clone https://github.com/bundle_symfony/excel-formula-bundle.git
    
2. **Activer le bundle :** 
    Symfony détecte automatiquement le bundle, mais si nécessaire, vous pouvez l'activer manuellement dans le fichier config/bundles.php :
    ```php
    return [
        // Autres bundles...
        App\ExcelFormulaBundle\ExcelFormulaBundle::class => ['all' => true],
    ];
3. **Configuration des routes au sein du bundle :**
    Ajouter cette ligne dans config/routes.yaml du projet Symfony pour qu'il prenne en compte les routes du bundle
    ```yaml
    excel_formula_bundle:
        resource: "@ExcelFormulaBundle/Resources/config/routes.yaml"
        prefix: /
4. **Configuration de twig pour enregistrer le chemin du template du bundle**
    Ajouter cette ligne dans config/packages/twig.yaml du projet Symfony pour qu'il prenne en compte les templates du bundle
    ```yaml
    paths:
        '%kernel.project_dir%/src/ExcelFormulaBundle/Resources/views': ExcelFormulaBundle

## Utilisation 📈

Une fois le bundle installé, vous pouvez l'utiliser dans votre projet Symfony. Voici les étapes pour commencer :

1. **Injection du template twig du bundle dans une vue du projet Symfony**
    Le bundle correspond à une colonne formule ou vous pouvez saisir dynamiquement des formules au seins de l'input et après avoir appuyez sur la touche entré, il calcul et change en remplaçant par la valeur avec la formule qui a été utilisée. Voici donc comment inclure la colonne dans une vue twig d'un projet Symfony :
    ```twig
    {% extends 'base.html.twig' %}
    {% block body %}
        {% include '@ExcelFormulaBundle/show.html.twig' %}
    {% endblock %}

2. **Les formules prises en charge**
    Le bundle prend en charge plusieurs formules, telles que :
    * `MOYENNE` (Moyenne)
    * `SUM` (Somme)
    * `PRODUCT` (Produit)
    * `MAX` (Maximum)
    * `MIN` (Minimum)
    * `MIN` (Minimum)
    * `ARRONDI` (Arrondir)
    * `PUISSANCE` (Puissance)
    * `CONCAT` (Concaténation)
    * `GAUCHE` (STXT vers la gauche)
    * `DROITE` (STXT vers la droite)
    * `DATE_AJOUT` (Ajoute des jours à une date)
    * `DATEDIF` (Diffèrence de jours entre deux dates)
    * `SI` (Condition SI)
    * `EXP` (Fonction exponentielle)
    * `LOG` (Fonction logarithme)
    * `COS` (Fonction cosinus)
    * `SIN` (Fonction sinus)
    * `TAN` (Fonction tangente)
    * `PI` (π)

## Exemple de resultat 🧑‍💻

Si vous tapez dans l'input :
```bash
moyenne(1,2,3,4,5)
```
Alors vous devriez avoir le resultat suivant : 
```bash
3
```

## Lancer les Tests 🧪

Le **ExcelFormulaBundle** inclut un ensemble de tests unitaires pour vérifier le bon fonctionnement des différentes fonctions. Pour exécuter les tests, suivez les instructions ci-dessous :

1. **Installer PHPUnit** : Si PHPUnit n'est pas déjà installé dans votre projet, vous pouvez l'installer en utilisant la commande suivante :
```bash
composer require --dev phpunit/phpunit
```

2. **Exécuter les tests** : Une fois PHPUnit installé, vous pouvez lancer les tests avec la commande suivante :
```bash
php bin/phpunit src/ExcelFormulaBundle/Tests
```

3. **Résultat des tests** : PHPUnit exécutera les tests et affichera les résultats dans le terminal. Si tous les tests passent, vous verrez un message indiquant leur succès. En cas d'échec de certains tests, les messages d'erreur correspondants seront affichés


## Dépendances ⚙️

Le **ExcelFormulaBundle** requiert :
    * Symfony `>= 7.0`
    * PHP `>= 8.0`
    * Composer pour la gestion des dépendances

## Contribuer 👨‍💻

Les contributions au **ExcelFormulaBundle** sont les bienvenues ! Si vous trouvez un bug ou souhaitez ajouter de nouvelles fonctionnalités, n'hésitez pas à forker le dépôt et à soumettre une pull request. Assurez-vous de passer tous les tests avant de soumettre vos modifications.

**Étapes pour contribuer**
1. Forkez le dépôt.

2. Créez une nouvelle branche pour votre fonctionnalité ou correction de bug.

3. Implémentez vos modifications.

4. Exécutez les tests et assurez-vous qu'ils passent.

5. Soumettez une pull request avec une description détaillée de vos changements.

## Conclusion 🎯🎉🚀

Ce bundle facilite le calcul dynamique des formules en offrant une interface simple et intuitive. 💪 Happy coding !
