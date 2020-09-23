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

?>



