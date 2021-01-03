<?php
class STpackage{
    public $plugin_url;
    function __construct(){
        add_filter('st_demo_packages',array($this,'_add_package'));

        add_filter('st_demo_packages_config_affiliate',array($this,'_get_config_affiliate'));
        add_filter('st_demo_packages_config_activity',array($this,'_get_config_activity'));
        add_filter('st_demo_packages_config_arabic',array($this,'_get_config_arabic'));
        add_filter('st_demo_packages_config_car',array($this,'_get_config_car'));
        add_filter('st_demo_packages_config_hiking', array($this, '_get_config_hiking'));
        add_filter('st_demo_packages_config_citytour', array($this, '_get_config_citytour'));
        add_filter('st_demo_packages_config_hostel', array($this, '_get_config_hostel'));
        add_filter('st_demo_packages_config_hotel', array($this, '_get_config_hotel'));
        add_filter('st_demo_packages_config_hotel_tour',array($this,'_get_config_hotel_tour'));
        add_filter('st_demo_packages_config_light',array($this,'_get_config_light'));
        add_filter('st_demo_packages_config_mixmap',array($this,'_get_config_mixmap'));
        add_filter('st_demo_packages_config_new_hotel',array($this,'_get_config_new_hotel'));
        add_filter('st_demo_packages_config_rental',array($this,'_get_config_rental'));
        add_filter('st_demo_packages_config_single_hotel',array($this,'_get_config_single_hotel'));
        add_filter('st_demo_packages_config_sintour', array($this, '_get_config_sintour'));
        add_filter('st_demo_packages_config_tour',array($this,'_get_config_tour'));
        add_filter('st_demo_packages_config_traveler_tour',array($this,'_get_config_traveler_tour'));
        add_filter('st_demo_packages_config_yatour', array($this, '_get_config_yatour'));
        add_filter('st_demo_packages_config_solotour', array($this, '_get_config_solotour'));
    }
    public function _get_config_solotour(){
        return array(
            'st_over_menus' => array(
                "Solo Menu" => "primary",
            ),
            'homepage_default' => 'home-solo',
            'homepost_default' => '',
        );
    }
    public function _get_config_yatour(){
        return array(
            'st_over_menus' => array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default' => 'Tour Home Page New',
            'homepost_default' => '',
        );
    }
    public function _get_config_tour(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Tour Home Page',
            'homepost_default'=>'',
        );
    }
    public function _get_config_traveler_tour(){
        return array(
            'st_over_menus'=>array(
                "Main Menu" => "primary",
            ),
            'homepage_default'=>'Home Layout Default | Traveler',
            'homepost_default'=>''
        );
    }
    public function _get_config_sintour(){
        return array(
            'st_over_menus' => array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default' => 'Tour Home Page New',
            'homepost_default' => '',
        );
    }
    public function _get_config_single_hotel(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Home page',
            'homepost_default'=>'',
        );
    }
    public function _get_config_rental(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Home Page',
            'homepost_default'=>''
        );
    }
    public function _get_config_new_hotel(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Home page',
            'homepost_default'=>'',
        );
    }
    public function _get_config_mixmap(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Home page',
            'homepost_default'=>''
        );
    }
    public function _get_config_light(){
        return array(
            'st_over_menus'=>array(
                "Main Menu" => "primary",
            ),
            'homepage_default'=>'Home Layout Default | Traveler',
            'homepost_default'=>''
        );
    }
    public function _get_config_hotel_tour(){
        return array(
            'st_over_menus'=>array(
                "Main Menu" => "primary",
            ),
            'homepage_default'=>'Home Layout Default | Traveler',
            'homepost_default'=>''
        );
    }
    public function _get_config_hotel(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Home page',
            'homepost_default'=>'',
        );
    }
    public function _get_config_hostel(){
        return array(
            'st_over_menus' => array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default' => 'Home page',
            'homepost_default' => '',
        );
    }
    public function _get_config_hiking(){
        return array(
            'st_over_menus' => array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default' => 'Tour Home Page New',
            'homepost_default' => '',
        );
    }
    public function _get_config_citytour(){
        return array(
            'st_over_menus' => array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default' => 'Tour Home Page',
            'homepost_default' => '',
        );
    }
    public function _get_config_car(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Home page',
            'homepost_default'=>''
        );
    }
    public function _get_config_affiliate(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Home Affiliate',
            'homepost_default'=>'',
        );
    }
    public function _get_config_activity(){
        return array(
            'st_over_menus'=>array(
                "Hotel Menu" => "primary",
            ),
            'homepage_default'=>'Home page',
            'homepost_default'=>''
        );
    }
    public function _get_config_arabic(){
        return array(
            'st_over_menus'=>array(
                "Main Menu" => "primary",
            ),
            'homepage_default'=>'Home Layout Default | Traveler',
            'homepost_default'=>''
        );
    }
    function _add_package($package)
        {
            $package['activity']=array(
                'object'=>$this,
                'title'=>__("Activity",'traveler'),
                'preview_image'=>"http://shinetheme.com/demosd/importer/activity/preview.png"
            );
            $package['affiliate']=array(
				'object'=>$this,
				'title'=>__("Affiliate",'traveler'),
				'preview_image'=>"http://shinetheme.com/demosd/importer/affiliate/preview.png"
            );
            $package['car']=array(
				'object'=>$this,
				'title'=>__("Car",'traveler'),
				'preview_image'=>"http://shinetheme.com/demosd/importer/car/preview.png"
            );
            $package['citytour'] = array(
                'object' => $this,
                'title' => __("CityTour", 'traveler'),
                'preview_image' => "http://shinetheme.com/demosd/importer/citytour/preview.png"
            );
            $package['sintour'] = array(
                'object' => $this,
                'title' => __("SinTour", 'traveler'),
                'preview_image' => "http://shinetheme.com/demosd/importer/sintour/preview.png"
            );
            $package['hostel'] = array(
                'object' => $this,
                'title' => __("Hostel", 'traveler'),
                'preview_image' => "http://shinetheme.com/demosd/importer/hostel/preview.png"
            );
            $package['hotel']=array(
                'object'=>$this,
                'title'=>__("Hotel",'traveler'),
                'preview_image'=>"http://shinetheme.com/demosd/importer/hotel/preview.png"
            );
            $package['hotel_tour']=array(
                'object'=>$this,
                'title'=>__("Hotel - Tour",'traveler'),
                'preview_image'=>"http://shinetheme.com/demosd/importer/hotel_tour/preview.png"
            );
            $package['light']=array(
                'object'=>$this,
                'title'=>__("All Services",'traveler'),
                'preview_image'=>"http://shinetheme.com/demosd/importer/light/preview.png"
            );
            $package['mixmap']=array(
                'object'=>$this,
                'title'=>__("Mix Services",'traveler'),
                'preview_image'=>"http://shinetheme.com/demosd/databases/mixmap/preview.png"
            );
            $package['new_hotel']=array(
				'object'=>$this,
				'title'=>__("New Hotel",'traveler'),
				'preview_image'=>"http://shinetheme.com/demosd/importer/new_hotel/preview.png"
            );
            $package['rental']=array(
                'object'=>$this,
                'title'=>__("Rental",'traveler'),
                'preview_image'=>"http://shinetheme.com/demosd/importer/rental/preview.png"
            );
            $package['single_hotel']=array(
				'object'=>$this,
				'title'=>__("Single Hotel",'traveler'),
				'preview_image'=>"http://shinetheme.com/demosd/importer/single_hotel/preview.png"
            );
            $package['hiking'] = array(
                'object' => $this,
                'title' => __("Hiking", 'traveler'),
                'preview_image' => "http://shinetheme.com/demosd/importer/hiking/preview.png"
            );
            $package['tour']=array(
				'object'=>$this,
				'title'=>__("Tour",'traveler'),
				'preview_image'=>"http://shinetheme.com/demosd/importer/tour/preview.png"
            );
            $package['traveler-tour']=array(
				'object'=>$this,
				'title'=>__("Traveler Tour",'traveler'),
				'preview_image'=>"http://shinetheme.com/demosd/importer/traveler-tour/preview.png"
            );
            $package['yatour'] = array(
                'object' => $this,
                'title' => __("YaTour", 'traveler'),
                'preview_image' => "http://shinetheme.com/demosd/importer/yatour/preview.png"
            );
            $package['solotour'] = array(
                'object' => $this,
                'title' => __("SoloTour", 'traveler'),
                'preview_image' => "http://shinetheme.com/demosd/importer/solotour/preview.png"
            );
            
            return $package;
        }
}
new STpackage;

?>