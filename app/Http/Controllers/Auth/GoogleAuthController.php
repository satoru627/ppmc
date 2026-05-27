<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirige le visiteur vers Google.
     */
    public function redirect(): RedirectResponse
    {
        if (! config('services.google.client_id') || ! config('services.google.client_secret')) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Connexion Google non configuree. Verifiez GOOGLE_CLIENT_ID et GOOGLE_CLIENT_SECRET dans le fichier .env.']);
        }

        return Socialite::driver('google')
            ->redirectUrl(config('services.google.redirect'))
            ->redirect();
    }

    /**
     * Connecte ou cree le compte client apres retour Google.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(config('services.google.redirect'))
                ->user();
        } catch (InvalidStateException) {
            try {
                $googleUser = Socialite::driver('google')
                    ->redirectUrl(config('services.google.redirect'))
                    ->stateless()
                    ->user();
            } catch (Throwable $exception) {
                report($exception);

                return redirect()
                    ->route('login')
                    ->withErrors(['email' => 'Connexion Google expiree ou session invalide. Reessayez depuis le bouton Google.']);
            }
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Connexion Google annulee ou impossible.']);
        }

        $email = $googleUser->getEmail();

        if (! $email) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Google ne fournit pas d adresse email pour ce compte.']);
        }

        $user = User::query()
            ->where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if ($user?->is_blocked) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Votre compte est bloque. Contactez le support.']);
        }

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: Str::before($email, '@'),
                'email' => $email,
                'password' => Hash::make(Str::random(40)),
                'role' => 'client',
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
            ]);
        } elseif (! $user->google_id) {
            $user->forceFill([
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
            ])->save();
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->intended(
            $user->isAdmin() ? route('admin.dashboard') : route('client.home')
        );
    }
}
