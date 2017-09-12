<?php

namespace QUI\DBAdmin;

use QUI\System\Log;
use QUI\Users\User;

class QUIAdminer extends \AdminerPlugin
{


    /**
     * Sets the name of the adminer instance
     *
     * @return string
     */
    public function name()
    {
        // custom name in title and heading
        return \QUI::getLocale()->get("quiqqer/dbadmin", "adminer.title");
    }

    /**
     * @param bool $create
     *
     * @return bool
     */
    public function permanentLogin($create = false)
    {
        return false;
    }

    /**
     * Sets the MySql Login Credentials
     *
     * @return array
     */
    public function credentials()
    {
        // server, username and password for connecting to database
        return array(
            \QUI::conf("db", "host"),
            \QUI::conf("db", "user"),
            \QUI::conf("db", "password")
        );
    }

    /**
     * Customizes which tavbles should be displayed
     *
     * @param $tables
     *
     * @return string
     */
    public function tablesPrint($tables)
    {
        //Add Tablenames to disable them in the view
        $blacklistedTables = array();

        foreach ($blacklistedTables as $tableName) {
            if (isset($tables[$tableName])) {
                unset($tables[$tableName]);
            }
        }

        return parent::tablesPrint($tables);
    }

    /**
     * @return mixed
     */
    public function database()
    {
        $result = parent::database();

        return $result;
    }

    /**
     * Limit the database selection to the configured QUIQQER Database
     *
     * @param bool $sc
     *
     * @return array
     */
    public function databases($sc = true)
    {

//        $databases = Utils::getAdditionalDatabases();
//        $databases = explode(",", $databases);

        $databases[] = \QUI::conf("db", "database");

        $databases = array_unique($databases);

        return $databases;
    }


    /**
     * Disables the login form completely
     */
    public function loginForm()
    {
        // Disable the LoginForm
        return "";
    }

    /**
     * Verfifies the user is logged in into QUIQQER and is a super user
     *
     * @param $login
     * @param $password
     *
     * @return bool
     */
    public function login($login, $password)
    {
        /** @var User $CurrentQUIUser */
        $CurrentQUIUser = \QUI::getUserBySession();
        if ($CurrentQUIUser->getId() == 0) {
            return false;
        }

        try {
            $CurrentQUIUser->checkPermission("quiqqer.dbadmin.access");
        } catch (\Exception $Exception) {
            return false;
        }


        return true;
    }
}
