<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit81b8b29eae27defff25e88e044774d13
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tribe\\Events\\' => 13,
            'TEC\\Events\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tribe\\Events\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Tribe',
        ),
        'TEC\\Events\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Events',
        ),
    );

    public static $classMap = array (
        'TEC\\Events\\Editor\\Full_Site\\Hooks' => __DIR__ . '/../..' . '/src/Events/Editor/Full_Site/Hooks.php',
        'TEC\\Events\\Editor\\Full_Site\\Provider' => __DIR__ . '/../..' . '/src/Events/Editor/Full_Site/Provider.php',
        'TEC\\Events\\Editor\\Full_Site\\Templates' => __DIR__ . '/../..' . '/src/Events/Editor/Full_Site/Templates.php',
        'TEC\\Events\\Legacy\\Views\\V1\\Provider' => __DIR__ . '/../..' . '/src/Events/Legacy/Views/V1/Provider.php',
        'Tribe\\Events\\Admin\\Filter_Bar\\Provider' => __DIR__ . '/../..' . '/src/Tribe/Admin/Filter_Bar/Provider.php',
        'Tribe\\Events\\Admin\\Notice\\Full_Site_Editor' => __DIR__ . '/../..' . '/src/Tribe/Admin/Notice/Full_Site_Editor.php',
        'Tribe\\Events\\Admin\\Notice\\Legacy_Views_Deprecation' => __DIR__ . '/../..' . '/src/Tribe/Admin/Notice/Legacy_Views_Deprecation.php',
        'Tribe\\Events\\Admin\\Provider' => __DIR__ . '/../..' . '/src/Tribe/Admin/Provider.php',
        'Tribe\\Events\\Admin\\Settings' => __DIR__ . '/../..' . '/src/Tribe/Admin/Settings.php',
        'Tribe\\Events\\Aggregator\\Processes\\Batch_Imports' => __DIR__ . '/../..' . '/src/Tribe/Aggregator/Processes/Batch_Imports.php',
        'Tribe\\Events\\Aggregator\\Record\\Batch_Queue' => __DIR__ . '/../..' . '/src/Tribe/Aggregator/Record/Batch_Queue.php',
        'Tribe\\Events\\Collections\\Lazy_Post_Collection' => __DIR__ . '/../..' . '/src/Tribe/Collections/Lazy_Post_Collection.php',
        'Tribe\\Events\\Editor\\Blocks\\Archive_Events' => __DIR__ . '/../..' . '/src/Tribe/Editor/Blocks/Archive_Events.php',
        'Tribe\\Events\\Editor\\Hooks' => __DIR__ . '/../..' . '/src/Tribe/Editor/Hooks.php',
        'Tribe\\Events\\Editor\\Objects\\Editor_Object_Interface' => __DIR__ . '/../..' . '/src/Tribe/Editor/Objects/Editor_Object_Interface.php',
        'Tribe\\Events\\Editor\\Objects\\Event' => __DIR__ . '/../..' . '/src/Tribe/Editor/Objects/Event.php',
        'Tribe\\Events\\Event_Status\\Admin_Template' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Admin_Template.php',
        'Tribe\\Events\\Event_Status\\Classic_Editor' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Classic_Editor.php',
        'Tribe\\Events\\Event_Status\\Compatibility\\Events_Control_Extension\\JSON_LD' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Compatibility/Events_Control_Extension/JSON_LD.php',
        'Tribe\\Events\\Event_Status\\Compatibility\\Events_Control_Extension\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Compatibility/Events_Control_Extension/Service_Provider.php',
        'Tribe\\Events\\Event_Status\\Compatibility\\Filter_Bar\\Detect' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Compatibility/Filter_Bar/Detect.php',
        'Tribe\\Events\\Event_Status\\Compatibility\\Filter_Bar\\Events_Status_Filter' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Compatibility/Filter_Bar/Events_Status_Filter.php',
        'Tribe\\Events\\Event_Status\\Compatibility\\Filter_Bar\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Compatibility/Filter_Bar/Service_Provider.php',
        'Tribe\\Events\\Event_Status\\Event_Meta' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Event_Meta.php',
        'Tribe\\Events\\Event_Status\\Event_Status_Provider' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Event_Status_Provider.php',
        'Tribe\\Events\\Event_Status\\JSON_LD' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/JSON_LD.php',
        'Tribe\\Events\\Event_Status\\Models\\Event' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Models/Event.php',
        'Tribe\\Events\\Event_Status\\Status_Labels' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Status_Labels.php',
        'Tribe\\Events\\Event_Status\\Template' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Template.php',
        'Tribe\\Events\\Event_Status\\Template_Modifications' => __DIR__ . '/../..' . '/src/Tribe/Event_Status/Template_Modifications.php',
        'Tribe\\Events\\I18n' => __DIR__ . '/../..' . '/src/Tribe/I18n.php',
        'Tribe\\Events\\Integrations\\Beaver_Builder' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Beaver_Builder.php',
        'Tribe\\Events\\Integrations\\Fusion\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Fusion/Service_Provider.php',
        'Tribe\\Events\\Integrations\\Fusion\\Widget_Shortcode' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Fusion/Widget_Shortcode.php',
        'Tribe\\Events\\Integrations\\Hello_Elementor\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Hello_Elementor/Service_Provider.php',
        'Tribe\\Events\\Integrations\\Hello_Elementor\\Templates' => __DIR__ . '/../..' . '/src/Tribe/Integrations/Hello_Elementor/Templates.php',
        'Tribe\\Events\\Integrations\\WPML\\Views\\V2\\Filters' => __DIR__ . '/../..' . '/src/Tribe/Integrations/WPML/Views/V2/Filters.php',
        'Tribe\\Events\\Integrations\\WP_Rocket' => __DIR__ . '/../..' . '/src/Tribe/Integrations/WP_Rocket.php',
        'Tribe\\Events\\Models\\Post_Types\\Event' => __DIR__ . '/../..' . '/src/Tribe/Models/Post_Types/Event.php',
        'Tribe\\Events\\Models\\Post_Types\\Organizer' => __DIR__ . '/../..' . '/src/Tribe/Models/Post_Types/Organizer.php',
        'Tribe\\Events\\Models\\Post_Types\\Venue' => __DIR__ . '/../..' . '/src/Tribe/Models/Post_Types/Venue.php',
        'Tribe\\Events\\Service_Providers\\Context' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/Context.php',
        'Tribe\\Events\\Service_Providers\\First_Boot' => __DIR__ . '/../..' . '/src/Tribe/Service_Providers/First_Boot.php',
        'Tribe\\Events\\Taxonomy\\Event_Tag' => __DIR__ . '/../..' . '/src/Tribe/Taxonomy/Event_Tag.php',
        'Tribe\\Events\\Taxonomy\\Taxonomy_Provider' => __DIR__ . '/../..' . '/src/Tribe/Taxonomy/Taxonomy_Provider.php',
        'Tribe\\Events\\Views\\V2\\Assets' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Assets.php',
        'Tribe\\Events\\Views\\V2\\Customizer' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer.php',
        'Tribe\\Events\\Views\\V2\\Customizer\\Configuration' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer/Configuration.php',
        'Tribe\\Events\\Views\\V2\\Customizer\\Hooks' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer/Hooks.php',
        'Tribe\\Events\\Views\\V2\\Customizer\\Notice' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer/Notice.php',
        'Tribe\\Events\\Views\\V2\\Customizer\\Section\\Events_Bar' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer/Section/Events_Bar.php',
        'Tribe\\Events\\Views\\V2\\Customizer\\Section\\Global_Elements' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer/Section/Global_Elements.php',
        'Tribe\\Events\\Views\\V2\\Customizer\\Section\\Month_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer/Section/Month_View.php',
        'Tribe\\Events\\Views\\V2\\Customizer\\Section\\Single_Event' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer/Section/Single_Event.php',
        'Tribe\\Events\\Views\\V2\\Customizer\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Customizer/Service_Provider.php',
        'Tribe\\Events\\Views\\V2\\Hooks' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Hooks.php',
        'Tribe\\Events\\Views\\V2\\Implementation_Error' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Implementation_Error.php',
        'Tribe\\Events\\Views\\V2\\Index' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Index.php',
        'Tribe\\Events\\Views\\V2\\Interfaces\\Repository_User_Interface' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Interfaces/Repository_User_Interface.php',
        'Tribe\\Events\\Views\\V2\\Interfaces\\View_Partial_Interface' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Interfaces/View_Partial_Interface.php',
        'Tribe\\Events\\Views\\V2\\Interfaces\\View_Url_Provider_Interface' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Interfaces/View_Url_Provider_Interface.php',
        'Tribe\\Events\\Views\\V2\\Kitchen_Sink' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Kitchen_Sink.php',
        'Tribe\\Events\\Views\\V2\\Manager' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Manager.php',
        'Tribe\\Events\\Views\\V2\\Messages' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Messages.php',
        'Tribe\\Events\\Views\\V2\\Query\\Abstract_Query_Controller' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Query/Abstract_Query_Controller.php',
        'Tribe\\Events\\Views\\V2\\Query\\Event_Query_Controller' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Query/Event_Query_Controller.php',
        'Tribe\\Events\\Views\\V2\\Repository\\Event_Period' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Repository/Event_Period.php',
        'Tribe\\Events\\Views\\V2\\Repository\\Event_Result' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Repository/Event_Result.php',
        'Tribe\\Events\\Views\\V2\\Repository\\Events_Result_Set' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Repository/Events_Result_Set.php',
        'Tribe\\Events\\Views\\V2\\Rest_Endpoint' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Rest_Endpoint.php',
        'Tribe\\Events\\Views\\V2\\Rewrite' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Rewrite.php',
        'Tribe\\Events\\Views\\V2\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Service_Provider.php',
        'Tribe\\Events\\Views\\V2\\Template' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template.php',
        'Tribe\\Events\\Views\\V2\\Template\\Event' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template/Event.php',
        'Tribe\\Events\\Views\\V2\\Template\\Excerpt' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template/Excerpt.php',
        'Tribe\\Events\\Views\\V2\\Template\\Featured_Title' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template/Featured_Title.php',
        'Tribe\\Events\\Views\\V2\\Template\\JSON_LD' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template/JSON_LD.php',
        'Tribe\\Events\\Views\\V2\\Template\\Page' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template/Page.php',
        'Tribe\\Events\\Views\\V2\\Template\\Promo' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template/Promo.php',
        'Tribe\\Events\\Views\\V2\\Template\\Settings\\Advanced_Display' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template/Settings/Advanced_Display.php',
        'Tribe\\Events\\Views\\V2\\Template\\Title' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template/Title.php',
        'Tribe\\Events\\Views\\V2\\Template_Bootstrap' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Template_Bootstrap.php',
        'Tribe\\Events\\Views\\V2\\Theme_Compatibility' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Theme_Compatibility.php',
        'Tribe\\Events\\Views\\V2\\Url' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Url.php',
        'Tribe\\Events\\Views\\V2\\Utils\\Separators' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Utils/Separators.php',
        'Tribe\\Events\\Views\\V2\\Utils\\Stack' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Utils/Stack.php',
        'Tribe\\Events\\Views\\V2\\Utils\\View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Utils/View.php',
        'Tribe\\Events\\Views\\V2\\V1_Compat' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/V1_Compat.php',
        'Tribe\\Events\\Views\\V2\\View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/View.php',
        'Tribe\\Events\\Views\\V2\\View_Interface' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/View_Interface.php',
        'Tribe\\Events\\Views\\V2\\View_Register' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/View_Register.php',
        'Tribe\\Events\\Views\\V2\\Views\\By_Day_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/By_Day_View.php',
        'Tribe\\Events\\Views\\V2\\Views\\Day_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Day_View.php',
        'Tribe\\Events\\Views\\V2\\Views\\Latest_Past_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Latest_Past_View.php',
        'Tribe\\Events\\Views\\V2\\Views\\List_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/List_View.php',
        'Tribe\\Events\\Views\\V2\\Views\\Month_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Month_View.php',
        'Tribe\\Events\\Views\\V2\\Views\\Reflector_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Reflector_View.php',
        'Tribe\\Events\\Views\\V2\\Views\\Traits\\Breakpoint_Behavior' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Traits/Breakpoint_Behavior.php',
        'Tribe\\Events\\Views\\V2\\Views\\Traits\\HTML_Cache' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Traits/HTML_Cache.php',
        'Tribe\\Events\\Views\\V2\\Views\\Traits\\Json_Ld_Data' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Traits/Json_Ld_Data.php',
        'Tribe\\Events\\Views\\V2\\Views\\Traits\\List_Behavior' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Traits/List_Behavior.php',
        'Tribe\\Events\\Views\\V2\\Views\\Traits\\With_Fast_Forward_Link' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Traits/With_Fast_Forward_Link.php',
        'Tribe\\Events\\Views\\V2\\Views\\Traits\\iCal_Data' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Traits/iCal_Data.php',
        'Tribe\\Events\\Views\\V2\\Views\\Widgets\\Widget_List_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Widgets/Widget_List_View.php',
        'Tribe\\Events\\Views\\V2\\Views\\Widgets\\Widget_View' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Views/Widgets/Widget_View.php',
        'Tribe\\Events\\Views\\V2\\Widgets\\Admin_Template' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Widgets/Admin_Template.php',
        'Tribe\\Events\\Views\\V2\\Widgets\\Assets' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Widgets/Assets.php',
        'Tribe\\Events\\Views\\V2\\Widgets\\Compatibility' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Widgets/Compatibility.php',
        'Tribe\\Events\\Views\\V2\\Widgets\\Service_Provider' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Widgets/Service_Provider.php',
        'Tribe\\Events\\Views\\V2\\Widgets\\Widget_Abstract' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Widgets/Widget_Abstract.php',
        'Tribe\\Events\\Views\\V2\\Widgets\\Widget_List' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/Widgets/Widget_List.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Links\\Google_Calendar' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Links/Google_Calendar.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Links\\Link_Abstract' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Links/Link_Abstract.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Links\\Link_Interface' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Links/Link_Interface.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Links\\Outlook_365' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Links/Outlook_365.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Links\\Outlook_Export' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Links/Outlook_Export.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Links\\Outlook_Live' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Links/Outlook_Live.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Links\\iCal' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Links/iCal.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Links\\iCalendar_Export' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Links/iCalendar_Export.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Request' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Request.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Single_Events' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Single_Events.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Template' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Template.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\Traits\\Outlook_Methods' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/Traits/Outlook_Methods.php',
        'Tribe\\Events\\Views\\V2\\iCalendar\\iCalendar_Handler' => __DIR__ . '/../..' . '/src/Tribe/Views/V2/iCalendar/iCalendar_Handler.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit81b8b29eae27defff25e88e044774d13::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit81b8b29eae27defff25e88e044774d13::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit81b8b29eae27defff25e88e044774d13::$classMap;

        }, null, ClassLoader::class);
    }
}
