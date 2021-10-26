<?php

namespace App\Custom\Functions;

use Illuminate\Support\Str;

class Pterodactyl
{
    public static function create_user($user)
    {
        $pterodactyl_username = strtolower(Str::random(7));
        $pterodactyl_password = Str::random(16);
        $ch = curl_init("https://" . env('PTERODACTYL_FQDN') . "/api/application/users");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . env('PTERODACTYL_APPLICATION_KEY'),
            "Content-Type: application/json",
            "Accept: Application/vnd.pterodactyl.v1+json"
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            "username" => $pterodactyl_username,
            "email" => $user->email,
            "first_name" => 'A',
            "last_name" => 'User',
            "password" => $pterodactyl_password,
        )));
        $pterodactyl_result = curl_exec($ch);
        curl_close($ch);
        if (json_decode($pterodactyl_result, true)['object'] == "user") {
            $user->panel_acc = json_decode($pterodactyl_result, true)['attributes']['id'];
            $user->save();
            return array('username' => $pterodactyl_username, 'password' => $pterodactyl_password);
        } else {
            return false;
        }
    }
}
