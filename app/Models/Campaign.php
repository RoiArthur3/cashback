<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'advertiser_id',
        'base_price',
        'targeting_criteria',
        'channels',
        'final_price',
        'estimated_reach',
        'start_date',
        'end_date',
        'status',
        'total_budget',
        'daily_budget',
    ];

    protected $casts = [
        'targeting_criteria' => 'array',
        'channels' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'base_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'total_budget' => 'decimal:2',
        'daily_budget' => 'decimal:2',
    ];

    // Constantes pour les canaux
    public const CHANNEL_WEB = 'web';
    public const CHANNEL_MOBILE_WEB = 'mobile_web';
    public const CHANNEL_APP = 'app';
    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_POPUP = 'popup';

    // Constantes pour les statuts
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PAUSED = 'paused';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_REJECTED = 'rejected';

    // Méthodes utilitaires
    public static function getChannelMultipliers(): array
    {
        return [
            self::CHANNEL_WEB => 1.0,
            self::CHANNEL_MOBILE_WEB => 1.1,
            self::CHANNEL_APP => 1.2,
            self::CHANNEL_EMAIL => 1.15,
            self::CHANNEL_POPUP => 1.25,
        ];
    }

    public function calculateFinalPrice(): float
    {
        $basePrice = $this->base_price;
        $totalMultiplier = 1.0;
        $criteria = $this->targeting_criteria;

        // 1. Calcul des majorations par critère
        // Connexion récente
        if (isset($criteria['recent_activity'])) {
            $reach = $criteria['recent_activity']['reach'] ?? 0;
            if ($reach > 500) {
                $totalMultiplier += 0.30;
            } elseif ($reach >= 100) {
                $totalMultiplier += 0.15;
            } else {
                $totalMultiplier += 0.05;
            }
        }

        // Tranche d'âge
        if (isset($criteria['age_range'])) {
            $ageRange = $criteria['age_range'];
            $ageDiff = $ageRange['max'] - $ageRange['min'];
            $totalMultiplier += $ageDiff <= 5 ? 0.20 : 0.10;
        }

        // Zone géographique
        if (isset($criteria['location_type'])) {
            $totalMultiplier += $criteria['location_type'] === 'neighborhood' ? 0.25 : 0.10;
        }

        // Statut professionnel
        if (isset($criteria['profession'])) {
            $totalMultiplier += 0.15;
        }

        // Centres d'intérêt
        if (isset($criteria['interests']) && is_array($criteria['interests'])) {
            $interestCount = count($criteria['interests']);
            if ($interestCount >= 3) {
                $totalMultiplier += 0.20;
            } elseif ($interestCount > 0) {
                $totalMultiplier += 0.10;
            }
        }

        // 2. Application des multiplicateurs de canaux
        $channelMultiplier = 1.0;
        $channelMultipliers = self::getChannelMultipliers();
        
        foreach ($this->channels as $channel) {
            $channelMultiplier = max($channelMultiplier, $channelMultipliers[$channel] ?? 1.0);
        }

        // 3. Calcul du prix final
        $this->final_price = round($basePrice * $totalMultiplier * $channelMultiplier, 2);
        
        // 4. Calcul du budget total basé sur la durée
        $days = $this->start_date->diffInDays($this->end_date) + 1;
        $this->total_budget = round($this->final_price * $days, 2);
        
        // 5. Budget journalier moyen
        $this->daily_budget = round($this->total_budget / $days, 2);
        
        return $this->final_price;
    }

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function getStatusBadgeAttribute(): string
    {
        $statuses = [
            self::STATUS_DRAFT => 'bg-gray-100 text-gray-800',
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_ACTIVE => 'bg-green-100 text-green-800',
            self::STATUS_PAUSED => 'bg-blue-100 text-blue-800',
            self::STATUS_COMPLETED => 'bg-purple-100 text-purple-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
        ];

        return $statuses[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->final_price, 0, ',', ' ') . ' FCFA';
    }

    public function getFormattedBudgetAttribute(): string
    {
        return number_format($this->total_budget, 0, ',', ' ') . ' FCFA';
    }

    public function getFormattedPeriodAttribute(): string
    {
        return $this->start_date->format('d/m/Y') . ' - ' . $this->end_date->format('d/m/Y');
    }
}
