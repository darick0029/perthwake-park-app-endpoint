<?php

/**
 *
 * Route to display all of the users with acf repeater fields
 *
 * @link       https://professionalwebsolutions.com.au/development-services/
 * @since      1.0.0
 *
 * @package    Perthwake_Park_App_Endpoint
 * @subpackage Perthwake_Park_App_Endpoint/public/partials
 */

class Get_All_Users_Route {
    
    public function __construct() {
        add_action( 'rest_api_init', array($this, 'pwp_get_all_users_route') );  
    }

    public function pwp_get_all_users() {

            global $wpdb;
            $pref = $wpdb->prefix;

            $users = $wpdb->get_results( 
                 $wpdb->prepare("

                    SELECT DISTINCT ID, user_nicename, user_email FROM {$pref}users as u
                        JOIN {$pref}usermeta as um
                        ON u.ID = um.user_id
                        LIMIT 10
                 ")
            );  

            $users_data = [];

            foreach( $users as $user ) {

                    $data = [];        

                    if( have_rows('waivers', "user_$user->ID") ): 

                            while( have_rows('waivers', "user_$user->ID") ): the_row();

                                    $data[] = [ 
                                        "completed" => get_sub_field('completed'),
                                        "name" => get_sub_field('name'), 
                                        "phone" => get_sub_field('phone'),
                                        "birthdate"  => get_sub_field('dob'),
                                        "postcode"  => get_sub_field('postcode'),
                                        "country"  => get_sub_field('country'),
                                        "agreement"  => get_sub_field('agreement'),
                                        "emergency_contact" => get_sub_field('emergency_contact'),
                                        "additional_minors" => get_sub_field('additional_minors'),
                                        "signature" => get_sub_field('signature'),
                                    ];

                            endwhile;

                    endif;   
                    
                    // Wordpres users default meta
                    $first_name = get_user_meta( $user->ID, 'first_name', true );
                    $last_name = get_user_meta( $user->ID, 'last_name', true );
                    
                    // Woocommerce customers meta
                    $billing_first_name = get_user_meta( $user->ID, 'billing_first_name', true );
                    $billing_last_name = get_user_meta( $user->ID, 'billing_last_name', true );
                    $billing_phone = get_user_meta( $user->ID, 'billing_phone', true );
                    $billing_postcode = get_user_meta( $user->ID, 'billing_postcode', true );
                    $billing_country = get_user_meta( $user->ID, 'billing_country', true );                    

                    $users_data[] = [ 
                        "ID" => $user->ID,
                        "first_name" => $first_name ? $first_name : $billing_first_name,
                        "last_name" => $last_name ? $last_name : $billing_last_name,
                        'birthdate' => $data[0]['birthdate'],
                        'phone' => $billing_phone,
                        'postcode' => $billing_postcode,
                        'country'   => $billing_country,
                        'emergency_contact' => $data[0]['emergency_contact'],
                        "waivers" => $data
                    ];

            }

            return [ 
                "app_user_data"  => $users_data,
            ];


    }
    
    public function pwp_get_all_users_route() {
        register_rest_route('pwp/v2', 'users/', array(
            "methods" => WP_REST_Server::READABLE, 
            "callback"	=> array( $this, 'pwp_get_all_users' ),
        ));       
    }
       
}

new Get_All_Users_Route();



