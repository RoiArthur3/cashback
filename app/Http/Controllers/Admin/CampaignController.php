<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('advertiser')
            ->latest()
            ->paginate(15);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $advertisers = User::where('role', 'advertiser')->get();
        return view('admin.campaigns.create', compact('advertisers'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateCampaign($request);
        
        $campaign = new Campaign($validated);
        $campaign->calculateFinalPrice();
        $campaign->save();

        return redirect()
            ->route('admin.campaigns.show', $campaign)
            ->with('success', 'Campagne créée avec succès.');
    }

    public function show(Campaign $campaign)
    {
        $campaign->load('advertiser');
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        $advertisers = User::where('role', 'advertiser')->get();
        return view('admin.campaigns.edit', compact('campaign', 'advertisers'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $this->validateCampaign($request);
        
        $campaign->fill($validated);
        $campaign->calculateFinalPrice();
        $campaign->save();

        return redirect()
            ->route('admin.campaigns.show', $campaign)
            ->with('success', 'Campagne mise à jour avec succès.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        
        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Campagne supprimée avec succès.');
    }

    public function approve(Campaign $campaign)
    {
        $campaign->status = Campaign::STATUS_ACTIVE;
        $campaign->save();

        // TODO: Envoyer une notification à l'annonceur

        return back()->with('success', 'Campagne approuvée avec succès.');
    }

    public function reject(Request $request, Campaign $campaign)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $campaign->status = Campaign::STATUS_REJECTED;
        $campaign->rejection_reason = $request->rejection_reason;
        $campaign->save();

        // TODO: Envoyer une notification à l'annonceur avec la raison

        return back()->with('success', 'Campagne rejetée avec succès.');
    }

    public function calculatePrice(Request $request)
    {
        $validated = $this->validateCalculation($request);
        
        $campaign = new Campaign($validated);
        $finalPrice = $campaign->calculateFinalPrice();
        
        return response()->json([
            'success' => true,
            'final_price' => $finalPrice,
            'formatted_price' => number_format($finalPrice, 0, ',', ' ') . ' FCFA',
            'total_budget' => number_format($campaign->total_budget, 0, ',', ' ') . ' FCFA',
            'daily_budget' => number_format($campaign->daily_budget, 0, ',', ' ') . ' FCFA',
            'estimated_reach' => $campaign->estimated_reach,
            'days' => $campaign->start_date->diffInDays($campaign->end_date) + 1,
        ]);
    }

    protected function validateCampaign(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'advertiser_id' => 'required|exists:users,id',
            'base_price' => 'required|numeric|min:1000',
            'targeting_criteria' => 'required|array',
            'targeting_criteria.recent_activity' => 'sometimes|array',
            'targeting_criteria.recent_activity.reach' => 'sometimes|integer|min:0',
            'targeting_criteria.age_range' => 'sometimes|array',
            'targeting_criteria.age_range.min' => 'sometimes|integer|min:13|max:100',
            'targeting_criteria.age_range.max' => 'sometimes|integer|min:13|max:100|gte:targeting_criteria.age_range.min',
            'targeting_criteria.location_type' => 'sometimes|in:neighborhood,city',
            'targeting_criteria.profession' => 'sometimes|string',
            'targeting_criteria.interests' => 'sometimes|array',
            'targeting_criteria.interests.*' => 'string',
            'channels' => 'required|array|min:1',
            'channels.*' => 'in:' . implode(',', array_keys(Campaign::getChannelMultipliers())),
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:' . implode(',', [
                Campaign::STATUS_DRAFT,
                Campaign::STATUS_PENDING,
                Campaign::STATUS_ACTIVE,
                Campaign::STATUS_PAUSED,
                Campaign::STATUS_COMPLETED,
                Campaign::STATUS_REJECTED,
            ]),
        ]);
    }

    protected function validateCalculation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'base_price' => 'required|numeric|min:1000',
            'targeting_criteria' => 'required|array',
            'channels' => 'required|array|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return $validator->validated();
    }
}
