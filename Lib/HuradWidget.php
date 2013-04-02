<?php

/**
 * Description of HuradSidebar
 *
 * @author mohammad
 */
class HuradWidget {

    public static $sidebars = array();
    public static $widgets = array();

    public function registerSidebar($args = array()) {
        $i = count(self::$sidebars) + 1;

        $defaults = array(
            'id' => "sidebar-$i",
            'name' => __('Sidebar %d', $i),
            'description' => __('Default description for this sidebar'),
        );

        $sidebar = Functions::hr_parse_args($args, $defaults);

        self::$sidebars[$sidebar['id']] = $sidebar;

        Configure::write('sidebars', self::$sidebars);
    }

    public function registerWidget($args = array()) {
        $i = count(self::$widgets) + 1;

        if (!isset($args['id'])) {
            $args['id'] = "widget-" . strtolower(Inflector::slug($args['title']));
        }

        $defaults = array(
            'id' => "widget-$i",
            'title' => __('Widget %d', $i),
            'description' => __('Default description for this widget'),
            'element' => '',
        );

        $widget = Functions::hr_parse_args($args, $defaults);

        self::$widgets[$widget['id']] = $widget;

        Configure::write('widgets', self::$widgets);
    }

    public function maxNumber($widgetID = null) {
        $optionName = Configure::read('template') . '.widgets';
        $sidebarsWidgets = unserialize(Configure::read($optionName));

        if ($sidebarsWidgets) {
            $idArray = Hash::extract($sidebarsWidgets, '{s}.{s}.widget-id');
            $numArray = Hash::extract($sidebarsWidgets, '{s}.{s}.number');

            for ($index = 0; $index < count($idArray); $index++) {
                $newArray[][$idArray[$index]] = $numArray[$index];
            }

            if (count(Hash::extract($newArray, '{n}.' . $widgetID)) == 0) {
                return 1;
            } else {
                return max(Hash::extract($newArray, '{n}.' . $widgetID)) + 1;
            }
        } else {
            return 1;
        }
    }

    public function getWidgetData($uniqueId) {
        $optionName = Configure::read('template') . '.widgets';
        $sidebarsWidgets = unserialize(Configure::read($optionName));

        $getAllData = Hash::extract($sidebarsWidgets, '{s}.' . $uniqueId);

        $removeNumber = Hash::remove($getAllData, '{n}.number');
        $removeWidgetId = Hash::remove($removeNumber, '{n}.widget-id');
        $getUserData = Hash::remove($removeWidgetId, '{n}.unique-id');

        return $getUserData[0];
    }

}