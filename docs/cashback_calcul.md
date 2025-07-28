# Documentation technique - Calcul du cashback acheteur

## Règle métier
- Le montant de cashback affiché et versé à l’acheteur correspond à **la moitié** du montant fixé par la boutique partenaire (fixe ou pourcentage).
- Si l’acheteur n’a **aucun filleul** (parrainage), il reçoit **100% de cette moitié**.
- Si l’acheteur a **au moins un filleul**, il reçoit **80% de cette moitié** (le reste va à la plateforme ou au parrainage).
- Ce calcul est **transparent** pour l’utilisateur final (aucune explication affichée dans l’interface).

## Implémentation
- La méthode centrale `montantPourAcheteur()` est définie dans le modèle `Cashback` :

```php
public function montantPourAcheteur()
{
    $moitie = $this->montant / 2;
    $acheteur = $this->user;
    $aFilleul = $acheteur && $acheteur->filleuls && $acheteur->filleuls->count() > 0;
    if ($aFilleul) {
        return round($moitie * 0.8, 2);
    }
    return round($moitie, 2);
}
```

- La relation `filleuls` (hasMany) et `parrain` (belongsTo) sont définies sur le modèle `User` :

```php
public function filleuls(): HasMany
{
    return $this->hasMany(User::class, 'parent_id');
}
public function parrain(): BelongsTo
{
    return $this->belongsTo(User::class, 'parent_id');
}
```

- Utiliser `$cashback->montantPourAcheteur()` dans les vues et contrôleurs pour obtenir le montant réel à afficher/verser.

## Exemple
- Boutique propose 1000 FCFA de cashback sur un article.
    - Acheteur sans filleul : il reçoit 500 FCFA.
    - Acheteur avec filleul : il reçoit 400 FCFA (80% de 500 FCFA).

## Notes
- Le calcul s’applique automatiquement partout où la méthode est utilisée.
- La logique peut être adaptée facilement si la politique évolue.
- Pour toute question, contacter l’équipe technique.
