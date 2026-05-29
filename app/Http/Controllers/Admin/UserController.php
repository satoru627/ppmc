<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Liste des utilisateurs.
     */
    public function index(Request $request): View
    {
        $users = User::withCount(['orders', 'supportTickets'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%' . $request->string('search')->toString() . '%';

                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', $search)
                        ->orWhere('email', 'like', $search)
                        ->orWhere('phone', 'like', $search);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Bloque ou debloque un utilisateur.
     */
    public function block(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->withErrors(['user' => 'Vous ne pouvez pas bloquer votre propre compte.']);
        }

        $user->forceFill(['is_blocked' => ! $user->is_blocked])->save();

        return back()->with('success', 'Statut utilisateur mis a jour.');
    }

    /**
     * Supprime un utilisateur.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->withErrors(['user' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        if ($user->orders()->exists() || $user->supportTickets()->exists()) {
            return back()->withErrors([
                'user' => 'Cet utilisateur possede un historique. Bloquez le compte au lieu de le supprimer.',
            ]);
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprime.');
    }
}
