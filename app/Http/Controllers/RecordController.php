<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecordController extends Controller
{
    protected $api_token;
    protected $base_url = 'https://api.cloudflare.com/client/v4';

    public function __construct()
    {
        $this->api_token = env('CLOUDFLARE_API_TOKEN');
    }

    public function store(Request $request, $zone_id)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|string',
                'name' => 'required|string',
                'content' => 'required|string',
                'ttl' => 'required|numeric',
                'proxied' => 'required'
            ]);

            $data = [
                'type' => $validated['type'],
                'name' => $validated['name'],
                'content' => $validated['content'],
                'ttl' => (int) $validated['ttl'],
                'proxied' => $validated['proxied'] === '1' || $validated['proxied'] === 'true' || $validated['proxied'] === true
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token,
                'Content-Type' => 'application/json'
            ])->post($this->base_url . '/zones/' . $zone_id . '/dns_records', $data);

            $result = $response->json();

            if ($response->successful() && $result['success']) {
                return redirect()->back()->with('success', 'DNS Record added successfully');
            }

            if (isset($result['errors']) && count($result['errors']) > 0) {
                $errorMessage = $result['errors'][0]['message'];
                return redirect()->back()->with('error', 'Failed to add DNS Record: ' . $errorMessage);
            }

            return redirect()->back()->with('error', 'Failed to add DNS Record');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $zone_id, $record_id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'type' => 'required|string',
                'name' => 'required|string',
                'content' => 'required|string',
                'ttl' => 'required|numeric',
                'proxied' => 'required'
            ]);

            // Cek record yang akan diupdate
            $checkResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token,
                'Content-Type' => 'application/json'
            ])->get($this->base_url . '/zones/' . $zone_id . '/dns_records/' . $record_id);

            if (!$checkResponse->successful()) {
                return redirect()->back()->with('error', 'DNS Record not found');
            }

            // Format data untuk update
            $data = [
                'type' => $validated['type'],
                'name' => $validated['name'],
                'content' => $validated['content'],
                'ttl' => (int) $validated['ttl'],
                'proxied' => $validated['proxied'] === '1' || $validated['proxied'] === 'true' || $validated['proxied'] === true
            ];

            // Kirim request update
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token,
                'Content-Type' => 'application/json'
            ])->put($this->base_url . '/zones/' . $zone_id . '/dns_records/' . $record_id, $data);

            $result = $response->json();

            // Debug response jika diperlukan
            \Log::info('Cloudflare Update Response:', $result);

            if ($response->successful() && isset($result['success']) && $result['success']) {
                return redirect()->back()->with('success', 'DNS Record updated successfully');
            }

            if (isset($result['errors']) && count($result['errors']) > 0) {
                $errorMessage = $result['errors'][0]['message'];
                return redirect()->back()->with('error', 'Failed to update DNS Record: ' . $errorMessage);
            }

            return redirect()->back()->with('error', 'Failed to update DNS Record');

        } catch (\Exception $e) {
            \Log::error('DNS Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($zone_id, $record_id)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->api_token,
                'Content-Type' => 'application/json'
            ])->delete($this->base_url . '/zones/' . $zone_id . '/dns_records/' . $record_id);

            $result = $response->json();

            if ($response->successful() && $result['success']) {
                return redirect()->back()->with('success', 'DNS Record deleted successfully');
            }

            if (isset($result['errors']) && count($result['errors']) > 0) {
                $errorMessage = $result['errors'][0]['message'];
                return redirect()->back()->with('error', 'Failed to delete DNS Record: ' . $errorMessage);
            }

            return redirect()->back()->with('error', 'Failed to delete DNS Record');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
} 