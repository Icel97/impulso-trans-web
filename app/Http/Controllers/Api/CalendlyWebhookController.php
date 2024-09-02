<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CalendlyWebhookController extends Controller
{
    private $urlCalendly = 'https://api.calendly.com';
    private $token;

    public function __construct()
    {
        $this->token = env('CALENDLY_API_TOKEN');
    }


    private function getDataCalendly()
    {
        $endPoint = $this->urlCalendly . '/users/me';
        $client = new Client();

        $response = $client->get($endPoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function subscribeToWebhook(Request $request)
    {
        $dataCalendly = $this->getDataCalendly();
        $organization = $dataCalendly->resource->current_organization;
        $user = $dataCalendly->resource->uri;
        $webhook_url = 'https://d23f-177-232-84-202.ngrok-free.app/api/webhook/calendly';

        $client = new Client();

        $response = $client->post($this->urlCalendly . '/webhook_subscriptions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'url' => $webhook_url,
                'events' => [
                    'invitee.created',
                    'invitee.canceled',
                    'routing_form_submission.created',
                    'invitee_no_show.created',
                    'invitee_no_show.deleted'
                ],
                'organization' => $organization,
                'user' => $user,
                'scope' => 'user',
            ],
        ]);

        return response()->json([
            'status' => 'success',
            'response' => json_decode($response->getBody()->getContents()),
        ]);
    }

    public function getListWebhook()
    {
        $dataCalendly = $this->getDataCalendly();
        $organization = $dataCalendly->resource->current_organization;
        $user = $dataCalendly->resource->uri;
        $client = new Client();

        $response = $client->get($this->urlCalendly . '/webhook_subscriptions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'organization' => $organization,
                'user' => $user,
                'scope' => 'user',
            ],
        ]);

        return response()->json([
            'status' => 'success',
            'response' => json_decode($response->getBody()->getContents()),
        ]);
    }

    public function handleWebhook(Request $request)
    {
        $event = $request->input('event');
        $payload = $request->input('payload');

        if ($event == 'invitee.created') {
            $this->handleInviteeCreated($payload);
        }

        return response()->json(['status' => 'success'], 200);
    }

    private function handleInviteeCreated($payload)
    {
        // Extrae la información necesaria del payload
        $eventUri = $payload['event'];
        $inviteeUri = $payload['invitee'];
        $name = $payload['invitee']['name'];
        $email = $payload['invitee']['email'];
        $startTime = $payload['event']['start_time'];
        $endTime = $payload['event']['end_time'];

        // try {
        //     // Guarda la información en la base de datos
        //     $appointment = Appointment::create([
        //         'event_uri' => $eventUri,
        //         'invitee_uri' => $inviteeUri,
        //         'name' => $name,
        //         'email' => $email,
        //         'start_time' => $startTime,
        //         'end_time' => $endTime,
        //     ]);
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Appointment created successfully.',
        //         'data' => $appointment
        //     ], 201);
        // } catch (\Exception $e) {
        //     // Respuesta de error
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Failed to create appointment.',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
    }
}
