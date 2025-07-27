# Documentation d'Intégration du Paiement

## Informations Marchand

- **ID Marchand**: PP-F1575
- **Environnement de Test**: [Lien vers l'environnement de test]
- **Environnement de Production**: [Lien vers l'environnement de production]

## Intégration PayIn (Paiement entrant)

### Configuration requise

1. Clé API
2. URL de callback pour les notifications
3. URL de retour après paiement

### Points d'API

#### 1. Initialisation du paiement

```
POST /api/payment/initiate
```

**Paramètres requis:**
- `amount` (float): Montant de la transaction
- `currency` (string): Devise (XOF par défaut)
- `reference` (string): Référence unique de la transaction
- `customer_email` (string): Email du client
- `callback_url` (string): URL de callback pour les notifications
- `return_url` (string): URL de retour après paiement

**Exemple de réponse réussie:**
```json
{
    "status": "success",
    "payment_url": "https://payment-gateway.com/pay/abc123",
    "transaction_id": "txn_123456789"
}
```

#### 2. Vérification du statut

```
GET /api/payment/status/{transaction_id}
```

**Réponse:**
```json
{
    "status": "completed",
    "amount": 10000,
    "currency": "XOF",
    "reference": "cmd_123456",
    "payment_method": "mobile_money",
    "paid_at": "2025-07-27T15:00:00Z"
}
```

## Intégration PayOut (Paiement sortant)

### Configuration requise

1. Clé API avec les permissions de paiement sortant
2. Compte bénéficiaire enregistré
3. Solde suffisant

### Points d'API

#### 1. Demande de paiement sortant

```
POST /api/payout/request
```

**Paramètres requis:**
- `amount` (float): Montant à transférer
- `currency` (string): Devise (XOF par défaut)
- `recipient_id` (string): ID du bénéficiaire
- `reference` (string): Référence unique de la transaction
- `description` (string): Description du paiement

**Exemple de réponse réussie:**
```json
{
    "status": "processing",
    "payout_id": "pout_123456789",
    "amount": 50000,
    "fees": 500,
    "net_amount": 49500
}
```

## Codes d'erreur courants

| Code | Description | Action recommandée |
|------|-------------|-------------------|
| 4001 | Solde insuffisant | Vérifier le solde du compte |
| 4002 | Bénéficiaire invalide | Vérifier l'ID du bénéficiaire |
| 4003 | Montant invalide | Vérifier le montant saisi |
| 5001 | Erreur du processeur | Réessayer plus tard |

## Sécurité

1. Toujours utiliser HTTPS pour toutes les requêtes
2. Ne jamais exposer votre clé API côté client
3. Valider toutes les entrées utilisateur
4. Implémenter l'IP whitelisting si possible

## Support

Pour toute question ou assistance technique, veuillez contacter :
- Email: support@payment-gateway.com
- Téléphone: +225 XX XX XX XX

## Historique des versions

- **1.0.0** (2025-07-27)
  - Version initiale du document
  - Ajout de la documentation PayIn/PayOut
