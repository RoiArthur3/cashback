<?php
namespace App\Services;

use Exception;
use SoapClient;
use Illuminate\Support\Facades\Log;

class PaiementProService
{
    private string $wsdl;
    private string $merchantId;
    private string $secret;
    private string $processUrl;

    public function __construct()
    {
        $this->wsdl       = config('services.paiementpro.wsdl', env('PAIEMENTPRO_WSDL'));
        $this->merchantId = env('PAIEMENTPRO_MERCHANT_ID');
        $this->secret     = env('PAIEMENTPRO_SECRET');
        $this->processUrl = env('PAIEMENTPRO_PROCESS_URL');
    }

    public function client(): SoapClient
    {
        ini_set("soap.wsdl_cache_enabled", 0);
        return new SoapClient($this->wsdl, ['cache_wsdl' => WSDL_CACHE_NONE]);
    }

    /**
     * Calcule le hashcode demandé par Paiement Pro.
     * ⚠️ La formule exacte dépend de ton contrat/fiche technique.
     * Implémente ici la concaténation/ordre exacts fournis par Paiement Pro.
     */
    public function makeHashcode(array $payload): string
    {
        // EXEMPLE générique (à adapter à la doc fournie par Paiement Pro) :
        // $data = $this->merchantId.$payload['referenceNumber'].$payload['amount'].$payload['countryCurrencyCode'];
        // return hash_hmac('sha256', $data, $this->secret);
        return hash('sha256', 'TODO_SET_FORMULE'); // placeholder
    }

    /**
     * initTransact -> renvoie l'URL de redirection "processing_v2.php?sessionid=..."
     */
    public function initiate(array $params): string
    {
        if (!extension_loaded('soap')) {
            throw new \Exception('Extension SOAP non activée sur le serveur PHP.');
        }

        $client = new \SoapClient($this->wsdl, ['cache_wsdl' => WSDL_CACHE_NONE, 'exceptions' => true]);

        // hashcode obligatoire (cf. PDF)
        $params['hashcode'] = $this->makeHashcode($params);

        $resp = $client->initTransact($params);

        Log::info('PP initTransact', [
            'sent' => [
                'merchantId' => $params['merchantId'] ?? null,
                'referenceNumber' => $params['referenceNumber'] ?? null,
                'amount' => $params['amount'] ?? null,
                'countryCurrencyCode' => $params['countryCurrencyCode'] ?? null,
                'channel' => $params['channel'] ?? null,
            ],
            'resp' => $resp
        ]);

        if (!isset($resp->Code) || (int)$resp->Code !== 0 || empty($resp->Sessionid)) {
            $code = $resp->Code ?? 'NA';
            $desc = $resp->Description ?? 'Erreur init paiement';
            throw new \Exception("Init PaiementPro KO (Code={$code}) : {$desc}");
        }

        return $this->processUrl.'?sessionid='.$resp->Sessionid;
    }

}
