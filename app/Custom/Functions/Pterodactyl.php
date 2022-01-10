<?php

namespace App\Custom\Functions;

use App\Models\Egg;
use App\Models\Node;
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

    // Nodes

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

    // Nests

    public static function get_nests()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://" . env('PTERODACTYL_FQDN') . "/api/application/nests");
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
                "object": "nest",
                "attributes": {
                    "id": 1,
                    "uuid": "58bde975-ec57-4af2-b241-1426ac6d6d59",
                    "author": "support@pterodactyl.io",
                    "name": "Minecraft",
                    "description": "Minecraft - the classic game from Mojang. With support for Vanilla MC, Spigot, and many others!",
                    "created_at": "2019-12-22T04:42:51+00:00",
                    "updated_at": "2019-12-22T04:42:51+00:00"
                }
                },
                {
                "object": "nest",
                "attributes": {
                    "id": 2,
                    "uuid": "5246d226-e8e8-46f5-b624-e99cf1a68c9a",
                    "author": "support@pterodactyl.io",
                    "name": "Source Engine",
                    "description": "Includes support for most Source Dedicated Server games.",
                    "created_at": "2019-12-22T04:42:51+00:00",
                    "updated_at": "2019-12-22T04:42:51+00:00"
                }
                },
                {
                "object": "nest",
                "attributes": {
                    "id": 3,
                    "uuid": "0eb05bf7-3a00-4b1d-bef5-a6d8d7375e44",
                    "author": "support@pterodactyl.io",
                    "name": "Voice Servers",
                    "description": "Voice servers such as Mumble and Teamspeak 3.",
                    "created_at": "2019-12-22T04:42:51+00:00",
                    "updated_at": "2019-12-22T04:42:51+00:00"
                }
                },
                {
                "object": "nest",
                "attributes": {
                    "id": 4,
                    "uuid": "e2a21c82-7175-4db0-9510-8d1ed525b2bf",
                    "author": "support@pterodactyl.io",
                    "name": "Rust",
                    "description": "Rust - A game where you must fight to survive.",
                    "created_at": "2019-12-22T04:42:51+00:00",
                    "updated_at": "2019-12-22T04:42:51+00:00"
                }
                }
            ],
            "meta": {
                "pagination": {
                "total": 4,
                "count": 4,
                "per_page": 50,
                "current_page": 1,
                "total_pages": 1,
                "links": {}
                }
            }
        }
        */
    }

    public static function get_nest($id)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://" . env('PTERODACTYL_FQDN') . "/api/application/nests/" . $id);
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
            "object": "nest",
            "attributes": {
                "id": 1,
                "uuid": "58bde975-ec57-4af2-b241-1426ac6d6d59",
                "author": "support@pterodactyl.io",
                "name": "Minecraft",
                "description": "Minecraft - the classic game from Mojang. With support for Vanilla MC, Spigot, and many others!",
                "created_at": "2019-12-22T04:42:51+00:00",
                "updated_at": "2019-12-22T04:42:51+00:00"
            }
        }
        */
    }

    // Eggs

    public static function get_eggs($nest_id)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://" . env('PTERODACTYL_FQDN') . "/api/application/nests/" . $nest_id . "/eggs");
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
                "object": "egg",
                "attributes": {
                    "id": 1,
                    "uuid": "695648dd-01a3-4ced-b075-d4ec4fb9fbf4",
                    "name": "Bungeecord",
                    "nest": 1,
                    "author": "support@pterodactyl.io",
                    "description": "For a long time, Minecraft server owners have had a dream that encompasses a free, easy, and reliable way to connect multiple Minecraft servers together. BungeeCord is the answer to said dream. Whether you are a small server wishing to string multiple game-modes together, or the owner of the ShotBow Network, BungeeCord is the ideal solution for you. With the help of BungeeCord, you will be able to unlock your community's full potential.",
                    "docker_image": "quay.io\/pterodactyl\/core:java",
                    "config": {
                    "files": {
                        "config.yml": {
                        "parser": "yaml",
                        "find": {
                            "listeners[0].query_enabled": true,
                            "listeners[0].query_port": "{{server.build.default.port}}",
                            "listeners[0].host": "0.0.0.0:{{server.build.default.port}}",
                            "servers.*.address": {
                            "127.0.0.1": "{{config.docker.interface}}",
                            "localhost": "{{config.docker.interface}}"
                            }
                        }
                        }
                    },
                    "startup": {
                        "done": "Listening on ",
                        "userInteraction": [
                        "Listening on \/0.0.0.0:25577"
                        ]
                    },
                    "stop": "end",
                    "logs": {
                        "custom": false,
                        "location": "proxy.log.0"
                    },
                    "extends": null
                    },
                    "startup": "java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}}",
                    "script": {
                    "privileged": true,
                    "install": "#!\/bin\/ash\n# Bungeecord Installation Script\n#\n# Server Files: \/mnt\/server\napk update\napk add curl\n\ncd \/mnt\/server\n\nif [ -z \"${BUNGEE_VERSION}\" ] || [ \"${BUNGEE_VERSION}\" == \"latest\" ]; then\n    BUNGEE_VERSION=\"lastStableBuild\"\nfi\n\ncurl -o ${SERVER_JARFILE} https:\/\/ci.md-5.net\/job\/BungeeCord\/${BUNGEE_VERSION}\/artifact\/bootstrap\/target\/BungeeCord.jar",
                    "entry": "ash",
                    "container": "alpine:3.9",
                    "extends": null
                    },
                    "created_at": "2019-12-22T04:42:51+00:00",
                    "updated_at": "2019-12-22T04:42:51+00:00",
                    "relationships": {
                    "nest": {
                        "object": "nest",
                        "attributes": {
                        "id": 1,
                        "uuid": "58bde975-ec57-4af2-b241-1426ac6d6d59",
                        "author": "support@pterodactyl.io",
                        "name": "Minecraft",
                        "description": "Minecraft - the classic game from Mojang. With support for Vanilla MC, Spigot, and many others!",
                        "created_at": "2019-12-22T04:42:51+00:00",
                        "updated_at": "2019-12-22T04:42:51+00:00"
                        }
                    },
                    "servers": {
                        "object": "list",
                        "data": []
                    }
                    }
                }
                },
                {
                "object": "egg",
                "attributes": {
                    "id": 2,
                    "uuid": "7f8736d8-fd99-465f-8c3e-cb4d42c18541",
                    "name": "Forge Minecraft",
                    "nest": 1,
                    "author": "support@pterodactyl.io",
                    "description": "Minecraft Forge Server. Minecraft Forge is a modding API (Application Programming Interface), which makes it easier to create mods, and also make sure mods are compatible with each other.",
                    "docker_image": "quay.io\/pterodactyl\/core:java",
                    "config": {
                    "files": {
                        "server.properties": {
                        "parser": "properties",
                        "find": {
                            "server-ip": "0.0.0.0",
                            "enable-query": "true",
                            "server-port": "{{server.build.default.port}}",
                            "query.port": "{{server.build.default.port}}"
                        }
                        }
                    },
                    "startup": {
                        "done": ")! For help, type ",
                        "userInteraction": [
                        "Go to eula.txt for more info."
                        ]
                    },
                    "stop": "stop",
                    "logs": {
                        "custom": false,
                        "location": "logs\/latest.log"
                    },
                    "extends": null
                    },
                    "startup": "java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}}",
                    "script": {
                    "privileged": true,
                    "install": "#!\/bin\/bash\r\n# Forge Installation Script\r\n#\r\n# Server Files: \/mnt\/server\r\napt update\r\napt install -y curl\r\n\r\n#Fetching version\r\nif [ -z \"$MC_VERSION\" ] || [ \"$MC_VERSION\" == \"latest\" ]; then\r\n  echo \"Fetching latest\"\r\n  MC_VERSION=$(curl -sl https:\/\/files.minecraftforge.net\/maven\/net\/minecraftforge\/forge\/index.html | grep -A 2 \"Latest\" | awk NF=NF RS= OFS=\" \" | grep -o -e '[1].[0-9]*.[0-9]* - [0-9]*.[0-9]*.[0-9]*.[0-9]*' | sed 's\/ \/\/g')\r\nelif [[ ! \"$MC_VERSION\" =~ - ]]; then\r\n  echo \"Fetching latest from version $MC_VERSION\"\r\n  MC_VERSION=$(curl -sl https:\/\/files.minecraftforge.net\/maven\/net\/minecraftforge\/forge\/index_$MC_VERSION.html | grep -A 2 \"Latest\" | awk NF=NF RS= OFS=\" \" | grep -o -e '[1].[0-9]*.[0-9]* - [0-9]*.[0-9]*.[0-9]*.[0-9]*' | sed 's\/ \/\/g')\r\nfi\r\n\r\n#Checking if forge version valid\r\nif [[ ! \"$MC_VERSION\" =~ [1].[0-9]*.[0-9]*-[0-9]*.[0-9]*.[0-9]*.[0-9]* ]]; then\r\n    echo \"!!! Invalid forge version \\\"$MC_VERSION\\\" !!!\"\r\n    exit\r\nfi\r\n\r\n#Go into main direction\r\ncd \/mnt\/server\r\n\r\n#Adding .jar when not eding by SERVER_JARFILE\r\nif [[ ! $SERVER_JARFILE = *\\.jar ]]; then\r\n  SERVER_JARFILE=\"$SERVER_JARFILE.jar\"\r\nfi\r\n\r\n#Downloading jars\r\necho -e \"Downloading forge version \\\"$MC_VERSION\\\"\"\r\ncurl -o installer.jar -sS https:\/\/files.minecraftforge.net\/maven\/net\/minecraftforge\/forge\/$MC_VERSION\/forge-$MC_VERSION-installer.jar\r\ncurl -o $SERVER_JARFILE -sS https:\/\/files.minecraftforge.net\/maven\/net\/minecraftforge\/forge\/$MC_VERSION\/forge-$MC_VERSION-universal.jar\r\n\r\n#Checking if downloaded jars exist\r\nif [ ! -f .\/installer.jar ] || [ ! -f .\/$SERVER_JARFILE ]; then\r\n    echo \"!!! Error by downloading forge version \\\"$MC_VERSION\\\" !!!\"\r\n    exit\r\nfi\r\n\r\n#Installing server\r\necho -e \"Installing forge server.\\n\"\r\njava -jar installer.jar --installServer\r\n\r\n#Deleting installer.jar\r\necho -e \"Deleting installer.jar file.\\n\"\r\nrm -rf installer.jar",
                    "entry": "bash",
                    "container": "openjdk:8",
                    "extends": null
                    },
                    "created_at": "2019-12-22T04:42:51+00:00",
                    "updated_at": "2019-12-22T04:42:51+00:00",
                    "relationships": {
                    "nest": {
                        "object": "nest",
                        "attributes": {
                        "id": 1,
                        "uuid": "58bde975-ec57-4af2-b241-1426ac6d6d59",
                        "author": "support@pterodactyl.io",
                        "name": "Minecraft",
                        "description": "Minecraft - the classic game from Mojang. With support for Vanilla MC, Spigot, and many others!",
                        "created_at": "2019-12-22T04:42:51+00:00",
                        "updated_at": "2019-12-22T04:42:51+00:00"
                        }
                    },
                    "servers": {
                        "object": "list",
                        "data": []
                    }
                    }
                },
                {
                "object": "egg",
                "attributes": {
                    "id": 5,
                    "uuid": "cd4cc5cf-de80-4a50-b458-dbd7d3193175",
                    "name": "Vanilla Minecraft",
                    "nest": 1,
                    "author": "support@pterodactyl.io",
                    "description": "Minecraft is a game about placing blocks and going on adventures. Explore randomly generated worlds and build amazing things from the simplest of homes to the grandest of castles. Play in Creative Mode with unlimited resources or mine deep in Survival Mode, crafting weapons and armor to fend off dangerous mobs. Do all this alone or with friends.",
                    "docker_image": "quay.io\/pterodactyl\/core:java",
                    "config": {
                    "files": {
                        "server.properties": {
                        "parser": "properties",
                        "find": {
                            "server-ip": "0.0.0.0",
                            "enable-query": "true",
                            "server-port": "{{server.build.default.port}}",
                            "query.port": "{{server.build.default.port}}"
                        }
                        }
                    },
                    "startup": {
                        "done": ")! For help, type ",
                        "userInteraction": [
                        "Go to eula.txt for more info."
                        ]
                    },
                    "stop": "stop",
                    "logs": {
                        "custom": false,
                        "location": "logs\/latest.log"
                    },
                    "extends": null
                    },
                    "startup": "java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}}",
                    "script": {
                    "privileged": true,
                    "install": "#!\/bin\/ash\r\n# Vanilla MC Installation Script\r\n#\r\n# Server Files: \/mnt\/server\r\napk update\r\napk add curl jq\r\n\r\ncd \/mnt\/server\r\n\r\nLATEST_VERSION=`curl https:\/\/launchermeta.mojang.com\/mc\/game\/version_manifest.json | jq -r '.latest.release'`\r\n\r\nif [ -z \"$VANILLA_VERSION\" ] || [ \"$VANILLA_VERSION\" == \"latest\" ]; then\r\n  MANIFEST_URL=$(curl https:\/\/launchermeta.mojang.com\/mc\/game\/version_manifest.json | jq .versions | jq -r '.[] | select(.id == \"'$LATEST_VERSION'\") | .url')\r\nelse\r\n  MANIFEST_URL=$(curl https:\/\/launchermeta.mojang.com\/mc\/game\/version_manifest.json | jq .versions | jq -r '.[] | select(.id == \"'$VANILLA_VERSION'\") | .url')\r\nfi\r\n\r\nDOWNLOAD_URL=`curl $MANIFEST_URL | jq .downloads.server | jq -r '. | .url'`\r\n\r\ncurl -o ${SERVER_JARFILE} $DOWNLOAD_URL",
                    "entry": "ash",
                    "container": "alpine:3.9",
                    "extends": null
                    },
                    "created_at": "2019-12-22T04:42:51+00:00",
                    "updated_at": "2019-12-22T04:42:51+00:00",
                    "relationships": {
                    "nest": {
                        "object": "nest",
                        "attributes": {
                        "id": 1,
                        "uuid": "58bde975-ec57-4af2-b241-1426ac6d6d59",
                        "author": "support@pterodactyl.io",
                        "name": "Minecraft",
                        "description": "Minecraft - the classic game from Mojang. With support for Vanilla MC, Spigot, and many others!",
                        "created_at": "2019-12-22T04:42:51+00:00",
                        "updated_at": "2019-12-22T04:42:51+00:00"
                        }
                    },
                    "servers": {
                        "object": "list",
                        "data": [
                        {
                            "object": "server",
                            "attributes": {
                            "id": 5,
                            "external_id": "RemoteId1",
                            "uuid": "1a7ce997-259b-452e-8b4e-cecc464142ca",
                            "identifier": "1a7ce997",
                            "name": "Wuhu Island",
                            "description": "Matt from Wii Sports",
                            "suspended": false,
                            "limits": {
                                "memory": 512,
                                "swap": 0,
                                "disk": 200,
                                "io": 500,
                                "cpu": 0,
                                "threads": null
                            },
                            "feature_limits": {
                                "databases": 5,
                                "allocations": 5,
                                "backups": 2
                            },
                            "user": 1,
                            "node": 1,
                            "allocation": 1,
                            "nest": 1,
                            "egg": 5,
                            "pack": null,
                            "container": {
                                "startup_command": "java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}}",
                                "image": "quay.io\/pterodactyl\/core:java",
                                "installed": true,
                                "environment": {
                                "SERVER_JARFILE": "server.jar",
                                "VANILLA_VERSION": "latest",
                                "STARTUP": "java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}}",
                                "P_SERVER_LOCATION": "Test",
                                "P_SERVER_UUID": "1a7ce997-259b-452e-8b4e-cecc464142ca"
                                }
                            },
                            "updated_at": "2020-06-13T04:20:53+00:00",
                            "created_at": "2019-12-23T06:46:27+00:00"
                            }
                        }
                        ]
                    }
                    }
                }
                }
            ]
        }
        */
    }

    public static function get_egg($nest_id, $id)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://" . env('PTERODACTYL_FQDN') . "/api/application/nests/" . $nest_id . '/eggs/' . $id);
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
            "object": "egg",
            "attributes": {
                "id": 1,
                "uuid": "695648dd-01a3-4ced-b075-d4ec4fb9fbf4",
                "name": "Bungeecord",
                "nest": 1,
                "author": "support@pterodactyl.io",
                "description": "For a long time, Minecraft server owners have had a dream that encompasses a free, easy, and reliable way to connect multiple Minecraft servers together. BungeeCord is the answer to said dream. Whether you are a small server wishing to string multiple game-modes together, or the owner of the ShotBow Network, BungeeCord is the ideal solution for you. With the help of BungeeCord, you will be able to unlock your community's full potential.",
                "docker_image": "quay.io\/pterodactyl\/core:java",
                "config": {
                "files": {
                    "config.yml": {
                    "parser": "yaml",
                    "find": {
                        "listeners[0].query_enabled": true,
                        "listeners[0].query_port": "{{server.build.default.port}}",
                        "listeners[0].host": "0.0.0.0:{{server.build.default.port}}",
                        "servers.*.address": {
                        "127.0.0.1": "{{config.docker.interface}}",
                        "localhost": "{{config.docker.interface}}"
                        }
                    }
                    }
                },
                "startup": {
                    "done": "Listening on ",
                    "userInteraction": [
                    "Listening on \/0.0.0.0:25577"
                    ]
                },
                "stop": "end",
                "logs": {
                    "custom": false,
                    "location": "proxy.log.0"
                },
                "extends": null
                },
                "startup": "java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}}",
                "script": {
                "privileged": true,
                "install": "#!\/bin\/ash\n# Bungeecord Installation Script\n#\n# Server Files: \/mnt\/server\napk update\napk add curl\n\ncd \/mnt\/server\n\nif [ -z \"${BUNGEE_VERSION}\" ] || [ \"${BUNGEE_VERSION}\" == \"latest\" ]; then\n    BUNGEE_VERSION=\"lastStableBuild\"\nfi\n\ncurl -o ${SERVER_JARFILE} https:\/\/ci.md-5.net\/job\/BungeeCord\/${BUNGEE_VERSION}\/artifact\/bootstrap\/target\/BungeeCord.jar",
                "entry": "ash",
                "container": "alpine:3.9",
                "extends": null
                },
                "created_at": "2019-12-22T04:42:51+00:00",
                "updated_at": "2019-12-22T04:42:51+00:00"
            }
        }
        */
    }

    public static function create_server($user_id, $node_id = null, $egg_id, $name, $ram, $disk, $cpu)
    {
        $egg = Egg::where('egg_id', $egg_id)->first();
        $egg_information = Pterodactyl::get_egg($egg->nest_id, $egg->egg_id);
        $user = User::where('id', $user_id)->first();
        $options = json_encode([
            'name' => $name,
            'user' => $user->panel_acc,
            'egg' => $egg_id,
            'docker_image' => $egg_information['attributes']['docker_image'],
            'startup' => $egg_information['attributes']['startup'],
            'environment' => [],
            'limits' => [
                'memory' => $ram,
                'swap' => 0,
                'disk' => $disk,
                'io' => 500,
                'cpu' => $cpu
            ],
            'feature_limits' => [
                'databases' => 0,
                'backups' => 0,
                'allocations' => 1
            ],
            'deploy' => [
                'locations' => [
                    $node_id
                ],
                'allocations' => [],
                'port_range' => [],
                'dedicated_ip' => false,
            ]
        ]);


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://" . env('PTERODACTYL_FQDN') . "/api/application/servers");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $options);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . env('PTERODACTYL_APPLICATION_KEY');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $pterodactyl_result = json_decode($result, true);
        dd($pterodactyl_result);
        return $pterodactyl_result;
    }
}
