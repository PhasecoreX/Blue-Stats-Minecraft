<?php

namespace BlueStats\Plugin;

use BlueStats\API\plugin;

class XStat extends plugin
{
    public static $pluginType    = 'stat';
    public static $isMySQLplugin = TRUE;
    public        $name          = 'XStat';
    public        $database      = [
        "prefix" => "xstat_",
        "identifier" => "uuid", // Can be id, uuid or name. Used to get stats based on id. name or uuid
        "index" => [ // Define the table which contains user data
            "table" => "player_string",
            "columns" => [
                "uuid" => "uuid",
                "name" => "value",
                "id" => "uuid",
            ],
            "where" => "type = 'name'", // Guaranteed to exist and be one record per person
        ],
        "groups" => [
            "time" => [
                "display" => true,
                "name" => "Time",
                "headers" => [
                    "Stat",
                    "Total",
                ],
                "stats" => [
                    "joins",
                    "time_played",
                    "time_moving",
                    "time_standing",
                    "times_slept",
                ],
            ],
            "items" => [
                "display" => true,
                "name" => "Items",
                "headers" => [
                    "Stat",
                    "Total",
                ],
                "stats" => [
                    "blocks_broken",
                    "blocks_placed",
                    "items_picked_up",
                    "items_dropped",
                    "items_crafted",
                    "items_fished",
                    "tools_broken",
                ],
            ],
            "combat" => [
                "display" => true,
                "name" => "Combat",
                "headers" => [
                    "Stat",
                    "Total",
                ],
                "stats" => [
                    "kills_players",
                    "kills_mobs",
                    "damage_dealt",
                    "damage_taken",
                    "death",
                ],
            ],
            "others" => [
                "display" => true,
                "name" => "Other Stats",
                "headers" => [
                    "Stat",
                    "Total",
                ],
                "stats" => [
                    "distance_traveled",
                    "food_eaten",
                    "messages_sent",
                    "eggs_thrown",
                    "eggs_hatched",
                    "entity_interact",
                ],
            ],
        ],
        "stats" => [
            "entity_interact" => [
                "database" => "entity_interact",
                "name" => "Animal Interactions",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Interacted with {VALUE} animal",
                        "plural" => "Interacted with {VALUE} animals",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Action",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            // "arrows" => [
            //     "database" => "arrows",
            //     "name" => "Arrows Shot",
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Shot {VALUE} arrow",
            //             "plural" => "Shot {VALUE} arrows",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Arrows Shot", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            "blocks_broken" => [
                "database" => "block_break",
                "name" => "Blocks Broken",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Broke {VALUE} block",
                        "plural" => "Broke {VALUE} blocks",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            "blocks_placed" => [
                "database" => "block_place",
                "name" => "Blocks Placed",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Placed {VALUE} block",
                        "plural" => "Placed {VALUE} blocks",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            // "buckets_emptied" => [
            //     "database" => "buckets_emptied",
            //     "name" => "Buckets Emptied",
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Emptied {VALUE} bucket",
            //             "plural" => "Emptied {VALUE} buckets",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "buckets_filled" => [
            //     "database" => "buckets_filled",
            //     "name" => "Buckets Filled",
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Filled {VALUE} bucket",
            //             "plural" => "Filled {VALUE} buckets",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "commands_done" => [
            //     "database" => "commands_done",
            //     "name" => "Commands Executed",
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Executed {VALUE} command",
            //             "plural" => "Executed {VALUE} commands",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            "damage_dealt" => [
                // TODO This is broken for players/mobs/env mixing
                "database" => "damage",
                "name" => "Damage Dealt",
                "user_identifier" => "killer_name",
                "text" => [
                    "en_US" => [
                        "single" => "Dealt {VALUE} damage",
                        "plural" => "Dealt {VALUE} damage",
                    ],
                ],
                "values" => [
                    [
                        "column" => "victim_name",
                        "dataType" => "damage_source",
                        "aggregate" => false,
                        "name" => "Victim",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "round_2", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Damage", // Human readable name of the stat
                    ],
                ],
                "where" => "killer_type = 'PLAYER'",
            ],
            "damage_taken" => [
                // TODO This is broken for players/mobs/env mixing
                "database" => "damage",
                "name" => "Damage Taken",
                "user_identifier" => "victim_name",
                "text" => [
                    "en_US" => [
                        "single" => "Took {VALUE} damage",
                        "plural" => "Took {VALUE} damage",
                    ],
                ],
                "values" => [
                    [
                        "column" => "killer_name",
                        "dataType" => "damage_source",
                        "aggregate" => false,
                        "name" => "Cause of Damage",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "round_2", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Damage", // Human readable name of the stat
                    ],
                ],
                "where" => "victim_type = 'PLAYER'",
            ],
            "death" => [
                // TODO This is broken for players/mobs/env mixing
                "database" => "kill",
                "name" => "Deaths",
                "user_identifier" => "victim_name",
                "text" => [
                    "en_US" => [
                        "single" => "Died {VALUE} time",
                        "plural" => "Died {VALUE} times",
                    ],
                ],
                "values" => [
                    [
                        "column" => "killer_name",
                        "dataType" => "damage_source",
                        "aggregate" => false,
                        "name" => "Cause of Death",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "victim_type = 'PLAYER'",
            ],
            "distance_traveled" => [
                "database" => "move",
                "name" => "Distance Traveled (Blocks)",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Traveled {VALUE} block",
                        "plural" => "Traveled {VALUE} blocks",
                    ],
                ],
                "values" => [
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "distance", // column in which the data is stored in the table
                        "dataType" => "round_2", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Blocks", // Human readable name of the stat
                    ],
                ],
                "where" => "movement != 'STANDING' AND movement != 'DEAD'",
            ],
            "distance_traveled_type" => [
                "database" => "move",
                "name" => "Distance Traveled (by Type)",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Traveled {VALUE} block",
                        "plural" => "Traveled {VALUE} blocks",
                    ],
                ],
                "values" => [
                    [
                        "column" => "movement",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Movement Type",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "distance", // column in which the data is stored in the table
                        "dataType" => "round_2", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Blocks", // Human readable name of the stat
                    ],
                ],
                "where" => "movement != 'STANDING' AND movement != 'DEAD'",
            ],
            "distance_traveled_biome" => [
                "database" => "move",
                "name" => "Distance Traveled (by Biome)",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Traveled {VALUE} block",
                        "plural" => "Traveled {VALUE} blocks",
                    ],
                ],
                "values" => [
                    [
                        "column" => "biome",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Biome",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "distance", // column in which the data is stored in the table
                        "dataType" => "round_2", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Blocks", // Human readable name of the stat
                    ],
                ],
                "where" => "movement != 'STANDING'",
            ],
            "eggs_thrown" => [
                "database" => "player_int",
                "name" => "Eggs Thrown",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Threw {VALUE} egg",
                        "plural" => "Threw {VALUE} eggs",
                    ],
                ],
                "values" => [
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "type = 'egg_throw'",
            ],
            "eggs_hatched" => [
                "database" => "player_int",
                "name" => "Eggs Hatched",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Hatched {VALUE} egg",
                        "plural" => "Hatched {VALUE} eggs",
                    ],
                ],
                "values" => [
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "type = 'egg_hatch'",
            ],
            "items_fished" => [
                "database" => "item_fish",
                "name" => "Fish Caught",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Caught {VALUE} fish",
                        "plural" => "Caught {VALUE} fish",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item Caught",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            "food_eaten" => [
                "database" => "food",
                "name" => "Food Eaten",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Ate {VALUE} meal",
                        "plural" => "Ate {VALUE} meals",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Food",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            "items_crafted" => [
                "database" => "item_craft",
                "name" => "Items Crafted",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Crafted {VALUE} item",
                        "plural" => "Crafted {VALUE} items",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            "items_dropped" => [
                "database" => "item_drop",
                "name" => "Items Dropped",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Dropped {VALUE} item",
                        "plural" => "Dropped {VALUE} items",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            "items_picked_up" => [
                "database" => "item_pick",
                "name" => "Items Picked Up",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Picked up {VALUE} item",
                        "plural" => "Picked up {VALUE} items",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Item",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            "joins" => [
                "database" => "player_int",
                "name" => "Joins",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Joined {VALUE} time",
                        "plural" => "Joined {VALUE} times",
                    ],
                ],
                "values" => [
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "type = 'join_count'",
            ],
            "kills_mobs" => [
                "database" => "kill",
                "name" => "Mobs Killed",
                "user_identifier" => "killer_name",
                "text" => [
                    "en_US" => [
                        "single" => "Killed {VALUE} mob",
                        "plural" => "Killed {VALUE} mobs",
                    ],
                ],
                "values" => [
                    [
                        "column" => "victim_name",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Mob",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "killer_type = 'PLAYER' AND victim_type = 'MOB'",
            ],
            "kills_players" => [
                "database" => "kill",
                "name" => "Players Killed",
                "user_identifier" => "killer_name",
                "text" => [
                    "en_US" => [
                        "single" => "Killed {VALUE} player",
                        "plural" => "Killed {VALUE} players",
                    ],
                ],
                "values" => [
                    [
                        "column" => "victim_name",
                        "dataType" => "player_uuid",
                        "aggregate" => false,
                        "name" => "Player",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "killer_type = 'PLAYER' AND victim_type = 'PLAYER'",
            ],
            // "last_join" => [
            //     "database" => "player_date",
            //     "name" => "Last Join",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Last joined on {VALUE}",
            //             "plural" => "Last joined on {VALUE}",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "last_modified", // column in which the data is stored in the table
            //             "dataType" => "date", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "aggregate_type" => "max", // TODO: implement aggregate_type. Default should be sum if not specified.
            //             "name" => "Date", // Human readable name of the stat
            //         ],
            //     ],
            //     "where"=>"type = 'last_join'",
            // ],
            // "last_seen" => [
            //     "database" => "player_date",
            //     "name" => "Last Seen",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Last seen on {VALUE}",
            //             "plural" => "Last seen on {VALUE}",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "date", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "aggregate_type" => "max", // TODO: implement aggregate_type. Default should be sum if not specified.
            //             "name" => "Date", // Human readable name of the stat
            //         ],
            //     ],
            //     "where"=>"type = 'last_leave'",
            // ],
            "messages_sent" => [
                "database" => "player_int",
                "name" => "Messages Sent",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Sent {VALUE} message",
                        "plural" => "Sent {VALUE} messages",
                    ],
                ],
                "values" => [
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "type = 'chat_messages'",
            ],
            "time_played" => [
                "database" => "move",
                "name" => "Time Played",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Played for {VALUE}",
                        "plural" => "Played for {VALUE}",
                    ],
                ],
                "values" => [
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "time", // column in which the data is stored in the table
                        "dataType" => "time", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            "time_moving" => [
                "database" => "move",
                "name" => "Time Spent Moving",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Moved for {VALUE}",
                        "plural" => "Moved for {VALUE}",
                    ],
                ],
                "values" => [
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "time", // column in which the data is stored in the table
                        "dataType" => "time", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "movement != 'STANDING'",
            ],
            "time_standing" => [
                "database" => "move",
                "name" => "Time Spent Standing",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Stood for {VALUE}",
                        "plural" => "Stood for {VALUE}",
                    ],
                ],
                "values" => [
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "time", // column in which the data is stored in the table
                        "dataType" => "time", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
                "where" => "movement = 'STANDING'",
            ],
            // "pvp_streak" => [
            //     "database" => "pvp_streak",
            //     "name" => "Current PvP Streak",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Killed {VALUE} player in current streak",
            //             "plural" => "Killed {VALUE} players in current streak",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "pvp_top_streak" => [
            //     "database" => "pvp_top_streak",
            //     "name" => "Top PvP streak",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Killed {VALUE} player in their top streak",
            //             "plural" => "Killed {VALUE} players in their top streak",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "teleports" => [
            //     "database" => "teleports",
            //     "name" => "Teleports",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Teleported {VALUE} time",
            //             "plural" => "Teleported {VALUE} times",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "times_changed_world" => [
            //     "database" => "times_changed_world",
            //     "name" => "Worlds Changed",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Traveled through {VALUE} realm",
            //             "plural" => "Traveled through {VALUE} realms",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "times_kicked" => [
            //     "database" => "times_kicked",
            //     "name" => "Kicks",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Was kicked {VALUE} time",
            //             "plural" => "Was kicked {VALUE} times",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            "times_slept" => [
                "database" => "player_int",
                "name" => "Times Slept",
                "display" => FALSE,
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Entered {VALUE} bed",
                        "plural" => "Entered {VALUE} beds",
                    ],
                ],
                "values" => [
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Times Slept", // Human readable name of the stat
                    ],
                ],
                "where" => "type = 'times_slept'",
            ],
            "tools_broken" => [
                "database" => "item_break",
                "name" => "Tools Broken",
                "user_identifier" => "uuid",
                "text" => [
                    "en_US" => [
                        "single" => "Broke {VALUE} tool",
                        "plural" => "Broke {VALUE} tools",
                    ],
                ],
                "values" => [
                    [
                        "column" => "type",
                        "dataType" => "item_name",
                        "aggregate" => false,
                        "name" => "Tool",
                    ],
                    [
                        "column" => "world",
                        "dataType" => "world",
                        "aggregate" => false,
                        "name" => "World",
                    ],
                    [
                        "column" => "value", // column in which the data is stored in the table
                        "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
                        "aggregate" => true, // If true this column is used as a stat summary
                        "name" => "Count", // Human readable name of the stat
                    ],
                ],
            ],
            // "trades" => [
            //     "database" => "trades",
            //     "name" => "Villager Trades",
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Traded {VALUE} time",
            //             "plural" => "Traded {VALUE} times",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "votes" => [
            //     "database" => "votes",
            //     "name" => "Votes",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Voted for the server {VALUE} time",
            //             "plural" => "Voted for the server {VALUE} times",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "words_said" => [
            //     "database" => "words_said",
            //     "name" => "Words Said",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Said {VALUE} word",
            //             "plural" => "Said {VALUE} words",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "Count", // Human readable name of the stat
            //         ],
            //     ],
            // ],
            // "xp_gained" => [
            //     "database" => "xp_gained",
            //     "name" => "XP Gained",
            //     "display" => FALSE,
            //     "user_identifier" => "uuid",
            //     "text" => [
            //         "en_US" => [
            //             "single" => "Gained {VALUE} XP",
            //             "plural" => "Gained {VALUE} XP",
            //         ],
            //     ],
            //     "values" => [
            //         [
            //             "column" => "world",
            //             "dataType" => "world",
            //             "aggregate" => false,
            //             "name" => "World",
            //         ],
            //         [
            //             "column" => "value", // column in which the data is stored in the table
            //             "dataType" => "int", // The type of data stored in the column. This can be: time, date, mob, player, world, item_id, item_type, item_name, int
            //             "aggregate" => true, // If true this column is used as a stat summary
            //             "name" => "XP", // Human readable name of the stat
            //         ],
            //     ],
            // ],
        ],
    ];
}
