<?php

if(!defined("QUIQQER_SYSTEM")){
    define("QUIQQER_SYSTEM","true");
}

require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/bootstrap.php";
ini_set("display_errors","on");

if(QUI::getUserBySession()->getId() == 0){
    echo "You are not permitted to view this section.";
    exit;
}

if(!QUI::getUserBySession()->isSU()){
    echo "You are not permitted to view this section.";
    exit;
}

function adminer_object()
{
    return new \QUI\DBAdmin\QUIAdminer();
}

require dirname(dirname(__FILE__)) . "/lib/adminer-4.3.1-mysql.php";

