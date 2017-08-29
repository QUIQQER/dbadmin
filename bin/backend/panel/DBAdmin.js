/**
 * Provides a Panel, which can be used to edit the Database within QUIQQER
 *
 * @module package/quiqqer/dbadmin/bin/backend/panel/DBAdmin
 * @author www.pcsg.de (Florian Bogner)
 *
 * @require qui/QUI
 * @require qui/controls/desktop/Panel'
 * @require Ajax
 * @require Locale
 */
define('package/quiqqer/dbadmin/bin/backend/panel/DBAdmin', [
    'qui/QUI',
    'qui/controls/desktop/Panel',
    'Ajax',
    'Locale',
    'css!package/quiqqer/dbadmin/bin/backend/panel/DBAdmin.css'


], function (QUI, QUIPanel, Ajax, QUILocale) {
    "use strict";

    var lg = 'quiqqer/dbadmin';

    /**
     * @class package/quiqqer/dbadmin/bin/backend/panel/DBAdmin
     *
     * @memberof! <global>
     */
    return new Class({

        Extends: QUIPanel,
        Type   : 'package/quiqqer/dbadmin/bin/backend/panel/DBAdmin',

        Binds: [
            "$onCreate"
        ],

        options: {
            title: QUILocale.get(lg, 'panel.title'),
            icon : 'fa fa-database'

        },

        /**
         * Initialization of te panel
         * @param options
         */
        initialize: function (options) {
            this.parent(options);

            this.addEvents({
                onCreate: this.$onCreate
            });
        },


        /**
         * Creates the ui controls within the panel.
         */
        $onCreate: function () {
            var self    = this,
                Content = this.getContent();

            Content.style.padding = 0;

            var lang = window.USER.lang;

            var Iframe = new Element('iframe', {
                src     : URL_OPT_DIR + "/quiqqer/dbadmin/bin/adminer.php?username=&db=&lang=" + lang,
                seamless: true,
                height  : "100%",
                width   : "100%",
                'class' : "dbadmin-iframe"
            });
            Iframe.inject(Content);
        }

    });
});
