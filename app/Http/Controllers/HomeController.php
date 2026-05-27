<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Page d'accueil publique pour les visiteurs non connectes.
     */
    public function index(): View
    {
        return view('pages.welcome');
    }

    /**
     * Page institutionnelle A propos.
     */
    public function about(): View
    {
        $stats = [
            ['value' => '3', 'label' => 'domaines digitaux'],
            ['value' => '24/7', 'label' => 'support client'],
            ['value' => '100%', 'label' => 'parcours en ligne'],
        ];

        $services = [
            [
                'icon' => 'book-open',
                'title' => 'Formations premium',
                'description' => 'Programmes pratiques pour apprendre la monetisation, la creation de contenu, la vente digitale et les systemes de revenus en ligne.',
            ],
            [
                'icon' => 'briefcase',
                'title' => 'Services digitaux',
                'description' => 'Selection de comptes sociaux, actifs numeriques et solutions utiles pour accelerer un projet digital deja lance.',
            ],
            [
                'icon' => 'shield',
                'title' => 'Validation et suivi',
                'description' => 'Controle des offres, assistance apres achat et suivi administratif pour garder un parcours clair entre le client et l equipe.',
            ],
            [
                'icon' => 'users',
                'title' => 'Accompagnement',
                'description' => 'Conseils, support et orientation vers les bonnes ressources selon le niveau, le besoin et l objectif du client.',
            ],
        ];

        $domains = [
            [
                'title' => 'Formation digitale',
                'description' => 'Des contenus orientes action pour creer, vendre et monetiser sur les plateformes digitales.',
                'image' => '/assets/about/domaines/formations.jpg',
                'fallback' => '/assets/training/academy-dashboard.jpg',
            ],
            [
                'title' => 'Comptes et actifs sociaux',
                'description' => 'TikTok, Facebook, YouTube et autres actifs utiles pour demarrer plus vite avec une base existante.',
                'image' => '/assets/about/domaines/social-assets.jpg',
                'fallback' => '/assets/training/tiktok.jpg',
            ],
            [
                'title' => 'Business en ligne',
                'description' => 'Methodes, outils et ressources pour structurer une activite digitale rentable et durable.',
                'image' => '/assets/about/domaines/digital-business.jpg',
                'fallback' => '/assets/training/digital-products.jpg',
            ],
        ];

        $partners = [
            [
                'name' => 'Gologin',
                'role' => 'GoLogin est une entreprise technologique qui a développé un navigateur web éponyme conçu pour l/anonymat et la gestion sécurisée de multiples comptes en ligne',
                'image' => '/assets/about/partners/partner-1.jpg',
                'fallback' => '/assets/gologin.jpg',
            ],
            [
                'name' => 'crypto-fiat',
                'role' => 'Plateforme spécialisée dans l/achat, la vente et l/échange de cryptomonnaies',
                'image' => '/assets/about/partners/partner-2.jpg',
                'fallback' => '/assets/training/crypto.png',
            ],
        ];

        $team = [
            [
                'name' => 'Fondateur principal',
                'role' => 'Fondateur & strategie',
                'bio' => 'Pilote la vision, les offres et les partenariats autour de la croissance digitale.',
                'tag' => 'Fondateur',
                'image' => '/assets/about/team/founder-1.jpg',
                'fallback' => '/assets/devices/fondateur.jpg',
            ],
            [
                'name' => 'Co-fondateur',
                'role' => 'Operations & produits',
                'bio' => 'Structure les parcours client, la qualite des offres et la livraison des produits digitaux.',
                'tag' => 'Fondateur',
                'image' => '/assets/about/team/founder-2.jpg',
                'fallback' => '/assets/devices/co-fondateur.jpg',
            ],
            [
                'name' => 'formateur principal',
                'role' => 'Pedagogie & contenus',
                'bio' => 'Conception des formations, creation de contenus et animation de la communaute d apprentissage.',
                'tag' => 'Equipe',
                'image' => '/assets/about/team/member-1.jpg',
                'fallback' => '/assets/devices/controleur.jpg',
            ],
            [
                'name' => 'coordinateur client',
                'role' => 'coprdination & publications des videos',
                'bio' => 'Coordonne les videos et les publications.',
                'tag' => 'Equipe',
                'image' => '/assets/about/team/member-2.jpg',
                'fallback' => '/assets/devices/coordinateur.jpg',
            ],
            [
                'name' => 'Monteur video',
                'role' => 'Production & montage',
                'bio' => 'Prepare les videos, les formats courts et les supports visuels pour les formations et la communication.',
                'tag' => 'Equipe',
                'image' => '/assets/about/team/member-3.jpg',
                'fallback' => '/assets/devices/monteur.jpg',
            ],
            [
                'name' => 'Responsable de la recherche',
                'role' => 'Recherche & veille digitale',
                'bio' => 'Analyse les tendances, repere les opportunites et appuie la creation des offres et contenus.',
                'tag' => 'Equipe',
                'image' => '/assets/about/team/recherche.jpg',
                'fallback' => '/assets/devices/recherche.jpg',
            ],
            [
                'name' => 'Toute l equipe',
                'role' => 'Equipe PPMC',
                'bio' => 'Un collectif reuni autour de la formation digitale, des services numeriques et de l accompagnement client.',
                'tag' => 'Equipe',
                'image' => '/assets/about/team/team.jpg',
                'fallback' => '/assets/devices/equipe.jpg',
            ],
        ];

        return view('pages.about', compact('stats', 'services', 'domains', 'partners', 'team'));
    }

    /**
     * Page home apres connexion.
     */
    public function home(): View
    {
        $featuredProducts = Product::active()
            ->latest()
            ->take(6)
            ->get();

        return view('pages.home', compact('featuredProducts'));
    }

    /**
     * Page formations inspiree du frontend Next.js.
     */
    public function training(): View
    {
        $formationProducts = Product::active()
            ->where('type', 'formation')
            ->latest()
            ->get();

        return view('pages.training', compact('formationProducts'));
    }

    /**
     * Alias francais vers la page formations.
     */
    public function formations(): RedirectResponse
    {
        return redirect()->route('training');
    }

    /**
     * Page services / actifs digitaux.
     */
    public function service(): View
    {
        $serviceProducts = Product::active()
            ->where('type', 'service')
            ->latest()
            ->get();

        $platforms = $this->servicePlatforms();
        $platformCounts = $this->platformCounts($serviceProducts, $platforms);
        $products = $serviceProducts;
        $selectedPlatform = null;

        return view('pages.crypto', compact('serviceProducts', 'products', 'platforms', 'platformCounts', 'selectedPlatform'));
    }

    /**
     * Liste les comptes d'une plateforme precise.
     */
    public function servicePlatform(string $platform): View
    {
        $platforms = $this->servicePlatforms();

        abort_unless(isset($platforms[$platform]), 404);

        $products = Product::active()
            ->where('type', 'service')
            ->latest()
            ->get();

        $serviceProducts = $this->filterProductsByPlatform($products, $platforms[$platform]['keywords']);
        $platformCounts = $this->platformCounts($products, $platforms);
        $selectedPlatform = $platform;

        return view('pages.crypto', compact('serviceProducts', 'products', 'platforms', 'platformCounts', 'selectedPlatform'));
    }

    /**
     * Ancienne URL /crypto redirigee vers la nouvelle route /service.
     */
    public function legacyCrypto(): RedirectResponse
    {
        return redirect()->route('service');
    }

    /**
     * Alias francais vers la page services digitaux.
     */
    public function services(): RedirectResponse
    {
        return redirect()->route('service');
    }

    /**
     * Configure les plateformes de comptes vendues sur la page services.
     */
    private function servicePlatforms(): array
    {
        return [
            'tiktok' => [
                'name' => 'TikTok',
                'logo' => 'tiktok',
                'headline' => 'Comptes TikTok',
                'description' => 'Comptes TikTok monetises ou de demarrage avec audiences actives et niches exploitables.',
                'keywords' => ['tiktok'],
                'fallback_count' => '50+',
                'metric' => 'Videos courtes',
            ],
            'facebook' => [
                'name' => 'Facebook',
                'logo' => 'facebook',
                'headline' => 'Pages Facebook',
                'description' => 'Pages Facebook monetisees, eligibles reels et pretes pour revenus publicitaires.',
                'keywords' => ['facebook', 'page'],
                'fallback_count' => '20+',
                'metric' => 'Reels & audience',
            ],
            'youtube' => [
                'name' => 'YouTube',
                'logo' => 'youtube',
                'headline' => 'Chaines YouTube',
                'description' => 'Chaines YouTube monetisees ou starter avec base d abonnes et historique propre.',
                'keywords' => ['youtube', 'chaine', 'channel'],
                'fallback_count' => '30+',
                'metric' => 'AdSense & contenu',
            ],
        ];
    }

    /**
     * Compte les produits disponibles par plateforme.
     */
    private function platformCounts(Collection $products, array $platforms): array
    {
        $counts = [];

        foreach ($platforms as $slug => $platform) {
            $counts[$slug] = $this->filterProductsByPlatform($products, $platform['keywords'])->count();
        }

        return $counts;
    }

    /**
     * Filtre les produits par mots-cles presents dans le titre, slug ou description.
     */
    private function filterProductsByPlatform(Collection $products, array $keywords): Collection
    {
        return $products->filter(function (Product $product) use ($keywords): bool {
            $haystack = Str::lower($product->title . ' ' . $product->slug . ' ' . $product->description);

            foreach ($keywords as $keyword) {
                if (str_contains($haystack, Str::lower($keyword))) {
                    return true;
                }
            }

            return false;
        })->values();
    }

    /**
     * Page contact publique.
     */
    public function contact(): View
    {
        return view('pages.contact');
    }

    /**
     * Redirige les visiteurs vers la connexion avant d'ouvrir un ticket.
     */
    public function contactSubmit(): RedirectResponse
    {
        return redirect()
            ->route('login')
            ->withErrors(['contact' => 'Connectez-vous pour contacter le support.']);
    }

    /**
     * Catalogue public des formations et services.
     */
    public function catalog(Request $request): View
    {
        $products = Product::active()
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')->toString()))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%' . $request->string('search')->toString() . '%';

                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', $search)
                        ->orWhere('description', 'like', $search);
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.catalog', compact('products'));
    }

    /**
     * Detail public d'un produit actif.
     */
    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('pages.product-detail', compact('product'));
    }

    /**
     * Redirige un client connecte vers la page d'achat Chariow.
     */
    public function buy(Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        if (! $product->hasChariowCheckout()) {
            return redirect()
                ->route('products.show', $product)
                ->withErrors(['product' => 'Ce produit sera disponible des que le lien Chariow sera configure.']);
        }

        return redirect()->away($product->chariow_checkout_url);
    }
}
