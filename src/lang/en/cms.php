<?php

return [

    'page_title' => 'Admin',
    'logout' => 'Logout',
    'confirm_leave_msg' => 'There are unsaved data on this page. Are you sure you want to leave?',

    'change_password' => [   
        'title' => 'Change password',
        'button_save' => 'Save',
        'button_back' => 'Back',
    ],

    'export' => [
        'button_export' => 'Export'
    ],

    'form' => [
        'save_success_msg' => 'Save successful',
        'save_error_msg' => 'Save failed, refresh page and try again'
    ],

    'list' => [
        'buttons' => [
            'add' => 'Add',
            'add_new' => 'Add new',
            'save' => 'Save',
            'cancel' => 'Cancel',
            'delete' => '<i class="fa fa-trash"></i>',
            'edit' => '<i class="fa fa-pencil"></i>',
            'order' => 'Order',
        ],
        'filters_label' => 'Filters'
    ],

    'title' => [
        'add' => 'Add :title',
        'edit' => 'Edit :title',
    ], 

    'admins' => [   
        'tab' => 'Admin users',
        'singular' => 'Admin',
        'singular.edit' => 'Edit admin',
        'singular.add' => 'Add admin',
        'plural' => 'Admin users',

        'list' => [
            'name' => 'Name',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'active' => 'Active',
            'inactive' => 'Inactive',
            'button_change_password' => 'Change password',
        ],

        'form' => [
            'image' => 'Profile picture',
            'name' => 'Name',
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'active' => 'Active',
            'inactive' => 'Inactive',
            'email_exists' => 'This email address already exists',
            'password' => 'Password',
            'password_success_msg' => 'Password change successful',
        ],
    ],

    'emails' => [
        'tab' => 'Email templates',
        'singular' => 'Email template',
        'plural' => 'Email templates',
        'skip_confirm' => 'Are you sure you do not want to send out this email?',
        'list_label_name' => 'Name',
        'list_label_receiver' => 'Receiver',
        'list_label_trigger' => 'Trigger',
        'list_filter_name' => 'Name',
        'form_label_identifier' => 'Identifier',
        'form_label_receiver' => 'Receiver',
        'form_label_name' => 'Name',
        'form_label_description' => 'Description',
        'form_label_layout' => 'Layout',
        'form_label_subject' => 'Subject',
        'form_label_content' => 'Default content',
        'send_label_recipients' => 'Recipients',
        'send_label_subject' => 'Subject',
        'send_success' => 'Email sent',
        'send_error' => 'There was an error during sending out email',
    ],

    'translation' => [
        'tab' => 'Website contents',
        'singular' => 'Website content',
        'plural' => 'Website contents',
        'tag_label' => 'Tag',
        'filter_search' => 'Search',
        'btn_refresh_list' => 'Refresh list',
        'import_success' => 'Refresh successful',
        'import_error' => 'Import failed, refresh page and try again',
    ],
    
    'login' => [
        'email' => 'Email',
        'password' => 'Password',
        'remember' => 'Remember me',
        'login' => 'Login',
        'wrong_email' => 'Wrong email or password',
        'inactive' => 'Your account is inactive',
    ]
];
