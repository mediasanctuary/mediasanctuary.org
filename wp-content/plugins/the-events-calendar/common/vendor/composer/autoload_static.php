<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitad0687bc869e05f85e1b65fbbe653c57
{
    public static $prefixLengthsPsr4 = array (
        'l' => 
        array (
            'lucatume\\DI52\\' => 14,
        ),
        'T' => 
        array (
            'Tribe\\' => 6,
            'TEC\\Common\\' => 11,
        ),
        'S' => 
        array (
            'StellarWP\\Telemetry\\Views_Dir\\' => 30,
            'StellarWP\\Telemetry\\Assets_Dir\\' => 31,
            'StellarWP\\Telemetry\\' => 20,
            'StellarWP\\Installer\\Assets_JS\\' => 30,
            'StellarWP\\Installer\\Admin_Views\\' => 32,
            'StellarWP\\Installer\\' => 20,
            'StellarWP\\DB\\' => 13,
            'StellarWP\\ContainerContract\\' => 28,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Container\\' => 14,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'lucatume\\DI52\\' => 
        array (
            0 => __DIR__ . '/..' . '/lucatume/di52/src',
        ),
        'Tribe\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Tribe',
        ),
        'TEC\\Common\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Common',
        ),
        'StellarWP\\Telemetry\\Views_Dir\\' => 
        array (
            0 => __DIR__ . '/..' . '/stellarwp/telemetry/src/views',
        ),
        'StellarWP\\Telemetry\\Assets_Dir\\' => 
        array (
            0 => __DIR__ . '/..' . '/stellarwp/telemetry/src/resources',
        ),
        'StellarWP\\Telemetry\\' => 
        array (
            0 => __DIR__ . '/..' . '/stellarwp/telemetry/src/Telemetry',
        ),
        'StellarWP\\Installer\\Assets_JS\\' => 
        array (
            0 => __DIR__ . '/..' . '/stellarwp/installer/src/assets/js',
        ),
        'StellarWP\\Installer\\Admin_Views\\' => 
        array (
            0 => __DIR__ . '/..' . '/stellarwp/installer/src/admin-views',
        ),
        'StellarWP\\Installer\\' => 
        array (
            0 => __DIR__ . '/..' . '/stellarwp/installer/src/Installer',
        ),
        'StellarWP\\DB\\' => 
        array (
            0 => __DIR__ . '/..' . '/stellarwp/db/src/DB',
        ),
        'StellarWP\\ContainerContract\\' => 
        array (
            0 => __DIR__ . '/..' . '/stellarwp/container-contract/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'TEC\\Common\\Configuration\\Configuration' => __DIR__ . '/../..' . '/src/Common/Configuration/Configuration.php',
        'TEC\\Common\\Configuration\\Configuration_Loader' => __DIR__ . '/../..' . '/src/Common/Configuration/Configuration_Loader.php',
        'TEC\\Common\\Configuration\\Configuration_Provider_Interface' => __DIR__ . '/../..' . '/src/Common/Configuration/Configuration_Provider_Interface.php',
        'TEC\\Common\\Configuration\\Constants_Provider' => __DIR__ . '/../..' . '/src/Common/Configuration/Constants_Provider.php',
        'TEC\\Common\\Context\\Post_Request_Type' => __DIR__ . '/../..' . '/src/Common/Context/Post_Request_Type.php',
        'TEC\\Common\\Contracts\\Container' => __DIR__ . '/../..' . '/src/Common/Contracts/Container.php',
        'TEC\\Common\\Contracts\\Provider\\Controller' => __DIR__ . '/../..' . '/src/Common/Contracts/Provider/Controller.php',
        'TEC\\Common\\Contracts\\Service_Provider' => __DIR__ . '/../..' . '/src/Common/Contracts/Service_Provider.php',
        'TEC\\Common\\Editor\\Full_Site\\Template_Utils' => __DIR__ . '/../..' . '/src/Common/Editor/Full_Site/Template_Utils.php',
        'TEC\\Common\\Exceptions\\Container_Exception' => __DIR__ . '/../..' . '/src/Common/Exceptions/Container_Exception.php',
        'TEC\\Common\\Exceptions\\Not_Bound_Exception' => __DIR__ . '/../..' . '/src/Common/Exceptions/Not_Bound_Exception.php',
        'TEC\\Common\\Integrations\\Integration_Abstract' => __DIR__ . '/../..' . '/src/Common/Integrations/Integration_Abstract.php',
        'TEC\\Common\\Integrations\\Provider' => __DIR__ . '/../..' . '/src/Common/Integrations/Provider.php',
        'TEC\\Common\\Integrations\\Traits\\Module_Integration' => __DIR__ . '/../..' . '/src/Common/Integrations/Traits/Module_Integration.php',
        'TEC\\Common\\Integrations\\Traits\\Plugin_Integration' => __DIR__ . '/../..' . '/src/Common/Integrations/Traits/Plugin_Integration.php',
        'TEC\\Common\\Integrations\\Traits\\Server_Integration' => __DIR__ . '/../..' . '/src/Common/Integrations/Traits/Server_Integration.php',
        'TEC\\Common\\Integrations\\Traits\\Theme_Integration' => __DIR__ . '/../..' . '/src/Common/Integrations/Traits/Theme_Integration.php',
        'TEC\\Common\\Libraries\\Installer\\Provider' => __DIR__ . '/../..' . '/src/Common/Libraries/Installer/Provider.php',
        'TEC\\Common\\Libraries\\Provider' => __DIR__ . '/../..' . '/src/Common/Libraries/Provider.php',
        'TEC\\Common\\Site_Health\\Factory' => __DIR__ . '/../..' . '/src/Common/Site_Health/Factory.php',
        'TEC\\Common\\Site_Health\\Fields\\Generic_Info_Field' => __DIR__ . '/../..' . '/src/Common/Site_Health/Fields/Generic_Info_Field.php',
        'TEC\\Common\\Site_Health\\Fields\\Post_Status_Count_Field' => __DIR__ . '/../..' . '/src/Common/Site_Health/Fields/Post_Status_Count_Field.php',
        'TEC\\Common\\Site_Health\\Info_Field_Abstract' => __DIR__ . '/../..' . '/src/Common/Site_Health/Info_Field_Abstract.php',
        'TEC\\Common\\Site_Health\\Info_Field_Interface' => __DIR__ . '/../..' . '/src/Common/Site_Health/Info_Field_Interface.php',
        'TEC\\Common\\Site_Health\\Info_Section_Abstract' => __DIR__ . '/../..' . '/src/Common/Site_Health/Info_Section_Abstract.php',
        'TEC\\Common\\Site_Health\\Info_Section_Interface' => __DIR__ . '/../..' . '/src/Common/Site_Health/Info_Section_Interface.php',
        'TEC\\Common\\Site_Health\\Provider' => __DIR__ . '/../..' . '/src/Common/Site_Health/Provider.php',
        'TEC\\Common\\Storage\\Timed_Option' => __DIR__ . '/../..' . '/src/Common/Storage/Timed_Option.php',
        'TEC\\Common\\Telemetry\\Migration' => __DIR__ . '/../..' . '/src/Common/Telemetry/Migration.php',
        'TEC\\Common\\Telemetry\\Provider' => __DIR__ . '/../..' . '/src/Common/Telemetry/Provider.php',
        'TEC\\Common\\Telemetry\\Telemetry' => __DIR__ . '/../..' . '/src/Common/Telemetry/Telemetry.php',
        'TEC\\Common\\Translations_Loader' => __DIR__ . '/../..' . '/src/Common/Translations_Loader.php',
        'Tribe\\Admin\\Conditional_Content\\Black_Friday' => __DIR__ . '/../..' . '/src/Tribe/Admin/Conditional_Content/Black_Friday.php',
        'Tribe\\Admin\\Conditional_Content\\Datetime_Conditional_Abstract' => __DIR__ . '/../..' . '/src/Tribe/Admin/Conditional_Content/Datetime_Conditional_Abstract.php',
        'Tribe\\Admin\\Conditional_Content\\End_Of_Year_Sale' => __DIR__ . '/../..' . '/src/Tribe/Admin/Conditional_Content/End_Of_Year_Sale.php',
        'Tribe\\Admin\\Conditional_Content\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Admin/Conditional_Content/Service_Provider.php',
        'Tribe\\Admin\\Notice\\Date_Based' => __DIR__ . '/../..' . '/src/Tribe/Admin/Notice/Date_Based.php',
        'Tribe\\Admin\\Notice\\Marketing\\Black_Friday' => __DIR__ . '/../..' . '/src/Tribe/Admin/Notice/Marketing/Black_Friday.php',
        'Tribe\\Admin\\Notice\\Marketing\\End_Of_Year_Sale' => __DIR__ . '/../..' . '/src/Tribe/Admin/Notice/Marketing/End_Of_Year_Sale.php',
        'Tribe\\Admin\\Notice\\Marketing\\Stellar_Sale' => __DIR__ . '/../..' . '/src/Tribe/Admin/Notice/Marketing/Stellar_Sale.php',
        'Tribe\\Admin\\Notice\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Admin/Notice/Service_Provider.php',
        'Tribe\\Admin\\Notice\\WP_Version' => __DIR__ . '/../..' . '/src/Tribe/Admin/Notice/WP_Version.php',
        'Tribe\\Admin\\Pages' => __DIR__ . '/../..' . '/src/Tribe/Admin/Pages.php',
        'Tribe\\Admin\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Admin/Settings.php',
        'Tribe\\Admin\\Troubleshooting' => __DIR__ . '/../..' . '/src/Tribe/Admin/Troubleshooting.php',
        'Tribe\\Admin\\Upsell_Notice\\Main' => __DIR__ . '/../..' . '/src/Tribe/Admin/Upsell_Notice/Main.php',
        'Tribe\\Admin\\Wysiwyg' => __DIR__ . '/../..' . '/src/Tribe/Admin/Wysiwyg.php',
        'Tribe\\Customizer\\Control' => __DIR__ . '/../..' . '/src/Tribe/Customizer/Control.php',
        'Tribe\\Customizer\\Controls\\Heading' => __DIR__ . '/../..' . '/src/Tribe/Customizer/Controls/Heading.php',
        'Tribe\\Customizer\\Controls\\Number' => __DIR__ . '/../..' . '/src/Tribe/Customizer/Controls/Number.php',
        'Tribe\\Customizer\\Controls\\Radio' => __DIR__ . '/../..' . '/src/Tribe/Customizer/Controls/Radio.php',
        'Tribe\\Customizer\\Controls\\Range_Slider' => __DIR__ . '/../..' . '/src/Tribe/Customizer/Controls/Range_Slider.php',
        'Tribe\\Customizer\\Controls\\Separator' => __DIR__ . '/../..' . '/src/Tribe/Customizer/Controls/Separator.php',
        'Tribe\\Customizer\\Controls\\Toggle' => __DIR__ . '/../..' . '/src/Tribe/Customizer/Controls/Toggle.php',
        'Tribe\\DB_Lock' => __DIR__ . '/../..' . '/src/Tribe/DB_Lock.php',
        'Tribe\\Dialog\\View' => __DIR__ . '/../..' . '/src/Tribe/Dialog/View.php',
        'Tribe\\Editor\\Compatibility' => __DIR__ . '/../..' . '/src/Tribe/Editor/Compatibility.php',
        'Tribe\\Editor\\Compatibility\\Classic_Editor' => __DIR__ . '/../..' . '/src/Tribe/Editor/Compatibility/Classic_Editor.php',
        'Tribe\\Editor\\Compatibility\\Divi' => __DIR__ . '/../..' . '/src/Tribe/Editor/Compatibility/Divi.php',
        'Tribe\\Log\\Action_Logger' => __DIR__ . '/../..' . '/src/Tribe/Log/Action_Logger.php',
        'Tribe\\Log\\Canonical_Formatter' => __DIR__ . '/../..' . '/src/Tribe/Log/Canonical_Formatter.php',
        'Tribe\\Log\\Monolog_Logger' => __DIR__ . '/../..' . '/src/Tribe/Log/Monolog_Logger.php',
        'Tribe\\Log\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Log/Service_Provider.php',
        'Tribe\\Models\\Post_Types\\Base' => __DIR__ . '/../..' . '/src/Tribe/Models/Post_Types/Base.php',
        'Tribe\\Models\\Post_Types\\Nothing' => __DIR__ . '/../..' . '/src/Tribe/Models/Post_Types/Nothing.php',
        'Tribe\\Onboarding\\Hints_Abstract' => __DIR__ . '/../..' . '/src/Tribe/Onboarding/Hints_Abstract.php',
        'Tribe\\Onboarding\\Main' => __DIR__ . '/../..' . '/src/Tribe/Onboarding/Main.php',
        'Tribe\\Onboarding\\Tour_Abstract' => __DIR__ . '/../..' . '/src/Tribe/Onboarding/Tour_Abstract.php',
        'Tribe\\PUE\\Update_Prevention' => __DIR__ . '/../..' . '/src/Tribe/PUE/Update_Prevention.php',
        'Tribe\\Repository\\Core_Read_Interface' => __DIR__ . '/../..' . '/src/Tribe/Repository/Core_Read_Interface.php',
        'Tribe\\Repository\\Filter_Validation' => __DIR__ . '/../..' . '/src/Tribe/Repository/Filter_Validation.php',
        'Tribe\\Service_Providers\\Body_Classes' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Body_Classes.php',
        'Tribe\\Service_Providers\\Crons' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Crons.php',
        'Tribe\\Service_Providers\\Dialog' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Dialog.php',
        'Tribe\\Service_Providers\\Onboarding' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Onboarding.php',
        'Tribe\\Service_Providers\\PUE' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/PUE.php',
        'Tribe\\Service_Providers\\Shortcodes' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Shortcodes.php',
        'Tribe\\Service_Providers\\Tooltip' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Tooltip.php',
        'Tribe\\Service_Providers\\Widgets' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Widgets.php',
        'Tribe\\Shortcode\\Manager' => __DIR__ . '/../..' . '/src/Tribe/Shortcode/Manager.php',
        'Tribe\\Shortcode\\Shortcode_Abstract' => __DIR__ . '/../..' . '/src/Tribe/Shortcode/Shortcode_Abstract.php',
        'Tribe\\Shortcode\\Shortcode_Interface' => __DIR__ . '/../..' . '/src/Tribe/Shortcode/Shortcode_Interface.php',
        'Tribe\\Shortcode\\Utils' => __DIR__ . '/../..' . '/src/Tribe/Shortcode/Utils.php',
        'Tribe\\Tooltip\\View' => __DIR__ . '/../..' . '/src/Tribe/Tooltip/View.php',
        'Tribe\\Traits\\Cache_User' => __DIR__ . '/../..' . '/src/Tribe/Traits/Cache_User.php',
        'Tribe\\Traits\\With_DB_Lock' => __DIR__ . '/../..' . '/src/Tribe/Traits/With_DB_Lock.php',
        'Tribe\\Traits\\With_Meta_Updates_Handling' => __DIR__ . '/../..' . '/src/Tribe/Traits/With_Meta_Updates_Handling.php',
        'Tribe\\Traits\\With_Post_Attribute_Detection' => __DIR__ . '/../..' . '/src/Tribe/Traits/With_Post_Attribute_Detection.php',
        'Tribe\\Utils\\Body_Classes' => __DIR__ . '/../..' . '/src/Tribe/Utils/Body_Classes.php',
        'Tribe\\Utils\\Collection_Interface' => __DIR__ . '/../..' . '/src/Tribe/Utils/Collection_Interface.php',
        'Tribe\\Utils\\Collection_Trait' => __DIR__ . '/../..' . '/src/Tribe/Utils/Collection_Trait.php',
        'Tribe\\Utils\\Compatibility_Classes' => __DIR__ . '/../..' . '/src/Tribe/Utils/Compatibility_Classes.php',
        'Tribe\\Utils\\Date_I18n' => __DIR__ . '/../..' . '/src/Tribe/Utils/Date_I18n.php',
        'Tribe\\Utils\\Date_I18n_Immutable' => __DIR__ . '/../..' . '/src/Tribe/Utils/Date_I18n_Immutable.php',
        'Tribe\\Utils\\Element_Attributes' => __DIR__ . '/../..' . '/src/Tribe/Utils/Element_Attributes.php',
        'Tribe\\Utils\\Element_Classes' => __DIR__ . '/../..' . '/src/Tribe/Utils/Element_Classes.php',
        'Tribe\\Utils\\Lazy_Collection' => __DIR__ . '/../..' . '/src/Tribe/Utils/Lazy_Collection.php',
        'Tribe\\Utils\\Lazy_Events' => __DIR__ . '/../..' . '/src/Tribe/Utils/Lazy_Events.php',
        'Tribe\\Utils\\Lazy_String' => __DIR__ . '/../..' . '/src/Tribe/Utils/Lazy_String.php',
        'Tribe\\Utils\\Paths' => __DIR__ . '/../..' . '/src/Tribe/Utils/Paths.php',
        'Tribe\\Utils\\Post_Thumbnail' => __DIR__ . '/../..' . '/src/Tribe/Utils/Post_Thumbnail.php',
        'Tribe\\Utils\\Query' => __DIR__ . '/../..' . '/src/Tribe/Utils/Query.php',
        'Tribe\\Utils\\Strings' => __DIR__ . '/../..' . '/src/Tribe/Utils/Strings.php',
        'Tribe\\Utils\\Taxonomy' => __DIR__ . '/../..' . '/src/Tribe/Utils/Taxonomy.php',
        'Tribe\\Utils\\Theme_Compatibility' => __DIR__ . '/../..' . '/src/Tribe/Utils/Theme_Compatibility.php',
        'Tribe\\Values\\Abstract_Currency' => __DIR__ . '/../..' . '/src/Tribe/Values/Abstract_Currency.php',
        'Tribe\\Values\\Abstract_Value' => __DIR__ . '/../..' . '/src/Tribe/Values/Abstract_Value.php',
        'Tribe\\Values\\Currency_Interface' => __DIR__ . '/../..' . '/src/Tribe/Values/Currency_Interface.php',
        'Tribe\\Values\\Value_Calculation' => __DIR__ . '/../..' . '/src/Tribe/Values/Value_Calculation.php',
        'Tribe\\Values\\Value_Formatting' => __DIR__ . '/../..' . '/src/Tribe/Values/Value_Formatting.php',
        'Tribe\\Values\\Value_Interface' => __DIR__ . '/../..' . '/src/Tribe/Values/Value_Interface.php',
        'Tribe\\Values\\Value_Update' => __DIR__ . '/../..' . '/src/Tribe/Values/Value_Update.php',
        'Tribe\\Widget\\Manager' => __DIR__ . '/../..' . '/src/Tribe/Widget/Manager.php',
        'Tribe\\Widget\\Widget_Abstract' => __DIR__ . '/../..' . '/src/Tribe/Widget/Widget_Abstract.php',
        'Tribe\\Widget\\Widget_Interface' => __DIR__ . '/../..' . '/src/Tribe/Widget/Widget_Interface.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitad0687bc869e05f85e1b65fbbe653c57::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitad0687bc869e05f85e1b65fbbe653c57::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitad0687bc869e05f85e1b65fbbe653c57::$classMap;

        }, null, ClassLoader::class);
    }
}
