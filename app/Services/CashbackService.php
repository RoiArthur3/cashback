<?php
namespace App\Services;

use App\Models\Commande;

class CashbackService
{
  public static function split(Commande $commande): array
    {
        $gross = (int) $commande->cashback_fcfa;
        if ($gross <= 0) {
            return ['client'=>0,'commercial'=>0,'parrain'=>0,'cbm'=>0];
        }

        $hasCommercial = (bool) optional($commande->boutique)->user_id;
        $hasParrain    = (bool) optional($commande->user)->parrain_id;

        // % business
        $pct = [
            'client'     => 50,
            'commercial' => $hasCommercial ? 10 : 0,
            'parrain'    => $hasParrain ? 10 : 0,
        ];
        $pct['cbm'] = max(0, 100 - ($pct['client'] + $pct['commercial'] + $pct['parrain']));

        // 1) part exacte, 2) plancher + restes
        $alloc = []; $rema = []; $sumFloor = 0;
        foreach ($pct as $role => $p) {
            $exact = $gross * ($p / 100);
            $floor = (int) floor($exact);
            $alloc[$role] = $floor;
            $rema[$role]  = $exact - $floor;   // reste décimal
            $sumFloor += $floor;
        }

        $left = $gross - $sumFloor; // unités à distribuer

        if ($left > 0) {
            // PHASE A : donner 1 d'abord aux partenaires qui ont un reste > 0
            foreach (['commercial','parrain'] as $r) {
                if ($left <= 0) break;
                if (($pct[$r] ?? 0) > 0 && ($rema[$r] ?? 0) > 0) {
                    $alloc[$r] += 1;
                    $left -= 1;
                }
            }

            if ($left > 0) {
                // PHASE B : distribuer le reliquat selon reste décroissant avec priorité
                $priority = ['commercial'=>3, 'parrain'=>2, 'client'=>1, 'cbm'=>0];
                $roles = array_keys($pct);
                usort($roles, function($a,$b) use($rema,$priority){
                    $d = ($rema[$b] <=> $rema[$a]);          // reste desc
                    return $d !== 0 ? $d : ($priority[$b] <=> $priority[$a]); // tie → priorité
                });

                foreach ($roles as $r) {
                    if ($left <= 0) break;
                    if (($pct[$r] ?? 0) <= 0) continue;
                    $alloc[$r] += 1;
                    $left -= 1;
                }
            }
        }

        // sécurité
        $sum = array_sum($alloc);
        if ($sum !== $gross) $alloc['cbm'] += ($gross - $sum);

        return [
            'client'     => (int)$alloc['client'],
            'commercial' => (int)$alloc['commercial'],
            'parrain'    => (int)$alloc['parrain'],
            'cbm'        => (int)$alloc['cbm'],
        ];
    }
}
