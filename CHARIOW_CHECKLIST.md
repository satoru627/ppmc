# Checklist Chariow Simple

Ce mode transforme le site en vitrine. Le paiement et l'acces a la formation sont geres par Chariow. Le checkout local client est desactive.

## 1. Preparation Chariow

1. Creer la formation dans Chariow.
2. Configurer le prix, le fichier/acces et les moyens de paiement dans Chariow.
3. Copier le lien de paiement ou le lien produit Chariow.

## 2. Configuration Produit Local

1. Aller dans `Admin > Produits`.
2. Modifier le produit correspondant.
3. Coller le lien complet `https://...` dans `Lien de paiement Chariow`.
4. Enregistrer.

Si ce champ est vide, le produit affiche `Produit bientot disponible` et ne peut pas etre achete depuis le site.

## 3. Commandes A Lancer

```bash
php -l app/Models/Product.php
php -l app/Http/Requests/ProductRequest.php
php -l database/migrations/2026_05_25_000002_add_chariow_checkout_url_to_products_table.php
php -l database/migrations/2026_05_25_000003_rename_order_payment_reference_column.php
php -l routes/web.php
php artisan migrate
php artisan optimize:clear
php artisan route:list --path=checkout
php artisan route:list --path=payment/manual
php artisan route:list --path=payment/success
php artisan route:list --path=payment/notify
```

Important : `php artisan migrate` applique seulement les nouvelles migrations pendantes. Ne pas relancer les seeders.

## 4. Test Client

1. Ouvrir la page publique du produit.
2. En visiteur non connecte, cliquer sur `Se connecter pour acheter`.
3. Verifier que le navigateur demande la connexion.
4. Se connecter ou creer un compte.
5. Verifier que le navigateur part ensuite vers Chariow.
6. En client deja connecte, cliquer sur `Acheter maintenant`.
7. Verifier que le navigateur part directement vers Chariow.
8. Faire un achat test cote Chariow si possible.
9. Verifier que Chariow donne bien l'acces a la formation apres paiement.

## 5. Test Produit Sans Lien

1. Vider le champ `Lien de paiement Chariow` sur un produit de test.
2. Ouvrir la page publique du produit.
3. Verifier que le bouton affiche `Produit bientot disponible`.
4. Verifier que `/checkout/{slug}`, `/payment/manual/{order}` et `/payment/notify` ne sont plus disponibles dans les routes.
