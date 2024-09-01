<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InvoiceApiService
{
    protected $baseUrl = 'https://web-api.invoice-kohyo.nta.go.jp/1/';
    protected $appId;

    public function __construct()
    {
        $this->appId = config('services.invoice_api.app_id');
    }

    public function getInvoiceInfo($invoiceNumber)
    {
        $response = Http::get($this->baseUrl . 'num', [
            'id' => $this->appId,
            'number' => $invoiceNumber,
            'type' => '21',
            'history' => '0'
        ]);
        
        if ($response->failed()) {
            throw new \Exception('APIリクエストに失敗しました。');
        }

        return $response->json();
    }
}