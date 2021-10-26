<?php

namespace App\Custom\Functions;

class Discord
{
    public static function join_guild($user_id, $access_token, $guild_id)
    {
        $ch = curl_init("https://discord.com/api/guilds/" . $guild_id . "/members/" . $user_id);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bot ' . env('DISCORD_BOT_TOKEN');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            "access_token" => $access_token,
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);
    }

    public static function add_role($user_id, $guild_id, $role_id)
    {
        $ch = curl_init("https://discord.com/api/guilds/" . $guild_id . "/members/" . $user_id . "/roles/" . $role_id);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bot ' . env('DISCORD_BOT_TOKEN');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            "access_token" => session('access_token')
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);
    }

    public static function check_if_exists_in_guild($user_guilds, $guild_id)
    {
        $isInServer = false;
        foreach ($user_guilds as $guild) {
            if (!empty($guild->id)) {
                if ($guild->id == $guild_id) {
                    $isInServer = true;
                }
            }
        }
        return $isInServer;
    }
}
