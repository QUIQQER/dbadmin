<?php

namespace QUI\DBAdmin;

class Utils
{
    /**
     * Returns a comma separated string of additional databases which should be loaded in addition to the main database
     * @return string
     */
    public static function getAdditionalDatabases()
    {
        $Config = \QUI::getPackage("quiqqer/dbadmin")->getConfig();

        return trim($Config->get("dbadmin", "databases"));
    }
}