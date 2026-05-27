# Memoire IA - Premium SaaS Platform

Ce fichier sert de point de reprise pour tout agent IA qui intervient sur ce projet.

## Contexte

- Projet Laravel situe dans `C:\Users\PC\.codex\memories\premium-saas-platform\site`.
- Domaine : vitrine de formations, services digitaux et comptes monetises.
- Parcours achat actif : Chariow strict.
- Ne pas relancer les seeders sans demande explicite.
- Les nouvelles migrations pendantes doivent etre lancees une seule fois avec `php artisan migrate`.
- Ne jamais afficher ni recopier les secrets `.env`.
- Cache local : `.env` utilise `CACHE_STORE=file` pour eviter l'erreur MySQL `Table 'cache' doesn't exist` lors de `php artisan optimize:clear`.
- Session locale : `.env` utilise `SESSION_DOMAIN=` vide pour laisser Laravel poser le cookie sur `localhost` sans domaine force.

## Etat Actuel

- Pages publiques : accueil, a propos, catalogue, formations, services, detail produit, contact.
- Auth : inscription, connexion, deconnexion.
- Espace client : dashboard, commandes, factures, support, telechargement prive pour commandes locales payees.
- Admin : dashboard, statistiques, produits, commandes, ventes Chariow manuelles, support, utilisateurs.
- Paiement local : supprime du parcours actif. Les anciennes routes checkout, paiement manuel et webhook paiement ne sont plus exposees.
- Chariow : chaque produit peut avoir `chariow_checkout_url`. Si le lien existe, le bouton acheter passe par la route protegee `products.buy`; le client doit etre connecte avant d'etre redirige vers Chariow. Sinon le produit affiche `Produit bientot disponible`.
- Ventes Chariow locales : l'admin peut enregistrer une vente confirmee via `Admin > Commandes > Ajouter vente Chariow`; cela cree une commande locale `paid` avec une reference `CHW-*` et alimente le dashboard.

## Fichiers Cles

- Routes : `routes/web.php`
- Catalogue/pages : `app/Http/Controllers/HomeController.php`
- Page A propos : `resources/views/pages/about.blade.php`
- Produits admin : `app/Http/Controllers/Admin/ProductController.php`
- Commandes/admin ventes Chariow : `app/Http/Controllers/Admin/OrderController.php`
- Validation vente Chariow : `app/Http/Requests/AdminChariowSaleRequest.php`
- Support admin : `app/Http/Controllers/Admin/SupportTicketController.php`
- Utilisateurs admin : `app/Http/Controllers/Admin/UserController.php`
- Models : `app/Models/User.php`, `Product.php`, `Order.php`, `Invoice.php`, `SupportTicket.php`
- Factures : `app/Services/InvoiceService.php`, `resources/views/pdf/invoice.blade.php`
- Formulaire vente Chariow : `resources/views/admin/orders/chariow-sale.blade.php`

## Notes Base De Donnees

- `orders.payment_reference` est la colonne generique de reference paiement/vente.
- Une migration de renommage existe : `2026_05_25_000003_rename_order_payment_reference_column.php`.
- `products.chariow_checkout_url` est ajoute par `2026_05_25_000002_add_chariow_checkout_url_to_products_table.php`.
- Si une ancienne table `manual_payments` existe deja en base, elle n'est plus utilisee par le code actif. Ne pas la supprimer sans confirmation explicite si des donnees historiques doivent etre conservees.

## Ce Qui Est Fait

- Redirection achat vers Chariow produit par produit.
- Achat Chariow protege par authentification : un visiteur non connecte est envoye vers login avant la redirection Chariow.
- Blocage du checkout local cote client.
- Ajout manuel des ventes Chariow dans les commandes locales.
- Dashboard alimente par les commandes locales payees.
- Support admin : liste, recherche, filtre, detail, changement de statut, reponse via email.
- Suppression utilisateur protegee : un utilisateur avec commandes ou tickets ne peut plus etre supprime, il faut le bloquer.
- Nettoyage legacy actif : routes/services/controllers CinetPay retires, paiement manuel actif retire, variables `.env.example` nettoyees.
- Page A propos publique ajoutee sur `/apropos` avec presentation, domaines d'activite, services, partenaires, equipe et fondateurs. La version mobile est compacte : grands visuels reduits/masques, domaines et partenaires en blocs. La galerie equipe/fondateurs utilise maintenant un slider grande image + miniatures floutees inspire du dernier exemple fourni, avec fleches, points, compteur et auto-slide en JavaScript vanilla. Les infos nom/role/bio sont dans un panneau sous l'image active pour ne pas cacher les visages. Le hero utilise `public/assets/equipe.jpg` comme image de fond avec overlay sombre pour garder le texte lisible.
- Hero de la page d'accueil `/` : texte `Formez-vous et lancez vos revenus digitaux`, image hero directe `public/assets/mockup.png` sans bloc/cadre autour. Sur mobile, texte et boutons reduits et image agrandie pour occuper davantage la colonne droite. Boutons formations/comptes, benefices et icones reseaux conserves.
- Navbar accueil `/` : la page `resources/views/pages/welcome.blade.php` masque le layout shell et a sa propre navbar. Cette navbar est maintenant `fixed` en haut du viewport pendant le scroll, avec padding hero ajuste et menu mobile au-dessus (`z-[60]`).
- Navbar globale : `resources/views/layouts/app.blade.php` utilise maintenant aussi une navbar `fixed` en haut, avec effet glass proche de `/`, CTA arrondi style accueil, menu mobile au-dessus (`z-[60]`) et spacer `h-20 sm:h-24` pour compenser la hauteur du header sur les pages qui utilisent le layout. Le menu mobile global est aligne visuellement sur celui de `/` : overlay noir floute, panneau `bg-white/[0.12]`, liens en blocs, boutons empiles, sans entete/logo interne. Liens inclus : Accueil, Catalogue, Formations, Services, A propos, Avis, FAQ, Contact seulement pour utilisateurs connectes.
- Navbar accueil `/` : le lien `route('service')` est libelle `Services` en desktop et mobile. Les boutons de contenu peuvent encore utiliser le mot `Comptes` quand il s'agit d'un CTA metier, mais la navigation principale affiche `Services`.
- Logo principal : l'image envoyee `logo.png` a ete copiee dans `public/assets/logo.png`. Les layouts public/admin et la page d'accueil utilisent maintenant cet asset au lieu de `ppmc-logo-mark.svg`. Les layouts public/admin definissent aussi ce fichier comme favicon (`rel="icon"`, `shortcut icon`, `apple-touch-icon`) et le fallback du titre navigateur est `PPMC`.
- Connexion Google : routes guest `auth.google.redirect` et `auth.google.callback`, controleur `App\Http\Controllers\Auth\GoogleAuthController`, boutons dans login/register, config `services.google`, variables `.env.example` `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`, et migration `2026_05_26_000001_add_google_oauth_columns_to_users_table.php` pour `users.google_id` / `users.google_avatar`. Necessite d'installer le package officiel avec `composer require laravel/socialite` avant test. Le controleur verifie maintenant que `client_id` et `client_secret` existent avant la redirection Google, force `redirectUrl(config('services.google.redirect'))` sur redirect/callback, journalise les erreurs avec `report()`, et retente en `stateless()` si Socialite leve `InvalidStateException`.
- Page Login : `resources/views/auth/login.blade.php` utilise maintenant un layout compact inspire du formulaire fourni par l'utilisateur, avec panneau formulaire transparent/glass plus carre, largeur interne limitee, bouton Google, image `public/assets/equipe.jpg` a droite sur desktop et bandeau compact sur mobile, sans logo site en haut du formulaire.
- Page Register : `resources/views/auth/register.blade.php` suit le meme style compact que login : panneau transparent/glass, image `public/assets/training/academy-dashboard.jpg`, bouton Google, champs groupes en colonnes sur desktop pour eviter une page trop longue, sans logo site en haut du formulaire.
- Page Home connectee `/home` : la hero section de `resources/views/pages/home.blade.php` n'utilise plus le faux bloc glass "Pilotage". Le visuel de droite est une image directe sans cadre glass autour, avec un reflet CSS decoratif sous l'image uniquement hors desktop large (`lg:hidden` sur le reflet). Sur mobile, la colonne image est elargie et l'image est agrandie (`w-[136%]`), tandis que les CTA sont reduits en trois petits boutons. Le titre mobile est en trois lignes : `L'excellence` en dore, `du Business`, puis `Digital`. Le padding bas desktop de la hero a ete reduit (`lg:pb-10 xl:pb-12`), le mockup occupe deux lignes de grille en desktop (`md:row-span-2`) et les marges CTA/socials ont ete resserrees pour eviter un grand espace vide sous le visuel.
- Page Formations `/formations`/`/training` : le hero existant est conserve. La section basse `#courses` est revenue a la grille de cartes initiale avec produits reels si disponibles et fallback `$fallbackCourses` sinon. Les filtres `Tout`, `Crypto`, `Social`, `Video`, `Ads`, `Business` sont fonctionnels cote interface via `data-training-filter`; les produits reels sont classes automatiquement par mots-cles titre/description.
- Photos A propos attendues dans `public/assets/about/` : `hero.jpg`, `company.jpg`, `domaines/formations.jpg`, `domaines/social-assets.jpg`, `domaines/digital-business.jpg`, `partners/partner-1.jpg`, `partners/partner-2.jpg`, `partners/partner-3.jpg`, `team/founder-1.jpg`, `team/founder-2.jpg`, `team/member-1.jpg`, `team/member-2.jpg`, `team/member-3.jpg`, `team/team.jpg`. La vue affiche des images de secours si ces fichiers manquent.
- La galerie equipe inclut aussi `Responsable de la recherche`, avec image attendue `public/assets/about/team/recherche.jpg` et secours `public/assets/devices/photo_10_2026-05-26_10-25-32.jpg`.

## Restant Prioritaire

1. Lancer les migrations pendantes et vider le cache Laravel.
2. Tester `Admin > Commandes > Ajouter vente Chariow`.
3. Ajouter reset password.
4. Configurer SMTP reel et tester les emails.
5. Ajouter tests feature : produit avec lien Chariow, produit sans lien, ajout vente Chariow, support admin, protection suppression utilisateur.
6. Decider plus tard si on supprime physiquement les anciennes donnees `manual_payments` en base.

## Commandes Utiles

```bash
php -l routes/web.php
php -l app/Models/Order.php
php -l app/Http/Requests/AdminChariowSaleRequest.php
php -l app/Http/Controllers/Admin/OrderController.php
php -l database/migrations/2026_05_25_000003_rename_order_payment_reference_column.php
php artisan migrate
php artisan optimize:clear
php artisan route:list --name=about
php artisan route:list --path=payment
php artisan route:list --path=admin/orders
```

En mode Chariow strict, `route:list --path=payment` ne doit plus afficher de route de paiement local.
