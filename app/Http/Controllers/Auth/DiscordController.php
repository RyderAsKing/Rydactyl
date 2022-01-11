<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Custom\Functions\Notify;
use App\Custom\Functions\Discord;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Custom\Functions\Pterodactyl;
use Illuminate\Support\Facades\Session;

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
        $this->tokenData["redirect_uri"] = env('APP_URL') . '/login/token';

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

        $userGuilds = Http::withToken($accessTokenData->access_token)->get($this->apiURLBase . "/guilds");
        $userGuilds = json_decode($userGuilds);

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

        if (Discord::check_if_exists_in_guild($userGuilds, env('DISCORD_SERVER_ID')) == false) {
            Discord::join_guild($userData->id, $accessTokenData->access_token, env('DISCORD_SERVER_ID'));
            Discord::add_role($userData->id, env('DISCORD_SERVER_ID'), env('DISCORD_AUTO_ROLE_ID'));
        }

        Session::put('access_token', $accessTokenData->access_token);
        Session::put('user', $userData);


        $user->last_login = Carbon::now();
        $user->save();

        $pterodactyl_information = [];
        if ($user->panel_acc == null || $user->panel_acc == 0) {
            // Create pterodactyl account
            $pterodactyl_information = Pterodactyl::create_user($user);
            if ($pterodactyl_information == false) {
                $user->delete();
                return redirect()->route("home")->with('error', 'There was an error creating your panel account. Please contact support.');
            }
        }

        Auth::login($user);

        if ($pterodactyl_information != null || $pterodactyl_information != false) {
            Session::put('pterodactyl_information', $pterodactyl_information);
            Notify::send_notification($user, 'Panel Information', 'Your pterodactyl username is ' . $pterodactyl_information['username'] . ' and your password is ' . $pterodactyl_information['password']);
            return redirect()->route("dashboard");
        } else {
            return redirect()->route("dashboard");
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect()->route("home");
    }
}
