/**
 * Provides a Panel, which can be used to edit the Database within QUIQQER
 *
 * @module package/quiqqer/dbadmin/bin/backend/panel/DBAdmin
 * @author www.pcsg.de (Florian Bogner)
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
            var Content = this.getContent();

            Content.style.padding = 0;

            var lang = window.USER.lang;

            var Iframe = new Element('iframe', {
                src     : URL_OPT_DIR + "/quiqqer/dbadmin/bin/adminer.php?lang=" + lang,
                seamless: true,
                height  : "100%",
                width   : "100%",
                'class' : "dbadmin-iframe"
            });
            Iframe.inject(Content);

            Iframe.addEvent("load", function () {
                var IframeContent = Iframe.contentDocument || Iframe.contentWindow.document;

                var FA = new Element("link", {
                    href: URL_OPT_DIR + "bin/font-awesome/css/font-awesome.css",
                    rel : "stylesheet",
                    type: "text/css"
                });
                FA.inject(IframeContent.getElementsByTagName("head")[0]);


                var SelectButtons = IframeContent.getElementsByClassName("select");

                for (var i in SelectButtons) {
                    if (!SelectButtons.hasOwnProperty(i)) {
                        continue;
                    }

                    var SelectItem       = SelectButtons[i];
                    var oldHtml          = SelectItem.innerHTML;
                    SelectItem.innerHTML = "<span class='fa fa-eye' title='" + oldHtml + "'></span>";
                }
            });
        }
    });
});
