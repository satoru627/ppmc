<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Insere un admin initial et des offres de demo.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        if ($adminEmail && $adminPassword && ! User::where('email', $adminEmail)->exists()) {
            User::forceCreate([
                'name' => env('ADMIN_NAME', 'Administrateur'),
                'email' => $adminEmail,
                'phone' => env('ADMIN_PHONE', '+237600000000'),
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
            ]);
        }

        if (Product::query()->exists()) {
            return;
        }

        $products = [
            [
                'title' => 'Masterclass Trading Crypto',
                'description' => 'Strategie de trading, gestion du risque, lecture du marche et plan de progression pour debuter serieusement.',
                'type' => 'formation',
                'price' => 150000,
                'image' => null,
            ],
            [
                'title' => 'TikTok Monetisation Blueprint',
                'description' => 'Systeme complet pour structurer un compte TikTok, produire du contenu court et transformer l audience en revenus.',
                'type' => 'formation',
                'price' => 120000,
                'image' => null,
            ],
            [
                'title' => 'Audit Business Digital',
                'description' => 'Analyse de votre offre, tunnel, contenu et positionnement avec recommandations executables.',
                'type' => 'service',
                'price' => 85000,
                'image' => null,
            ],
            [
                'title' => 'Compte TikTok monetise',
                'description' => 'Compte TikTok pret a generer des revenus avec audience active, historique propre et transfert accompagne.',
                'type' => 'service',
                'price' => 270000,
                'image' => null,
            ],
            [
                'title' => 'Page Facebook monetisee',
                'description' => 'Page Facebook eligible a la monetisation, ideale pour reels, contenu viral et revenus publicitaires.',
                'type' => 'service',
                'price' => 210000,
                'image' => null,
            ],
            [
                'title' => 'Chaine YouTube monetisee',
                'description' => 'Chaine YouTube avec programme partenaire actif, abonnes reels et base prete pour publication.',
                'type' => 'service',
                'price' => 390000,
                'image' => null,
            ],
            [
                'title' => 'Compte Instagram Theme Page',
                'description' => 'Compte Instagram avec audience de niche pret pour brand deals et produits digitaux.',
                'type' => 'service',
                'price' => 252000,
                'image' => null,
            ],
            [
                'title' => 'Compte TikTok 10K',
                'description' => 'Compte TikTok avec 10 000 abonnes, non monetise, ideal pour lancer une niche.',
                'type' => 'service',
                'price' => 72000,
                'image' => null,
            ],
            [
                'title' => 'Chaine YouTube 1K',
                'description' => 'Chaine YouTube avec 1 000 abonnes, non monetisee, parfaite pour demarrer plus vite.',
                'type' => 'service',
                'price' => 108000,
                'image' => null,
            ],
            [
                'title' => 'Compte TikTok 25K',
                'description' => 'Compte TikTok avec 25 000 abonnes, adapte aux niches lifestyle, business ou divertissement.',
                'type' => 'service',
                'price' => 132000,
                'image' => null,
            ],
            [
                'title' => 'YouTube Channel 5K Growth',
                'description' => 'Chaine YouTube avec 5 000 abonnes organiques, base solide pour publication reguliere.',
                'type' => 'service',
                'price' => 210000,
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                ...$product,
                'slug' => Str::slug($product['title']),
                'is_active' => true,
            ]);
        }
    }
}
