-- Désactiver temporairement les vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 0;

-- Supprimer toutes les tables
DROP TABLE IF EXISTS `avis`;
DROP TABLE IF EXISTS `produits`;
DROP TABLE IF EXISTS `boutiques`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `password_resets`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `personal_access_tokens`;

-- Réactiver les vérifications de clés étrangères
SET FOREIGN_KEY_CHECKS = 1;
