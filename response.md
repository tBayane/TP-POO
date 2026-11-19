# TP 4 – Programmation Orientée Objet en PHP
## Fichier des réponses – reponses.md

---

# Partie 0 – La première classe

### 0.1
On crée un deuxième objet `$v2` de la classe `Voiture`, puis on lui donne la marque Renault :

```php
$v2 = new Voiture();
$v2->setMarque("Renault");
$v2->afficher();
```

### 0.2
On ajoute une propriété `$couleur`, une méthode `setCouleur()` pour modifier sa valeur, puis on modifie `afficher()` pour afficher la marque et la couleur.

### 0.3
Non, `$v1` et `$v2` ne partagent pas la même valeur de `$marque`. Chaque objet possède ses propres attributs. Modifier la marque de `$v1` ne modifie donc pas celle de `$v2`.

---

# Partie 1 – Visibilité et encapsulation

### 1.1
La propriété `nom` est publique, donc elle est accessible depuis l'extérieur de la classe.

Les propriétés `cin` et `dateNaissance` sont privées : leur accès direct depuis l'extérieur provoque une erreur.

La méthode `getAge()` est également privée. On ne peut donc pas l'appeler directement depuis l'extérieur de la classe.

### 1.2
Il serait dangereux de laisser `cin` en public car n'importe quelle partie du programme pourrait lire ou modifier cette information personnelle. Il est préférable de protéger cette donnée avec la visibilité `private`.

### 1.3
Non, `getAge()` n'est pas inutile. Une méthode privée peut être appelée par les autres méthodes de la même classe. Par exemple, `__toString()` peut utiliser `getAge()` pour afficher l'âge de la personne.

### 1.4
Non, le comportement depuis l'extérieur ne change pas. Une propriété `protected` reste inaccessible directement depuis l'extérieur de la classe. Elle est cependant accessible dans la classe elle-même et dans ses classes filles.

---

# Partie 2 – Constructeurs et destructeur

### 2.1.a
- `new Voiture("Noire")` : la couleur est initialisée à "Noire" et la vitesse prend sa valeur par défaut, qui est 0.
- `new Voiture(120)` : le premier paramètre correspond à la couleur, qui attend une chaîne de caractères. Un entier à cette position ne correspond donc pas au type attendu. Selon le mode de typage PHP, une conversion peut être effectuée ou une erreur de type peut apparaître.

### 2.1.b
La promotion de propriétés permet de déclarer et d'initialiser directement les propriétés dans les paramètres du constructeur.

Son avantage est de réduire le nombre de lignes de code et d'éviter de déclarer les propriétés séparément puis de les initialiser avec `$this`.

### 2.2.a
PHP ne permet pas de déclarer deux constructeurs portant le même nom dans une même classe. La deuxième déclaration provoque une erreur.

### 2.2.b
On peut utiliser un seul constructeur avec des valeurs par défaut :

```php
public function __construct(string $nom = "", string $prenom = "")
{
    $this->nom = $nom;
    $this->prenom = $prenom;
}
```

Ainsi, on peut créer une personne vide ou une personne avec des informations.

### 2.2.c – Bonus
Une méthode statique de fabrique (*named constructor*) est une méthode qui crée et retourne un objet. Elle permet de proposer plusieurs façons de créer un objet avec des noms explicites.

Exemple : `Personne::depuisTableau($data)`.

### 2.3.a
Les trois messages s'affichent dans cet ordre :

1. Création de la voiture.
2. Destruction de la voiture après l'exécution de `unset($maVoiture)`.
3. Fin du script.

### 2.3.b
Si on supprime `unset($maVoiture)`, le destructeur n'est plus appelé à cet endroit. Il est appelé automatiquement à la fin du script lorsque l'objet est détruit.

L'ordre devient donc :

1. Création de la voiture.
2. Fin du script.
3. Destruction de la voiture.

### 2.3.c
Si deux objets `$a` et `$b` sont créés sans `unset`, ils sont généralement détruits dans l'ordre inverse de leur création : `$b` puis `$a`, à la fin du script.

### 2.3.d
On ajoute dans la classe `Personne` le destructeur suivant :

```php
public function __destruct()
{
    echo "Détruire " . __CLASS__ . PHP_EOL;
}
```

`__CLASS__` retourne le nom de la classe dans laquelle la méthode est définie.

---

# Partie 3 – Surcharge de propriétés

### 3.1
Les quatre méthodes magiques ont les rôles suivants :

- `__set()` : appelée lorsqu'on modifie une propriété inaccessible ou inexistante.
- `__get()` : appelée lorsqu'on lit une propriété inaccessible ou inexistante.
- `__isset()` : appelée lorsqu'on utilise `isset()` sur une propriété inaccessible ou inexistante.
- `__unset()` : appelée lorsqu'on utilise `unset()` sur une propriété inaccessible ou inexistante.

### 3.2
Sans `__set()`, essayer de modifier directement une propriété privée depuis l'extérieur provoque une erreur ou un avertissement selon la version de PHP.

Avec `__set()`, PHP appelle automatiquement cette méthode, qui peut contrôler et gérer la modification de la propriété.

### 3.3
Oui, `__set()` peut casser l'encapsulation si elle permet de modifier toutes les propriétés sans contrôle.

Pour respecter l'encapsulation, il faut vérifier les valeurs avant de les enregistrer, par exemple refuser un nom vide ou trop court.

### 3.4
On peut ajouter une validation dans `__set()` :

```php
public function __set(string $name, mixed $value): void
{
    if ($name === "nom") {
        if (empty($value) || strlen($value) < 2) {
            throw new InvalidArgumentException("Le nom doit contenir au moins 2 caractères.");
        }

        $this->nom = $value;
    }
}
```

Cette validation empêche d'enregistrer un nom vide ou contenant moins de deux caractères.

---

# Partie 4 – Représentation textuelle : __toString()

### 4.1
`getAge()` est privée, mais elle fonctionne dans `__toString()` parce que les deux méthodes appartiennent à la même classe. Une méthode privée peut être appelée par une autre méthode de cette classe.

### 4.2
La méthode `__toString()` doit retourner une chaîne de caractères. Si elle retourne un entier, PHP peut effectuer une conversion selon le mode de typage utilisé. Avec un typage strict, cela peut provoquer une erreur de type (`TypeError`).

### 4.3 – Bonus
L'intérêt de `__toString()` est de permettre d'afficher directement un objet avec `echo`, sans appeler une méthode spéciale comme `getName()`.

Deux situations pratiques :
1. Afficher directement les informations d'une personne avec `echo $p`.
2. Afficher facilement plusieurs objets dans une boucle ou dans une liste.

---

# Partie 5 – Sérialisation : __serialize() et __unserialize()

### 5.1
La chaîne sérialisée contient les informations retournées par `__serialize()`, notamment le nom et l'âge.

Le mot de passe n'y figure pas, car il a volontairement été exclu pour des raisons de sécurité.

### 5.2
Lorsqu'on met `__serialize()` en commentaire, PHP utilise son mécanisme de sérialisation par défaut.

Les propriétés de l'objet, y compris le mot de passe, peuvent alors être présentes dans la chaîne sérialisée. Cela représente un risque car des informations sensibles peuvent être exposées.

### 5.3
Après `unserialize()`, la valeur de `$motDePasse` est une chaîne vide `""`, car la méthode `__unserialize()` la réinitialise ainsi.

Dans une vraie application, il faut prévoir une gestion sécurisée des mots de passe, notamment en utilisant `password_hash()` pour stocker les mots de passe sous forme de hachage.

### 5.4
Il ne faut jamais appeler `unserialize()` sur des données provenant directement d'un utilisateur car ces données peuvent contenir des objets malveillants. Cela peut provoquer une attaque appelée **PHP Object Injection**.

Une alternative plus sûre pour échanger des données simples est d'utiliser JSON avec `json_encode()` et `json_decode()`.

---

# Partie 6 – Héritage : la classe Etudiant

### 6.1.a
On crée une classe `Chat` qui hérite de `Animal` et possède sa propre méthode `miauler()` :

```php
class Chat extends Animal
{
    public function miauler(): void
    {
        echo "Le chat miaule." . PHP_EOL;
    }
}
```

### 6.1.b
Non, on ne peut pas appeler `$c->miauler()` si `$c` est un objet de la classe `Chien`.

La méthode `miauler()` appartient à la classe `Chat`, et non à la classe `Chien`. Les deux classes héritent de `Animal`, mais elles ne héritent pas l'une de l'autre.

### 6.2.a
Si on supprime `parent::__construct($nom)`, le constructeur de la classe mère n'est pas appelé explicitement.

L'attribut `$nom` de la classe mère risque donc de ne pas être initialisé correctement. Il faut appeler `parent::__construct($nom)` pour exécuter le constructeur de la classe mère.

### 6.2.b
L'attribut `$nom` est déclaré `protected` pour permettre à la classe mère et à ses classes filles d'y accéder.

S'il était `private`, il serait accessible uniquement depuis la classe `Personne`, et non directement depuis `Etudiant`.

### 6.3.a
Les trois essais provoquent les erreurs suivantes :

1. Redéfinir `afficher()` dans une classe fille alors que cette méthode est déclarée `final` dans la classe mère provoque une erreur fatale.
2. Créer `class SousOutil extends Outil` alors que `Outil` est déclarée `final` provoque une erreur fatale, car une classe finale ne peut pas être héritée.
3. Modifier `$p->reference` alors que cette propriété est `readonly` et déjà initialisée provoque une erreur, car une propriété `readonly` ne peut pas être modifiée une deuxième fois.

### 6.3.b
Exemple d'utilisation de `readonly` : un identifiant unique ou une date de création qui ne doit plus changer après l'initialisation.

Exemple d'utilisation de `final` : une méthode de sécurité qui ne doit pas être redéfinie dans les classes filles.

### 6.4.a
Si `getAge()` est privée dans `Personne`, la classe `Etudiant` ne peut pas l'appeler directement. Cela provoque une erreur d'accès.

Pour que la classe fille puisse utiliser cette méthode, il faut remplacer `private` par `protected` dans la classe `Personne`.

### 6.4.b
Il est impossible d'accéder directement à `$this->dateNaissance` depuis `Etudiant` parce que cette propriété est déclarée `private` dans `Personne`.

Une propriété privée est accessible uniquement dans la classe où elle est déclarée, même si une autre classe en hérite.

### 6.4.c
L'utilisation de `parent::__toString()` permet de réutiliser le code de la classe mère sans le réécrire.

Cela évite la répétition du code et facilite la maintenance du programme.

---

# Partie 7 – Mise en pratique : le compte bancaire

### 7.1
L'erreur de syntaxe se trouve dans la formule de la méthode `un_an()` :

```php
$this->montant * ($this->montant 1 * $this->interet / 100);
```

Il manque l'opérateur `+` entre `$this->montant` et `1`.

### 7.2
La bonne formule pour calculer le montant après un an avec un intérêt de `t` % est :

```php
$nouveauMontant = $montant * (1 + $t / 100);
```

## 7.3
Non, l'ordre des paramètres `$interet, $montantInitial` n'est pas cohérent avec l'énoncé.

L'énoncé demande d'abord le montant initial, puis le taux d'intérêt. Il faut donc respecter cet ordre dans le constructeur.

Sinon, on risque de confondre les deux valeurs lors de la création des comptes.

## 7.4
Le code corrigé doit :
- Déclarer les attributs `montant` et `interet` en `private`.
- Utiliser un constructeur qui reçoit le montant initial puis le taux d'intérêt.
- Ajouter les types `float` et les types de retour.
- Calculer le montant avec la formule `montant * (1 + interet / 100)`.
- Utiliser `number_format()` pour afficher deux chiffres après la virgule.

Résultats attendus après 10 ans :

| Compte | Montant initial | Taux | Montant après 10 ans |
|---|---:|---:|---:|
| `$c1` | 400 DH | 10 % | ≈ 1 037,50 DH |
| `$c2` | 2 500 DH | 5 % | ≈ 4 072,24 DH |

# Questions de synthèse

# 1. Quelle est la différence entre une classe et un objet ?
Une classe est un modèle qui définit les propriétés et les méthodes. Un objet est une instance de cette classe créée avec le mot-clé `new`.

# 2. Citez trois avantages de la POO par rapport à la programmation procédurale.
1. La réutilisation du code grâce aux classes et à l'héritage.
2. Une meilleure organisation du programme.
3. La protection des données grâce à l'encapsulation.

# 3. Pourquoi est-il recommandé de déclarer les attributs en `private` ou `protected` ?
Pour protéger les données contre les accès et les modifications non contrôlés. Cela permet de respecter le principe d'encapsulation.

# 4. Quelle différence entre `private` et `protected` quand il y a de l'héritage ?
- `private` : accessible uniquement dans la classe où l'attribut ou la méthode est déclaré.
- `protected` : accessible dans la classe où il est déclaré et dans ses classes filles.

# 5. Une méthode magique doit-elle être déclarée `public` ?
Oui, les méthodes magiques utilisées automatiquement par PHP, comme `__get()`, `__set()`, `__isset()`, `__unset()`, `__toString()`, `__serialize()` et `__unserialize()`, doivent être déclarées `public` pour être utilisées correctement.