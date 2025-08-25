<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Magasin;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Response;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeController extends Controller
{
    public function generateQRCode($boutiqueSlug)
    {
        // Vérifie si la boutique existe
        $boutique = Boutique::where('slug', $boutiqueSlug)->firstOrFail();

        // Génère l'URL de la boutique
        $url = url("/shop/$boutiqueSlug");

        // Crée un QR Code
        $qrCode = new QrCode($url);

        // Crée un écrivain pour le QR Code (PNG)
        $writer = new PngWriter();

        // Génère le QR Code en tant qu'image PNG
        $result = $writer->write($qrCode);

        // Retourne l'image du QR Code
        return new Response($result->getString(), 200, ['Content-Type' => 'image/png']);
    }
}
