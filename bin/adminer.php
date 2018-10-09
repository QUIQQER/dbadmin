<?php

if (!defined("QUIQQER_SYSTEM")) {
    define("QUIQQER_SYSTEM", "true");
}

require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/bootstrap.php";


if (isset($_REQUEST['lang'])) {
    $language = $_REQUEST['lang'];
    QUI::getLocale()->setCurrent($language);
}

if(QUI::getUserBySession()->getLang() != ""){
    QUI::getLocale()->setCurrent(QUI::getUserBySession()->getLang());
}


if (!QUI::getUserBySession()->getId()) {
    echo QUI::getLocale()->get("quiqqer/dbadmin", "exception.no.permission");

    exit;
}

try {
    /** @var \QUI\Users\User $CurrentQUIUser */
    $CurrentQUIUser = QUI::getUserBySession();
    $CurrentQUIUser->checkPermission("quiqqer.dbadmin.access");
} catch (\Exception $Exception) {
    echo QUI::getLocale()->get("quiqqer/dbadmin", "exception.no.permission");

    exit;
}


$_GET['db'] = QUI::conf("db", "database");

/**
 * Overwrites the creation of the Adminer Object to use our custom object
 *
 * @return \QUI\DBAdmin\QUIAdminer
 */
function adminer_object()
{
    // Load Plugins
    include_once dirname(dirname(__FILE__)) . "/lib/plugins/plugin.php";

    // Include all plugin files
    foreach (glob(dirname(dirname(__FILE__)) . "/lib/plugins/*.plugin.php") as $filename) {
        include_once $filename;
    }

    $plugins = array(
        new AdminerFrames(true)
    );

    // Return the Adminer Instance
    return new \QUI\DBAdmin\QUIAdminer($plugins);
}

require dirname(dirname(__FILE__)) . "/lib/adminer-mysql.php";

if (file_exists(OPT_DIR . "quiqqer/dbadmin/bin/adminer_custom.css")) {
    echo '<link rel="stylesheet" type="text/css" href="' . URL_OPT_DIR . 'quiqqer/dbadmin/bin/adminer_custom.css" />';
}
