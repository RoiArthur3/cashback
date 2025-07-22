<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommercantController extends Controller
{
    public function index()
    {
        return view('commercant.dashboard');
    }
    // Ajoutez ici les actions spécifiques au commerçant
}
