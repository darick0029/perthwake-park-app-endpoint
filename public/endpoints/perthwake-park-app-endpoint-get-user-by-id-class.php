<?php

/**
 *
 * Route to display user by ID
 *
 * @link       https://professionalwebsolutions.com.au/development-services/
 * @since      1.0.0
 *
 * @package    Perthwake_Park_App_Endpoint
 * @subpackage Perthwake_Park_App_Endpoint/public/partials
 */

class GET_User_By_ID {

    public function __construct() {
        add_action( 'rest_api_init', array($this, 'get_user_by_id_route') );  
    }

    public function pwp_get_user_by_ID( WP_REST_Request $request ) {

            $users_data = [];

            $data = [];        

            if( have_rows('waivers', "user_{$request['id']}") ): 

                    while( have_rows('waivers', "user_{$request['id']}") ): the_row();

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
                            
                            $dob = get_sub_field('dob');

                    endwhile;

            endif;     
            
            // Wordpres users default meta
            $first_name = get_user_meta( $request['id'], 'first_name', true );
            $last_name = get_user_meta( $request['id'], 'last_name', true );
            
            // Woocommerce customers meta
            $billing_first_name = get_user_meta( $request['id'], 'billing_first_name', true );
            $billing_last_name = get_user_meta( $request['id'], 'billing_last_name', true );
            $billing_phone = get_user_meta( $request[id], 'billing_phone', true );
            $billing_postcode = get_user_meta( $request[id], 'billing_postcode', true );
            $billing_country = get_user_meta( $request[id], 'billing_country', true );
            
            $users_data[] = [ 
                "ID" => $request['id'],
                "first_name" => $first_name ? $first_name : $billing_first_name,
                "last_name" => $last_name ? $last_name : $billing_last_name,
                'birthdate' => $data[0]['birthdate'],
                'phone' => $billing_phone,
                'postcode' => $billing_postcode,
                'country'   => $billing_country,
                'emergency_contact' => $data[0]['emergency_contact'],
                "waivers" => $data
            ];

            if($users_data) {
                return [ "app_user_data"  => $users_data ];
            } else {
                return [ "message" => "No user Found" ];
            }

    }

    public function get_user_by_id_route() {
        register_rest_route('pwp/v2', 'users/(?P<id>\d+)', array(
            "methods" => WP_REST_Server::READABLE, 
            "callback"	=> array( $this, 'pwp_get_user_by_ID' )
        ));        
    }
    
    
}

new GET_User_By_ID();



