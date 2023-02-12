<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite138cda51755a39592bb91648662c931
{
    public static $files = array (
        'db020e36c90dae2855434958b09ed49e' => __DIR__ . '/../..' . '/src/functions/load.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tribe\\Events\\Virtual\\' => 21,
            'TEC\\Events_Virtual\\' => 19,
        ),
        'D' => 
        array (
            'Defuse\\Crypto\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tribe\\Events\\Virtual\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Tribe',
        ),
        'TEC\\Events_Virtual\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Events_Virtual',
        ),
        'Defuse\\Crypto\\' => 
        array (
            0 => __DIR__ . '/..' . '/defuse/php-encryption/src',
        ),
    );

    public static $classMap = array (
        'Defuse\\Crypto\\Core' => __DIR__ . '/..' . '/defuse/php-encryption/src/Core.php',
        'Defuse\\Crypto\\Crypto' => __DIR__ . '/..' . '/defuse/php-encryption/src/Crypto.php',
        'Defuse\\Crypto\\DerivedKeys' => __DIR__ . '/..' . '/defuse/php-encryption/src/DerivedKeys.php',
        'Defuse\\Crypto\\Encoding' => __DIR__ . '/..' . '/defuse/php-encryption/src/Encoding.php',
        'Defuse\\Crypto\\Exception\\BadFormatException' => __DIR__ . '/..' . '/defuse/php-encryption/src/Exception/BadFormatException.php',
        'Defuse\\Crypto\\Exception\\CryptoException' => __DIR__ . '/..' . '/defuse/php-encryption/src/Exception/CryptoException.php',
        'Defuse\\Crypto\\Exception\\EnvironmentIsBrokenException' => __DIR__ . '/..' . '/defuse/php-encryption/src/Exception/EnvironmentIsBrokenException.php',
        'Defuse\\Crypto\\Exception\\IOException' => __DIR__ . '/..' . '/defuse/php-encryption/src/Exception/IOException.php',
        'Defuse\\Crypto\\Exception\\WrongKeyOrModifiedCiphertextException' => __DIR__ . '/..' . '/defuse/php-encryption/src/Exception/WrongKeyOrModifiedCiphertextException.php',
        'Defuse\\Crypto\\File' => __DIR__ . '/..' . '/defuse/php-encryption/src/File.php',
        'Defuse\\Crypto\\Key' => __DIR__ . '/..' . '/defuse/php-encryption/src/Key.php',
        'Defuse\\Crypto\\KeyOrPassword' => __DIR__ . '/..' . '/defuse/php-encryption/src/KeyOrPassword.php',
        'Defuse\\Crypto\\KeyProtectedByPassword' => __DIR__ . '/..' . '/defuse/php-encryption/src/KeyProtectedByPassword.php',
        'Defuse\\Crypto\\RuntimeTests' => __DIR__ . '/..' . '/defuse/php-encryption/src/RuntimeTests.php',
        'TEC\\Events_Virtual\\Compatibility\\Event_Automator\\Zapier\\Maps\\Event' => __DIR__ . '/../..' . '/src/Events_Virtual/Compatibility/Event_Automator/Zapier/Maps/Event.php',
        'TEC\\Events_Virtual\\Compatibility\\Event_Automator\\Zapier\\Zapier_Provider' => __DIR__ . '/../..' . '/src/Events_Virtual/Compatibility/Event_Automator/Zapier/Zapier_Provider.php',
        'TEC\\Events_Virtual\\Custom_Tables\\V1\\Provider' => __DIR__ . '/../..' . '/src/Events_Virtual/Custom_Tables/V1/Provider.php',
        'TEC\\Events_Virtual\\Custom_Tables\\V1\\Views\\V2\\Assets' => __DIR__ . '/../..' . '/src/Events_Virtual/Custom_Tables/V1/Views/V2/Assets.php',
        'Tribe\\Events\\Virtual\\Admin_Template' => __DIR__ . '/../..' . '/src/Tribe/Admin_Template.php',
        'Tribe\\Events\\Virtual\\Assets' => __DIR__ . '/../..' . '/src/Tribe/Assets.php',
        'Tribe\\Events\\Virtual\\Autodetect\\AJAX' => __DIR__ . '/../..' . '/src/Tribe/Autodetect/AJAX.php',
        'Tribe\\Events\\Virtual\\Autodetect\\Autodetect_Provider' => __DIR__ . '/../..' . '/src/Tribe/Autodetect/Autodetect_Provider.php',
        'Tribe\\Events\\Virtual\\Autodetect\\Fields' => __DIR__ . '/../..' . '/src/Tribe/Autodetect/Fields.php',
        'Tribe\\Events\\Virtual\\Autodetect\\Metabox' => __DIR__ . '/../..' . '/src/Tribe/Autodetect/Metabox.php',
        'Tribe\\Events\\Virtual\\Autodetect\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Autodetect/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Autodetect\\Url' => __DIR__ . '/../..' . '/src/Tribe/Autodetect/Url.php',
        'Tribe\\Events\\Virtual\\Compatibility' => __DIR__ . '/../..' . '/src/Tribe/Compatibility.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Event_Tickets\\Email' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Event_Tickets/Email.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Event_Tickets\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Event_Tickets/Event_Meta.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Event_Tickets\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Event_Tickets/Service_Provider.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Event_Tickets\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Event_Tickets/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Events_Control_Extension\\Meta_Redirection' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Events_Control_Extension/Meta_Redirection.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Events_Control_Extension\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Events_Control_Extension/Service_Provider.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Filter_Bar\\Events_Virtual_Filter' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Filter_Bar/Events_Virtual_Filter.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Filter_Bar\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Filter_Bar/Service_Provider.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Online_Event_Extension\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Online_Event_Extension/Service_Provider.php',
        'Tribe\\Events\\Virtual\\Compatibility\\Online_Event_Extension\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Compatibility/Online_Event_Extension/Settings.php',
        'Tribe\\Events\\Virtual\\Context\\Context_Provider' => __DIR__ . '/../..' . '/src/Tribe/Context/Context_Provider.php',
        'Tribe\\Events\\Virtual\\Editor\\Assets' => __DIR__ . '/../..' . '/src/Tribe/Editor/Assets.php',
        'Tribe\\Events\\Virtual\\Editor\\Blocks\\Virtual_Event' => __DIR__ . '/../..' . '/src/Tribe/Editor/Blocks/Virtual_Event.php',
        'Tribe\\Events\\Virtual\\Editor\\Provider' => __DIR__ . '/../..' . '/src/Tribe/Editor/Provider.php',
        'Tribe\\Events\\Virtual\\Editor\\Template\\Admin' => __DIR__ . '/../..' . '/src/Tribe/Editor/Template/Admin.php',
        'Tribe\\Events\\Virtual\\Editor\\Template\\Frontend' => __DIR__ . '/../..' . '/src/Tribe/Editor/Template/Frontend.php',
        'Tribe\\Events\\Virtual\\Encryption' => __DIR__ . '/../..' . '/src/Tribe/Encryption.php',
        'Tribe\\Events\\Virtual\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Event_Meta.php',
        'Tribe\\Events\\Virtual\\Event_Status\\Compatibility\\Filter_Bar\\Events_Status_Virtual_Filter' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Compatibility/Filter_Bar/Events_Status_Virtual_Filter.php',
        'Tribe\\Events\\Virtual\\Event_Status\\Compatibility\\Filter_Bar\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Compatibility/Filter_Bar/Service_Provider.php',
        'Tribe\\Events\\Virtual\\Event_Status\\Status_Labels' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Status_Labels.php',
        'Tribe\\Events\\Virtual\\Export\\Abstract_Export' => __DIR__ . '/../..' . '/src/Tribe/Export/Abstract_Export.php',
        'Tribe\\Events\\Virtual\\Export\\Event_Export' => __DIR__ . '/../..' . '/src/Tribe/Export/Event_Export.php',
        'Tribe\\Events\\Virtual\\Export\\Export_Provider' => __DIR__ . '/../..' . '/src/Tribe/Export/Export_Provider.php',
        'Tribe\\Events\\Virtual\\Hooks' => __DIR__ . '/../..' . '/src/Tribe/Hooks.php',
        'Tribe\\Events\\Virtual\\Importer\\Events' => __DIR__ . '/../..' . '/src/Tribe/Importer/Events.php',
        'Tribe\\Events\\Virtual\\Importer\\Importer_Provider' => __DIR__ . '/../..' . '/src/Tribe/Importer/Importer_Provider.php',
        'Tribe\\Events\\Virtual\\Integrations\\Abstract_Account_Api' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Abstract_Account_Api.php',
        'Tribe\\Events\\Virtual\\Integrations\\Abstract_Actions' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Abstract_Actions.php',
        'Tribe\\Events\\Virtual\\Integrations\\Abstract_Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Abstract_Event_Meta.php',
        'Tribe\\Events\\Virtual\\Integrations\\Abstract_Settings' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Abstract_Settings.php',
        'Tribe\\Events\\Virtual\\Integrations\\Abstract_Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Abstract_Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Integrations\\Abstract_Url' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Abstract_Url.php',
        'Tribe\\Events\\Virtual\\Integrations\\Abstract_Users' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Abstract_Users.php',
        'Tribe\\Events\\Virtual\\Integrations\\Api_Response' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Api_Response.php',
        'Tribe\\Events\\Virtual\\Integrations\\Editor\\Abstract_Classic' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Editor/Abstract_Classic.php',
        'Tribe\\Events\\Virtual\\Integrations\\Editor\\Abstract_Classic_Labels' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Editor/Abstract_Classic_Labels.php',
        'Tribe\\Events\\Virtual\\Integrations\\Request_Api' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Request_Api.php',
        'Tribe\\Events\\Virtual\\JSON_LD' => __DIR__ . '/../..' . '/src/Tribe/JSON_LD.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook\\Classic_Editor' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook/Classic_Editor.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook\\Event_Export' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook/Event_Export.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook/Event_Meta.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook\\Page_API' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook/Page_API.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook/Settings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook\\Url' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook/Url.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook\\Video_API' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook/Video_API.php',
        'Tribe\\Events\\Virtual\\Meetings\\Facebook_Provider' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Facebook_Provider.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Abstract_Meetings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Abstract_Meetings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Account_API' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Account_API.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Actions' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Actions.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Api' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Api.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Classic_Editor' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Classic_Editor.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Email' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Email.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Event_Export' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Event_Export.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Event_Meta.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Meetings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Meetings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Phone_Number' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Phone_Number.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Settings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Url' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Url.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google\\Users' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google/Users.php',
        'Tribe\\Events\\Virtual\\Meetings\\Google_Provider' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Google_Provider.php',
        'Tribe\\Events\\Virtual\\Meetings\\Meeting_Provider' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Meeting_Provider.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Abstract_Meetings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Abstract_Meetings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Account_API' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Account_API.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Actions' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Actions.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Api' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Api.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Classic_Editor' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Classic_Editor.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Email' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Email.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Event_Export' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Event_Export.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Event_Meta.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Meetings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Meetings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Settings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Url' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Url.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft\\Users' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft/Users.php',
        'Tribe\\Events\\Virtual\\Meetings\\Microsoft_Provider' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Microsoft_Provider.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Abstract_Meetings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Abstract_Meetings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Account_API' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Account_API.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Actions' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Actions.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Api' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Api.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Classic_Editor' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Classic_Editor.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Email' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Email.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Event_Export' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Event_Export.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Event_Meta.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Meetings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Meetings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Password' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Password.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Settings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Url' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Url.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex\\Users' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex/Users.php',
        'Tribe\\Events\\Virtual\\Meetings\\Webex_Provider' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Webex_Provider.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube\\Classic_Editor' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube/Classic_Editor.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube\\Connection' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube/Connection.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube\\Embeds' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube/Embeds.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube\\Event_Export' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube/Event_Export.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube/Event_Meta.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube/Settings.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube\\Url' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube/Url.php',
        'Tribe\\Events\\Virtual\\Meetings\\YouTube_Provider' => __DIR__ . '/../..' . '/src/Tribe/Meetings/YouTube_Provider.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Abstract_Meetings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Abstract_Meetings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Account_API' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Account_API.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Actions' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Actions.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Api' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Api.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Classic_Editor' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Classic_Editor.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Email' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Email.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Event_Export' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Event_Export.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Event_Meta.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Meetings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Meetings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Migration' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Migration.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Migration_Notice' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Migration_Notice.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\OAuth' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/OAuth.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Password' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Password.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Settings.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Url' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Url.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Users' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Users.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom\\Webinars' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom/Webinars.php',
        'Tribe\\Events\\Virtual\\Meetings\\Zoom_Provider' => __DIR__ . '/../..' . '/src/Tribe/Meetings/Zoom_Provider.php',
        'Tribe\\Events\\Virtual\\Metabox' => __DIR__ . '/../..' . '/src/Tribe/Metabox.php',
        'Tribe\\Events\\Virtual\\Models\\Event' => __DIR__ . '/../..' . '/src/Tribe/Models/Event.php',
        'Tribe\\Events\\Virtual\\OEmbed' => __DIR__ . '/../..' . '/src/Tribe/OEmbed.php',
        'Tribe\\Events\\Virtual\\ORM\\ORM_Provider' => __DIR__ . '/../..' . '/src/Tribe/ORM/ORM_Provider.php',
        'Tribe\\Events\\Virtual\\PUE' => __DIR__ . '/../..' . '/src/Tribe/PUE.php',
        'Tribe\\Events\\Virtual\\PUE\\Helper' => __DIR__ . '/../..' . '/src/Tribe/PUE/Helper.php',
        'Tribe\\Events\\Virtual\\Plugin' => __DIR__ . '/../..' . '/src/Tribe/Plugin.php',
        'Tribe\\Events\\Virtual\\Plugin_Register' => __DIR__ . '/../..' . '/src/Tribe/Plugin_Register.php',
        'Tribe\\Events\\Virtual\\Repositories\\Event' => __DIR__ . '/../..' . '/src/Tribe/Repositories/Event.php',
        'Tribe\\Events\\Virtual\\Rewrite\\Rewrite_Provider' => __DIR__ . '/../..' . '/src/Tribe/Rewrite/Rewrite_Provider.php',
        'Tribe\\Events\\Virtual\\Template' => __DIR__ . '/../..' . '/src/Tribe/Template.php',
        'Tribe\\Events\\Virtual\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Template_Modifications.php',
        'Tribe\\Events\\Virtual\\Traits\\With_AJAX' => __DIR__ . '/../..' . '/src/Tribe/Traits/With_AJAX.php',
        'Tribe\\Events\\Virtual\\Traits\\With_Nonce_Routes' => __DIR__ . '/../..' . '/src/Tribe/Traits/With_Nonce_Routes.php',
        'Tribe\\Events\\Virtual\\Updater' => __DIR__ . '/../..' . '/src/Tribe/Updater.php',
        'Tribe\\Events\\Virtual\\Utils' => __DIR__ . '/../..' . '/src/Tribe/Utils.php',
        'Tribe\\Events\\Virtual\\Views\\V2\\Breadcrumbs' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Breadcrumbs.php',
        'Tribe\\Events\\Virtual\\Views\\V2\\Query' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Query.php',
        'Tribe\\Events\\Virtual\\Views\\V2\\Repository' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Repository.php',
        'Tribe\\Events\\Virtual\\Views\\V2\\Title' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Title.php',
        'Tribe\\Events\\Virtual\\Views\\V2\\Views_Provider' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views_Provider.php',
        'Tribe\\Events\\Virtual\\Views\\V2\\Widgets\\Widget' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Widgets/Widget.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite138cda51755a39592bb91648662c931::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite138cda51755a39592bb91648662c931::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite138cda51755a39592bb91648662c931::$classMap;

        }, null, ClassLoader::class);
    }
}
