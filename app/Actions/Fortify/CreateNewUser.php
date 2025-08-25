<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'role_id' => 'required',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        // 1) Récupérer le code parrain depuis session/cookie
        $code = session('referrer_code') ?? request()->cookie('referrer_code');
        $parrain = $code ? User::where('referral_code', $code)->first() : null;

        // 2) Créer l'utilisateur (le referral_code sera généré par le modèle)
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'role_id' => $input['role_id'],
            'password' => Hash::make($input['password']),
            'parrain_id' => $parrain?->id,
            'referred_at'=> $parrain ? now() : null,
        ]);

        // 3) (Optionnel) nettoyer
        if ($parrain) {
            session()->forget('referrer_code');
            \Cookie::queue(\Cookie::forget('referrer_code'));
        }

        return $user;
    }
}
