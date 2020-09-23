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

            global $wpdb;
            $pref = $wpdb->prefix;

            $users = $wpdb->get_results( 
                 $wpdb->prepare("

                    SELECT DISTINCT ID, user_nicename, user_email FROM {$pref}users as u
                        JOIN {$pref}usermeta as um
                            ON u.ID = um.user_id
                                WHERE u.ID = {$request['id']}
                 ")
            );  

            $users_data = [];

            foreach( $users as $user ) {

                    $data = [];        

                    if( have_rows('waiver', "user_$user->ID") ): 

                            while( have_rows('waiver', "user_$user->ID") ): the_row();

                                    $data[] = [ 
                                        "name" => get_sub_field('name'), 
                                        "lastname" => get_sub_field('last_name'),
                                        "birthday"  => get_sub_field('birthday')
                                    ];

                            endwhile;

                    endif;               

                    $users_data[] = [ 
                        "ID" => $user->ID,
                        "username" => $user->user_nicename,
                        "useremail" => $user->user_email,
                        "waivers" => $data
                    ];

            }

            if($users) {
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


?>


