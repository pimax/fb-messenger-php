<?php

namespace pimax\Menu;

/**
 * Class LocalizedMenu
 * @package pimax\Menu
 */
class LocalizedMenu
{

    private $locale ;

    private $composer_input_disabled ;

    private $menuItems;

    public function __construct($locale, $composer_input_disabled, $menuItems = null) {
        
        $this->locale = $locale;
        $this->composer_input_disabled = $composer_input_disabled;
        $this->menuItems = $menuItems;
    }

    public function getData(){
        $result = [
            'locale' => $this->locale,
            'composer_input_disabled' => $this->composer_input_disabled
        ];

        if(isset($this->menuItems)){
            foreach ($this->menuItems as $menuItem){
                $result['call_to_actions'][] = $menuItem->getData();
            }
        }
        return $result;
    }
}
