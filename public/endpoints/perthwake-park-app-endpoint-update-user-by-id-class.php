<?php

/**
 *
 * Update Users By ID
 *
 * @link       https://professionalwebsolutions.com.au/development-services/
 * @since      1.0.0
 *
 * @package    Perthwake_Park_App_Endpoint
 * @subpackage Perthwake_Park_App_Endpoint/public/partials
 */

class UPDATE_Users_by_ID_Route {
    
    public function __construct() {
        add_action( 'rest_api_init', array($this, 'pwp_update_user_by_id_route') );  
    }

    // Route for Editing the users waivers
    public function pwp_put_user_by_ID( WP_REST_Request $request ) {
 
        //$data = $request['waivers'];
        $user_fname = $request['first_name'];
        $user_lname = $request['last_name'];
        //$birthdate = array(array( "dob" => $request['birthdate'] ));

        
        
        update_user_meta( $request['id'], 'first_name', $user_fname );
        update_user_meta( $request['id'], 'last_name', $user_lname ); 
        

        $field_key = "field_5ee07c1b6fecf";
        

        //update_field( $field_key, $data, "user_{$request['id']}" ); 
        //update_field( $field_key, $birthdate, "user_{$request['id']}" ); 
        
		$data = array(
		    'completed' => $request['waivers'][0]['completed'],
			'name' => $request['waivers'][0]['name'],
            "phone" => $request['waivers'][0]['phone'],
            "dob" => $request['waivers'][0]['dob'],
            "postcode" => $request['waivers'][0]['postcode'],
            "country" => $request['waivers'][0]['country'],
            "agreement" => $request['waivers'][0]['agreement'],	
            "emergency_contact" => $request['waivers'][0]['emergency_contact'],	
            "additional_minors" => $request['waivers'][0]['additional_minors'],	
		);
        
        add_row( $field_key, $data, "user_{$request['id']}" ); 

        return array( 
            "ID" => $request['id'],
            "first_name" => $fname, 
            "waivers" => $data 
        );

    }


    public function pwp_update_user_by_id_route() {
        register_rest_route('pwp/v2', 'users/(?P<id>\d+)', array(
            "methods" => WP_REST_Server::EDITABLE,
            "callback"	=> array($this, 'pwp_put_user_by_ID'),
            "args"  => [
                "first_name" => [
                    "type" => "string",
                ],
                "last_name" => [
                    "type" => "string",
                ],   
                "waivers" => [
                    "type" => "object",
                ]       
            ]
        ));     
    }
       
}

new UPDATE_Users_by_ID_Route();


/*    // Format
    $field_key = "field_5f5fdc07fdadd";
    $value = array(
        array( "name" => "Uchiha Madarick" ),
    );
    update_field( $field_key, $value, "user_1" ); */    


    // not working after decoding
    //return array( "test" => "{$jData[0]['first_name']}" );

    // works if not decoded
    //return array( "test" => "{$data[1]['first_name']}" );

/*
    // This is my object example just for testing purposes in postman.

    {
        "waiver" : [
            {
                "name": "Darick",
                "last_name":  "Quinto",
                "birthday": "06/29/1983"             
            },
            {
                "name": "Lance",
                "last_name":  "Atienza",
                "birthday": ""             
            },
            {
                "name": "Shyrel",
                "last_name":  "De los santos",
                "birthday": ""             
            }                  
        ]
    }

*/

