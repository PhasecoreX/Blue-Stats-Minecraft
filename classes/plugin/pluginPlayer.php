<?php

/**
 * Created by PhpStorm.
 * User: ricing
 * Date: 4/22/17
 * Time: 11:52 AM
 */

namespace BlueStats\API;

use mysqli;

class pluginPlayer {

    public $database; // Loaded from parent plugin class

    /** @var \mysqli $mysqli */
    private $mysql;   // Loaded from parent plugin class

    // Caches
    private $nameFromIdCache;
    private $uuidFromIdCache;
    private $idFromUuidCache;
    private $idFromNameCache;
    private $uuidFromNameCache;
    private $nameFromUuidCache;

    /**
     * pluginPlayer constructor.
     *
     * @param $database array Database layout to identify players in the database
     * @param $mysql    mysqli Connection to mysql server for plugin
     */
    public function __construct ($database, $mysql) {
        $this->database = $database;
        $this->mysql    = $mysql;
        $this->nameFromIdCache = array();
        $this->uuidFromIdCache = array();
        $this->idFromUuidCache = array();
        $this->idFromNameCache = array();
        $this->uuidFromNameCache = array();
        $this->nameFromUuidCache = array();
    }

    /**
     * @param String $user UUID or username of player
     *
     * @return int Player ID
     */
    public function getID ($user) {
        return $this->getIDfromUUID($user) ?: $this->getIDfromName($user);
    }

    /**
     * @param String $user UUID or ID of player
     *
     * @return string Player name
     */
    public function getName ($user) {
        if (is_int($user)) return $this->getNamefromID($user);

        return $this->getNamefromUUID($user) ?: $this->getNamefromID($user);
    }

    /**
     * @param String $user Name or ID of player
     *
     * @return string Player UUID
     */
    public function getUUID ($user) {
        if (is_int($user)) return $this->getUUIDfromID($user);

        return $this->getUUIDfromName($user) ?: $this->getUUIDfromID($user);
    }

    /**
     * This function uses the user id to get the username
     *
     * @param int $id ID of user as defined by plugin
     *
     * @return string Username of player
     */
    public function getNamefromID ($id) {
        // Return false if ID column is not set
        if (!isset($this->database["index"]["columns"]["id"]))
            return FALSE;

        if (array_key_exists($id, $this->nameFromIdCache))
            return $this->nameFromIdCache[$id];

        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the name from the player identification table using the id column for identification
        $query = "SELECT {$this->database["index"]["columns"]["name"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["id"]} = ?";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " AND {$this->database["index"]["where"]}";
        }

        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            $this->nameFromIdCache[$id] = $output;

            return $output;
        }

        return FALSE;
    }

    /**
     * This function uses the user id to get the uuid of a user
     *
     * @param int $id ID of user as defined by plugin
     *
     * @return string UUID of player
     */
    public function getUUIDfromID ($id) {
        // Return false if ID column is not set
        if (!isset($this->database["index"]["columns"]["id"]))
            return FALSE;

        if (array_key_exists($id, $this->uuidFromIdCache))
            return $this->uuidFromIdCache[$id];

        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the uuid from the player identification table using the id column for identification
        $query = "SELECT {$this->database["index"]["columns"]["uuid"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["id"]} = ?";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " AND {$this->database["index"]["where"]}";
        }

        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            $this->uuidFromIdCache[$id] = $output;

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $uuid UUID of player
     *
     * @return int User id
     */

    public function getIDfromUUID ($uuid) {
        if (array_key_exists($uuid, $this->idFromUuidCache))
            return $this->idFromUuidCache[$uuid];

        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the uuid column for identification
        $query = "SELECT {$this->database["index"]["columns"]["id"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["uuid"]} = ?";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " AND {$this->database["index"]["where"]}";
        }

        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            $this->idFromUuidCache[$uuid] = $output;

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $name Username of player
     *
     * @return int User ID
     */

    public function getIDfromName ($name) {
        if (array_key_exists($name, $this->idFromNameCache))
            return $this->idFromNameCache[$name];

        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the name column for identification
        $query = "SELECT {$this->database["index"]["columns"]["id"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["name"]} = ?";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " AND {$this->database["index"]["where"]}";
        }

        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            $this->idFromNameCache[$name] = $output;

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $name Username of player
     *
     * @return String User UUID
     */

    public function getUUIDfromName ($name) {
        if (array_key_exists($name, $this->uuidFromNameCache))
            return $this->uuidFromNameCache[$name];

        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the name column for identification
        $query = "SELECT {$this->database["index"]["columns"]["uuid"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["name"]} = ?";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " AND {$this->database["index"]["where"]}";
        }

        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            $this->uuidFromNameCache[$name] = $output;

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $name UUID of player
     *
     * @return String User Name
     */

    public function getNamefromUUID ($name) {
        if (array_key_exists($name, $this->nameFromUuidCache))
            return $this->nameFromUuidCache[$name];

        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the name column for identification
        $query = "SELECT {$this->database["index"]["columns"]["name"]} FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["uuid"]} = ?";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " AND {$this->database["index"]["where"]}";
        }

        if ($stmt->prepare($query)) {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->bind_result($output);
            $stmt->fetch();

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            $this->nameFromUuidCache[$name] = $output;

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $user name or uuid to search for in the database
     * @param int    $page
     * @param int    $limit
     *
     * @return array|bool an array of all users found with the search criteria
     */


    public function searchUser ($user, $page = 0, $limit = 100) {
        return $this->searchByName($user, $page, $limit) ?: $this->searchByUUID($user, $page, $limit);
    }

    /**
     * @param String $name name to search for in the database
     * @param int    $page
     * @param int    $limit
     *
     * @return array|bool an array of all users found with the search criteria
     */

    public function searchByName ($name, $page = 0, $limit = 100) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        $name  = "%$name%";
        $start = $page * $limit;

        // Select the id from the player identification table using the uuid column for identification
        $query = "SELECT {$this->database["index"]["columns"]["id"]} as id, {$this->database["index"]["columns"]["name"]} as name, {$this->database["index"]["columns"]["uuid"]} as uuid FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["name"]} LIKE ?";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " AND {$this->database["index"]["where"]}";
        }

        $query .= " LIMIT ?,?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("sii", $name, $start, $limit);
            $stmt->execute();
            $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    /**
     * @param String $uuid UUID to search for in the database
     * @param int    $page
     * @param int    $limit
     *
     * @return array|bool an array of all users found with the search criteria
     */

    public function searchByUUID ($uuid, $page = 0, $limit = 100) {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        $uuid  = "%$uuid%";
        $start = $page * $limit;

        // Select the id from the player identification table using the uuid column for identification
        $query = "SELECT {$this->database["index"]["columns"]["id"]} as id, {$this->database["index"]["columns"]["name"]} as name, {$this->database["index"]["columns"]["uuid"]} as uuid FROM {$this->database["prefix"]}{$this->database["index"]["table"]} WHERE {$this->database["index"]["columns"]["uuid"]} LIKE ?";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " AND {$this->database["index"]["where"]}";
        }

        $query .= " LIMIT ?,?";
        if ($stmt->prepare($query)) {
            $stmt->bind_param("sii", $uuid, $start, $limit);
            $stmt->execute();
            $output = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $output;
        }

        return FALSE;
    }

    public function count() {
        $mysqli = $this->mysql;
        $stmt   = $mysqli->stmt_init();

        // Select the id from the player identification table using the uuid column for identification
        $query = "SELECT count(*) as count FROM {$this->database["prefix"]}{$this->database["index"]["table"]}";

        // If there are additional where clauses, insert them here
        if (array_key_exists('where', $this->database["index"])) {
            $query .= " WHERE {$this->database["index"]["where"]}";
        }

        if ($stmt->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            // If there is an error log it
            if ($stmt->error && DEBUG)
                print($stmt->error);

            $stmt->close();

            return $count;
        }

        return FALSE;
    }
}
