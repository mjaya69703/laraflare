<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DomainController extends Controller
{
    protected $api_token;
    protected $base_url = 'https://api.cloudflare.com/client/v4';

    public function __construct()
    {
        $this->api_token = env('CLOUDFLARE_API_TOKEN');
    }

    public function index()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Content-Type' => 'application/json'
        ])->get($this->base_url . '/zones');

        $domains = [];
        if ($response->successful()) {
            $domains = $response->json()['result'];
        }

        return view('domains.index', compact('domains'));
    }

    public function records($zone_id)
    {
        // Get Domain Details
        $domainResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Content-Type' => 'application/json'
        ])->get($this->base_url . '/zones/' . $zone_id);

        // Get DNS Records
        $recordsResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->api_token,
            'Content-Type' => 'application/json'
        ])->get($this->base_url . '/zones/' . $zone_id . '/dns_records');

        $domain = $domainResponse->json()['result'];
        $records = $recordsResponse->json()['result'];

        return view('domains.records', compact('domain', 'records'));
    }
} 