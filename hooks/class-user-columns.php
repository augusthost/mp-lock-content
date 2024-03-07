<?php

namespace MP\hooks;

class MPCustomUserColumn{

    public function __construct()
    {
        add_filter( 'manage_users_columns', [$this, 'mp_custom_user_table_column'] );
        add_action( 'manage_users_custom_column', [$this, 'mp_custom_user_table_column_data'], 10, 3 );
    }

    // Add new column to user table
    public function mp_custom_user_table_column( $columns ) {
        $columns['phone'] = 'Phone';
        $columns['organization'] = 'Organization';
        return $columns;
    }

    // Display phone number in new column
    public function mp_custom_user_table_column_data( $value, $column_name, $user_id ) {
        $user_info = get_userdata( $user_id );
        if ( 'phone' == $column_name ) {
            return $user_info->phone;
        }

        if ( 'organization' == $column_name ) {
            return $user_info->organization;
        }

        return $value;
    }

}

if(!class_exists('MPCustomUserColumn')){
    new MPCustomUserColumn();
}

