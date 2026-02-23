<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MixpostIntegrationService
{
    private $apiUrl;
    private $apiToken;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('services.mixpost.url', env('MIXPOST_API_URL')), '/');
        $this->apiToken = config('services.mixpost.token', env('MIXPOST_API_TOKEN'));
    }

    /**
     * Create a user and workspace in Mixpost via API.
     */
    public function createMixpostUser(Registration $registration)
    {
        try {
            // 1. Create User
            /** @var \Illuminate\Http\Client\Response $userResponse */
            $userResponse = Http::withToken($this->apiToken)
                ->post("{$this->apiUrl}/panel/users", [
                    'name' => $registration->first_name . ' ' . $registration->last_name,
                    'email' => $registration->email,
                    'password' => 'password', // Temporary password or we can use a random one
                    'password_confirmation' => 'password',
                    'is_admin' => false,
                ]);

            if ($userResponse->failed()) {
                // If user already exists, we might get a 422. Let's handle it.
                if ($userResponse->status() === 422) {
                    $json = $userResponse->json();
                    if (isset($json['errors']['email'])) {
                        Log::info('User already exists in Mixpost: ' . $registration->email);
                        // Ideally we'd have a 'Get User by Email' endpoint to find the ID.
                        // For now, let's assume we can't proceed or we just log it.
                    }
                } else {
                    Log::error('Failed to create Mixpost user: ' . $userResponse->body());
                    return false;
                }
            }

            $userData = $userResponse->json();
            $userId = $userData['id'] ?? null;

            if (!$userId) {
                // If the user already exists, we might not get an ID back in a 422 response.
                // We'd need a way to fetch the user ID by email.
                Log::error('Create user response did not return an ID for ' . $registration->email);
                return false;
            }

            Log::info('Created user in Mixpost with ID: ' . $userId);

            // 2. Create Workspace
            /** @var \Illuminate\Http\Client\Response $workspaceResponse */
            $workspaceResponse = Http::withToken($this->apiToken)
                ->post("{$this->apiUrl}/panel/workspaces", [
                    'name' => 'Default Workspace',
                    'hex_color' => '#3b82f6',
                    'owner_id' => $userId,
                    'access_status' => 'unlimited',
                ]);

            if ($workspaceResponse->failed()) {
                Log::error('Failed to create Mixpost workspace: ' . $workspaceResponse->body());
                return false;
            }

            Log::info('Created workspace in Mixpost for user ' . $userId);

            return true;
        } catch (\Exception $e) {
            Log::error('Mixpost API integration error: ' . $e->getMessage());
            return false;
        }
    }
}
