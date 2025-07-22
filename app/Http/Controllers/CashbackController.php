<?php
namespace App\Http\Controllers;

use App\Models\Cashback;
use Illuminate\Http\Request;

class CashbackController extends Controller
{
    public function index()
    {
        $cashbacks = Cashback::with('boutique')->get();
        return view('cashbacks.index', compact('cashbacks'));
    }
}
