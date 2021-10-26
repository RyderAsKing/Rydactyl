<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DiscordController extends Controller
{
    //
    protected $tokenURL = "https://discord.com/api/oauth2/token";
    protected $apiURLBase = "https://discord.com/api/users/@me";
    protected $tokenData = [
        "client_id" => NULL,
        "client_secret" => NULL,
        "grant_type" => "authorization_code",
        "code" => NULL,
        "redirect_uri" => NULL,
        "scope" => "identifiy guilds guilds.join email"
    ];

    public function build_url()
    {
        $params = array(
            'client_id' => env('DISCORD_CLIENT_ID'),
            'redirect_uri' => env('APP_URL') . '/login/token',
            'response_type' => 'code',
            'scope' => 'identify guilds guilds.join email'
        );

        return redirect('https://discord.com/api/oauth2/authorize' . '?' . http_build_query($params));
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route("dashboard");
        };
        if ($request->missing("code") && $request->missing("access_token")) {
            return redirect()->route("dashboard");
        };

        $this->tokenData["client_id"] = env("DISCORD_CLIENT_ID");
        $this->tokenData["client_secret"] = env("DISCORD_CLIENT_SECRET");
        $this->tokenData["code"] = $request->get("code");
        $this->tokenData["redirect_uri"] = env("DISCORD_REDIRECT_URI");

        $client = new Client();

        try {
            $accessTokenData = $client->post($this->tokenURL, ["form_params" => $this->tokenData]);
            $accessTokenData = json_decode($accessTokenData->getBody());
        } catch (\GuzzleHttp\Exception\ClientException $error) {
            return redirect()->route("dashboard");
        };

        $userData = Http::withToken($accessTokenData->access_token)->get($this->apiURLBase);
        if ($userData->clientError() || $userData->serverError()) {
            return redirect()->route("dashboard");
        };

        $userData = json_decode($userData);
        dd($userData);
        $user = User::updateOrCreate(
            [
                'discord_id' => $userData->id,
            ],
            [
                'email' => $userData->email,
                'username' => $userData->username,
                'discriminator' => $userData->discriminator,
                'refresh_token' => $accessTokenData->refresh_token,
            ]
        );

        Auth::login($user);

        return redirect()->route("dashboard");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect()->route("home");
    }
}
