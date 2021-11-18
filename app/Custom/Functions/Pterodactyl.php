<?php

namespace App\Custom\Functions;

use App\Models\User;
use Illuminate\Support\Str;

class Pterodactyl
{
    public static function create_user(User $user)
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

    public static function get_nodes()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://" . env('PTERODACTYL_FQDN') . "/api/application/nodes");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . env('PTERODACTYL_APPLICATION_KEY');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $pterodactyl_result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $pterodactyl_result = json_decode($pterodactyl_result, true);
        return $pterodactyl_result;

        /*
        {
            "object": "list",
            "data": [
                {
                "object": "node",
                "attributes": {
                    "id": 1,
                    "uuid": "1046d1d1-b8ef-4771-82b1-2b5946d33397",
                    "public": true,
                    "name": "Test",
                    "description": "Test",
                    "location_id": 1,
                    "fqdn": "pterodactyl.file.properties",
                    "scheme": "https",
                    "behind_proxy": false,
                    "maintenance_mode": false,
                    "memory": 2048,
                    "memory_overallocate": 0,
                    "disk": 5000,
                    "disk_overallocate": 0,
                    "upload_size": 100,
                    "daemon_listen": 8080,
                    "daemon_sftp": 2022,
                    "daemon_base": "\/srv\/daemon-data",
                    "created_at": "2019-12-22T04:44:51+00:00",
                    "updated_at": "2019-12-22T04:44:51+00:00"
                }
                },
                {
                "object": "node",
                "attributes": {
                    "id": 3,
                    "uuid": "71b15cf6-909a-4b60-aa04-abb4c8f98f61",
                    "public": true,
                    "name": "2",
                    "description": "e",
                    "location_id": 1,
                    "fqdn": "pterodactyl.file.properties",
                    "scheme": "https",
                    "behind_proxy": false,
                    "maintenance_mode": false,
                    "memory": 100,
                    "memory_overallocate": 0,
                    "disk": 100,
                    "disk_overallocate": 0,
                    "upload_size": 100,
                    "daemon_listen": 8080,
                    "daemon_sftp": 2022,
                    "daemon_base": "\/var\/lib\/pterodactyl\/volumes",
                    "created_at": "2020-06-23T04:50:37+00:00",
                    "updated_at": "2020-06-23T04:50:37+00:00"
                }
                }
            ],
            "meta": {
                "pagination": {
                "total": 2,
                "count": 2,
                "per_page": 50,
                "current_page": 1,
                "total_pages": 1,
                "links": {}
                }
            }
        }
        */
    }

    public static function get_node($id)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://" . env('PTERODACTYL_FQDN') . "/api/application/nodes/" . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . env('PTERODACTYL_APPLICATION_KEY');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $pterodactyl_result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $pterodactyl_result = json_decode($pterodactyl_result, true);
        return $pterodactyl_result;

        /*

        {
            "object": "node",
            "attributes": {
                "id": 1,
                "uuid": "1046d1d1-b8ef-4771-82b1-2b5946d33397",
                "public": true,
                "name": "Test",
                "description": "Test",
                "location_id": 1,
                "fqdn": "pterodactyl.file.properties",
                "scheme": "https",
                "behind_proxy": false,
                "maintenance_mode": false,
                "memory": 2048,
                "memory_overallocate": 0,
                "disk": 5000,
                "disk_overallocate": 0,
                "upload_size": 100,
                "daemon_listen": 8080,
                "daemon_sftp": 2022,
                "daemon_base": "\/srv\/daemon-data",
                "created_at": "2019-12-22T04:44:51+00:00",
                "updated_at": "2019-12-22T04:44:51+00:00"
            }
            }
        */
    }
}
