# Documentation synthétique du système Cashback Market

## Modules principaux

- **Utilisateurs** : Inscription, connexion, gestion du profil, parrainage (filleuls/parrain).
- **Boutiques** : Création, gestion, affichage public, notation, cashback paramétrable.
- **Produits** : Ajout, édition, affichage, gestion des catégories.
- **Cashback** :
  - Calcul centralisé (voir `docs/cashback_calcul.md`).
  - Validation et remboursement par l’admin.
  - Accusé de remboursement généré côté admin et consultable côté boutique.
- **Troc** : Système d’échange entre membres, offres, acceptation/refus, suivi.
- **Comptabilité** : Suivi des mouvements (cashbacks, remboursements, paiements boutiques) accessible à l’admin.
- **Campagnes** : Gestion des campagnes publicitaires pour annonceurs.
- **Notifications** : Système de notifications pour les actions importantes.

## Rôles et accès

- **Admin** : Accès total (gestion utilisateurs, boutiques, cashbacks, comptabilité, campagnes).
- **Acheteur** : Accès à son espace, achats, cashbacks, parrainage, troc.
- **Commerçant/Partenaire** : Gestion de sa boutique, consultation des cashbacks remboursés, accusés.
- **Annonceur** : Gestion de campagnes publicitaires.

## Flux principaux

- **Cashback** :
  1. La boutique paramètre un cashback (fixe ou %).
  2. L’acheteur voit et reçoit la moitié du montant boutique (calcul automatique, voir doc dédiée).
  3. Si l’acheteur a un filleul, il reçoit 80% de cette moitié.
  4. L’admin valide/rembourse, la boutique reçoit l’accusé.

- **Troc** :
  1. Un membre propose un troc (produit/service).
  2. Un autre membre fait une offre.
  3. Acceptation/refus, validation par les deux parties.

- **Comptabilité** :
  - Tous les mouvements sont enregistrés (cashbacks, remboursements, paiements boutiques).
  - Accessible uniquement à l’admin.

## Bonnes pratiques

- Toutes les routes sont nommées et protégées selon le rôle.
- Les calculs sensibles sont centralisés dans les modèles.
- Les vues sont responsives et adaptées au public francophone.
- Les erreurs de route sont systématiquement corrigées.

## Pour aller plus loin

- Voir `docs/cashback_calcul.md` pour le détail du calcul cashback.
- Voir les contrôleurs et modèles pour la logique métier.
- Pour toute évolution, respecter la centralisation des règles métier dans les modèles.

---

*Document mis à jour automatiquement par GitHub Copilot le 28/07/2025.*
