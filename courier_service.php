<?php
/*
Plugin Name: Courier Service
Plugin URI: https://
Description: Courier plugin.
Version: 1.0.0
Author: Asterisk
Author URI: https://
License: 
Text Domain: Courier Service
*/


if(!defined('ABSPATH')){
   exit;
}


if(!class_exists('CourierService'))
{
    register_activation_hook( __FILE__, 'add_capabilities' );

    function add_capabilities()
    {    
        $capabilities = array('manage_circulation');
        
        $user_role = get_role('administrator');

        foreach($capabilities as $cap) 
        {
            if(!$user_role->has_cap($cap)) {
                $user_role->add_cap( $cap );
            }
        }
    }


    register_activation_hook( __FILE__, 'add_pages' );

    function add_pages()
    {

        if (get_page_by_title('Parcel / Order Tracking') == NULL) {
            $tracking = array(
                'post_title' => __('Parcel / Order Tracking'),
                'post_content' => '[parcel_tracking]',
                'post_status' => 'publish',
                'post_type' => 'page',
            );
            wp_insert_post($tracking);
        }

    }


    register_activation_hook( __FILE__, 'add_tables' );

    //creating table in wordpress database
    function add_tables()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        
        //Create location table
        $location = $wpdb->prefix . "order_locations"; 

        /*$addcolumn = "ALTER TABLE $location ADD COLUMN contact TEXT NOT NULL";
        $wpdb->query($addcolumn);

        $addcolumn = "ALTER TABLE $location ADD COLUMN order_type TEXT NOT NULL";
        $wpdb->query($addcolumn);*/

        $location_query = "CREATE TABLE IF NOT EXISTS $location (
            id int NOT NULL AUTO_INCREMENT,
            order_id TEXT NOT NULL,
            order_location LONGTEXT NOT NULL,
            location_note LONGTEXT NOT NULL,
            location_note LONGTEXT NOT NULL,
            contact LONGTEXT NOT NULL,
            order_type LONGTEXT NOT NULL,
            time_stamp TEXT NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate";
        require_once( ABSPATH .'wp-admin/includes/upgrade.php' );
        dbDelta( $location_query );


        //Create points table
        $points = $wpdb->prefix . "points"; 

        $point_query = "CREATE TABLE IF NOT EXISTS $points (
            id int NOT NULL AUTO_INCREMENT,
            name TEXT NOT NULL,
            contact TEXT NOT NULL,
            location TEXT NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate";
        require_once( ABSPATH .'wp-admin/includes/upgrade.php' );
        dbDelta( $point_query );


        $parcels = $wpdb->prefix . "parcels"; 

        $parcels_query = "CREATE TABLE IF NOT EXISTS $parcels (
            id int NOT NULL AUTO_INCREMENT,
            parcel_number TEXT NOT NULL,
            parcel_content LONGTEXT NOT NULL,
            sending_date TEXT NOT NULL,
            sender_name TEXT NOT NULL,
            sender_contact TEXT NOT NULL,
            receiving_date TEXT NOT NULL,
            receiver_name TEXT NOT NULL,
            receiver_contact TEXT NOT NULL,
            contact_person TEXT NOT NULL,
            destination TEXT NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate";
        require_once( ABSPATH .'wp-admin/includes/upgrade.php' );
        dbDelta( $parcels_query );
    }


    add_action('wp_ajax_order_location', 'order_location', 10);
    add_action('wp_ajax_nopriv_order_location', 'order_location', 10);

    function order_location() {
        global $wpdb; 
        $wpdb->show_errors();
   
        $date =  date("Y-m-d h:i:sa");

        $run = $wpdb->insert(
            $wpdb->prefix.'order_locations', 
            array('order_id'=>$_POST["id"], 'order_location'=> $_POST["location"],
             'location_note'=> $_POST["location_note"],'time_stamp'=> $date, 'order_type'=> 'shop_order'),
            array('%s', '%s', '%s', '%s', '%s')
        );

        if ($run) {
            echo "success";

        } else {
            echo "failed";
        }
    
        //$wpdb->print_error();

        wp_die(); 
    }



    add_action('wp_ajax_locations', 'locations', 10);
    add_action('wp_ajax_nopriv_locations', 'locations', 10);

    function locations()
    {
        global $wpdb; 
        $wpdb->show_errors();
        $table_name = $wpdb->prefix.'order_locations'; 

         if ($_POST["type"] == "delete" ) {

            $run = $wpdb->delete($table_name, array("id" => $_POST["id"]));
            
            if ($run) {
                echo "success";

            } else {
                echo "failed";
            }

        } else if ($_POST["type"] == "update" ) {

            $run = $wpdb->update(
                $table_name, 
                array('order_location'=>$_POST["location"], 'location_note'=> $_POST["note"]), 
                array('id'=>$_POST["id"])
            );


            if ($run) {
                echo "success";

            } else {
                echo "failed";
            }


           //$wpdb->print_error();
        }

        wp_die(); 
    }



    add_action('wp_ajax_track', 'parcel_tracking', 10);
    add_action('wp_ajax_nopriv_track', 'parcel_tracking', 10);

    function parcel_tracking() {

        global $wpdb; 
        $wpdb->show_errors();
        $table_name = $wpdb->prefix."order_locations";
        $parcels = $wpdb->get_results("SELECT * FROM `$table_name` WHERE order_id = '$_POST[order_id]'");

        if ($parcels) {
    
            $json = json_encode($parcels, true);
        
            echo $json;
    
        } else {
            echo "failed";
        }

        wp_die(); 
    }


    //managing parcels
    add_action('wp_ajax_parcels', 'parcels');
    add_action( 'wp_ajax_nopriv_parcels', 'parcels' );

    function parcels()
    {
        global $wpdb; 
        $wpdb->show_errors();
        $table_name = $wpdb->prefix.'parcels'; 
        $date =  date("Y-m-d h:i:sa");

        if ($_POST["type"] == "add" ) {

            $parcel_number = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

            $run = $wpdb->insert(
                $wpdb->prefix.'order_locations', 
                array('order_id'=>$parcel_number, 'order_location'=> $_POST["current_location"], 'location_note'=> $_POST["location_note"],
                    'time_stamp'=> $date, 'order_type'=> 'parcel_order'),
                array('%s', '%s', '%s', '%s' ,'%s')
            );

            $run = $wpdb->insert(
                $table_name, 
                array('parcel_content'=>$_POST["parcel_content"], 'sending_date'=> $_POST["sending_date"], 'sender_name'=> $_POST["sender_name"], 'sender_contact'=> $_POST["sender_contact"],
                    'receiving_date'=> $_POST["receiving_date"], 'receiver_name'=> $_POST["receiver_name"],'receiver_contact'=> $_POST["receiver_contact"], 'parcel_number'=> $parcel_number,
                    'destination'=>$_POST["destination"], 'contact_person'=> $_POST["contact_person"]),
                array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
            );
            
            //$wpdb->print_error();

            if ($run) {
                echo "success";

            } else {
                echo "failed";
            }

        } else if ($_POST["type"] == "delete" ) {

            $run = $wpdb->delete($wpdb->prefix.'order_locations', array("order_id" => $_POST["parcel_number"]));

            $run = $wpdb->delete($table_name, array("id" => $_POST["id"]));
            
            if ($run) {
                echo "success";

            } else {
                echo "failed";
            }

        } else if ($_POST["type"] == "update" ) {

            $run = $wpdb->update(
                $table_name, 
                array('parcel_content'=>$_POST["parcel_content"], 'sending_date'=> $_POST["sending_date"], 'sender_name'=> $_POST["sender_name"], 'sender_contact'=> $_POST["sender_contact"],
                    'receiving_date'=> $_POST["receiving_date"], 'receiver_name'=> $_POST["receiver_name"],'receiver_contact'=> $_POST["receiver_contact"],
                    'destination'=>$_POST["destination"], 'contact_person'=> $_POST["contact_person"]), 
                array('parcel_number'=>$_POST["parcel_number"])
            );

            if ($_POST["current_location"] != "" && $_POST["location_note"] !="") {
                $run = $wpdb->insert(
                    $wpdb->prefix.'order_locations', 
                    array('order_id'=>$_POST["parcel_number"], 'order_location'=> $_POST["current_location"],
                    'location_note'=> $_POST["location_note"],'time_stamp'=> $date),
                    array('%s', '%s', '%s', '%s')
                );
            }

            if ($run) {
                echo "success";

            } else {
                echo "failed";
            }


           //$wpdb->print_error();
        }

        wp_die(); 
    }


    //managing pickup points
    add_action('wp_ajax_points', 'points');
    add_action( 'wp_ajax_nopriv_points', 'points' );

    function points()
    {
        global $wpdb; 
        $wpdb->show_errors();
        $table_name = $wpdb->prefix.'points'; 

        if ($_POST["type"] == "add" ) {
    
            $point = $wpdb->get_results("SELECT * FROM `$table_name` WHERE contact = '$_POST[contact]'");

            if ($point) {
                echo "exists";
                return;
            }

            $run = $wpdb->insert(
                $table_name, 
                array('name'=>$_POST["name"], 'contact'=> $_POST["contact"], 'location'=> $_POST["location"]),
                array('%s', '%s', '%s')
            );

            //$wpdb->print_error();

            if ($run) {
                echo "success";

            } else {
                echo "failed";
            }

        } else if ($_POST["type"] == "delete" ) {
    
            $run = $wpdb->delete($table_name, array("id" => $_POST["id"]));
            
            if ($run) {
                echo "success";

            } else {
                echo "failed";
            }

        } else if ($_POST["type"] == "update" ) {
            
            if($_POST["contact"] != $_POST["orig_contact"]) {
                $point = $wpdb->get_results("SELECT * FROM `$table_name` WHERE contact = '$_POST[contact]'");

                if ($point) {
                    echo "exists";
                    return;
                }
            }
            
            $run = $wpdb->update(
                $table_name, 
                array('name'=>$_POST["name"], 'contact'=> $_POST["contact"], 'location'=> $_POST["location"]), 
                array('id'=>$_POST["id"])
            );


            if ($run) {
                echo "success";

            } else {
                echo "failed";
            }

            //$wpdb->print_error();
        }

        wp_die(); 
    }
    

    //get locations
    add_action('wp_ajax_update_search_points', 'update_search_points');
    add_action( 'wp_ajax_nopriv_update_search_points', 'update_search_points' );

    function update_search_points()
    {
        if (!empty($_POST["keyword"])) {
            global $wpdb; 
            $table_name = $wpdb->prefix.'points';
            $keyword = $_POST["keyword"]; 
            $locations = $wpdb->get_results("SELECT * FROM $table_name WHERE location like '" . $keyword . "%'");

            if ($locations) {
            ?>
                <div style="padding: 10px;  width: 100%;">
            <?php foreach ($locations as $location) {
            ?>  
                <a href = "#" style="text-decoration: none; margin-bottom: 2px;" onClick="selectPoint<?php echo $_POST['id']; ?>('<?php echo $location->contact; ?>', '<?php echo $location->location; ?>');"><?php echo $location->location; ?></a>
                <hr style="margin-top: 5px; margin-bottom: 5px;"/>
            <?php
            }
            ?>
                </div>
            <?php 
                } else {
            ?>
                <div style="padding: 10px; width: 100%;">No search results</div>
                <script>
                    $("#<?php echo "contact_person".$_POST['id'];?>").val("");
                </script>
            <?php
                } 
        }
        wp_die(); 
    }


    //get destinations
    add_action('wp_ajax_search_points', 'search_points');
    add_action( 'wp_ajax_nopriv_search_points', 'search_points' );

    function search_points()
    {
        if (!empty($_POST["keyword"])) {
            global $wpdb; 
            $table_name = $wpdb->prefix.'points';
            $keyword = $_POST["keyword"]; 
            $locations = $wpdb->get_results("SELECT * FROM $table_name WHERE location like '" . $keyword . "%'");

            if ($locations) {
            ?>
                <div style="padding: 10px;  width: 100%;">
            <?php foreach ($locations as $location) {
            ?>  
                <a href = "#" style="text-decoration: none; margin-bottom: 2px;" onClick="selectPoint('<?php echo $location->contact; ?>', '<?php echo $location->location; ?>');"><?php echo $location->location; ?></a>
                <hr style="margin-top: 5px; margin-bottom: 5px;"/>
            <?php
                  }
            ?>
                </div>
            <?php 
            } else {
            ?>
                <div style="padding: 10px; width: 100%;">No search results</div>
                <script>
                    $("#contact_person").val("");
                </script>
            <?php
            } 
        }
        wp_die(); 
    }


    //get locations
    add_action('wp_ajax_update_search_locations', 'update_search_locations');
    add_action( 'wp_ajax_nopriv_update_search_locations', 'update_search_locations' );

    function update_search_locations()
    {
        if (!empty($_POST["keyword"])) {
            global $wpdb; 
            $table_name = $wpdb->prefix.'points';
            $keyword = $_POST["keyword"]; 
            $locations = $wpdb->get_results("SELECT * FROM $table_name WHERE location like '" . $keyword . "%'");

            if ($locations) {
            ?>
                <div style="padding: 10px;  width: 100%;">
            <?php foreach ($locations as $location) {
            ?>  
                <a href = "#" style="text-decoration: none; margin-bottom: 2px;" onClick="selectLocation<?php echo $_POST['id']; ?>('<?php echo $location->contact; ?>', '<?php echo $location->location; ?>');"><?php echo $location->location; ?></a>
                <hr style="margin-top: 5px; margin-bottom: 5px;"/>
            <?php
            }
            ?>
                </div>
            <?php 
                } else {
            ?>
                <div style="padding: 10px; width: 100%;">No search results</div>
                <script>
                    $("#<?php echo "contact_person1".$_POST['id'];?>").val("");
                </script>
            <?php
                } 
        }
        wp_die(); 
    }


    //get current locations
    add_action('wp_ajax_search_locations', 'search_locations');
    add_action( 'wp_ajax_nopriv_search_locations', 'search_locations' );

    function search_locations()
    {
        if (!empty($_POST["keyword"])) {
            global $wpdb; 
            $table_name = $wpdb->prefix.'points';
            $keyword = $_POST["keyword"]; 
            $locations = $wpdb->get_results("SELECT * FROM $table_name WHERE location like '" . $keyword . "%'");

            if ($locations) {
            ?>
                <div style="padding: 10px;  width: 100%;">
            <?php foreach ($locations as $location) {
            ?>  
                <a href = "#" style="text-decoration: none; margin-bottom: 2px;" onClick="selectLocation('<?php echo $location->contact; ?>', '<?php echo $location->location; ?>');"><?php echo $location->location; ?></a>
                <hr style="margin-top: 5px; margin-bottom: 5px;"/>
            <?php
                  }
            ?>
                </div>
            <?php 
            } else {
            ?>
                <div style="padding: 10px; width: 100%;">No search results</div>
                <script>
                    $("#contact_person1").val("");
                </script>
            <?php
            } 
        }
        wp_die(); 
    }



    add_action( 'woocommerce_payment_complete', 'update_location' );

    function update_location( $order_id ) {

        global $wpdb; 
        $run = $wpdb->insert(
            $wpdb->prefix.'order_locations', 
            array('order_id'=>$order_id, 'order_location'=> "Seller", 'location_note'=> 'This order is still with the seller.', 'order_type'=> 'shop_order'),
            array('%s', '%s', '%s', '%s')
        );
        
    }




    class CourierService
    {
        public function __construct()
        {
            add_action('admin_menu', array($this, 'admin_menu')); 

            add_action('init',  array($this, 'initialize'));

             //adding shortcode
             add_shortcode('parcel_tracking', array($this, 'parcel_tracking'));
        }
        

        //Adding menu and submenus in the admin dashboard
        public function admin_menu()
        {
            global $submenu;

            add_menu_page('Courier Service', 'Courier Service', 'manage_circulation', 'courier_service', 'courier_service', plugin_dir_url( __FILE__ ) .'/images/delivery.png', 4);
            add_submenu_page('courier_service', 'Shop Orders' , 'Shop Orders' , 'manage_circulation', 'shop_orders', array($this, 'shop_orders'));
            add_submenu_page('courier_service', 'Parcels' , 'Parcels' , 'manage_circulation', 'parcels', array($this, 'parcels'));
            add_submenu_page('courier_service', 'Locations' , 'Locations' , 'manage_circulation', 'locations', array($this, 'locations'));
            add_submenu_page('courier_service', 'Pickup Points' , 'Pickup Points' , 'manage_circulation', 'pickup_points', array($this, 'points'));

            unset($submenu['courier_service'][0]);
        }


        //intiailizing session
        public function initialize()
        {
           ob_start();
           session_start();
        }


        public function parcel_tracking()
        {
            include 'pages/tracking.php';
        }


        public function shop_orders()
        {
            global $wpdb; 
            $table_name1 = $wpdb->prefix."postmeta";
            $table_name2 = $wpdb->prefix."posts";
            $orders = $wpdb->get_results("SELECT ID, post_date FROM `$table_name2` WHERE post_type = 'shop_order'");
            
            //var_dump($orders);

            include "pages/orders.php";
        }


        public function parcels()
        {
            global $wpdb; 
            $table_name = $wpdb->prefix."parcels";
            $parcels = $wpdb->get_results("SELECT * FROM `$table_name`");
            include "pages/parcels.php";
        }


        public function locations()
        {
            global $wpdb; 
            $table_name = $wpdb->prefix."order_locations";
            $locations = $wpdb->get_results("SELECT * FROM `$table_name`");
            include "pages/locations.php";
        }

        public function points()
        {
            global $wpdb; 
            $table_name = $wpdb->prefix."points";
            $points = $wpdb->get_results("SELECT * FROM `$table_name`");
            include "pages/points.php";
        }

    }

    $CourierService = new CourierService();
}



