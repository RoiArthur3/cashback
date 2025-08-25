<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    const COOKIE_NAME = 'referrer_code';
    const COOKIE_DAYS = 30;

    public function capture(string $code)
    {
        $ref = User::where('referral_code', $code)->first();
        if ($ref) {
            session(['referrer_code' => $code]);
            return redirect()->route('register')
                ->withCookie(cookie()->make('referrer_code', $code, 60*24*30))
                ->with('success', 'Code parrain enregistré. Inscrivez-vous 👍');
        }
        return redirect()->route('register')->with('error','Lien d’invitation invalide.');
    }
}
