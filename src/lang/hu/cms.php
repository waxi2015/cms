<?php

return [

    'page_title' => 'Admin',
    'logout' => 'Kilépés',
    'confirm_leave_msg' => 'Az oldalon nem mentett adatok vannak.',

    'change_password' => [   
        'title' => 'Jelszó módosítása',
        'button_save' => 'Mentés',
        'button_back' => 'Vissza',
    ],

    'export' => [
        'button_export' => 'Export'
    ],

    'form' => [
        'save_success_msg' => 'Mentés sikeres',
        'save_error_msg' => 'Mentés sikertelen, frissítsd az oldal és próbáld újra'
    ],

    'list' => [
        'buttons' => [
            'add' => 'Hozzáadás',
            'add_new' => 'Új hozzáadása',
            'save' => 'Mentés',
            'cancel' => 'Mégse',
            'delete' => '<i class="fa fa-trash"></i>',
            'edit' => '<i class="fa fa-pencil"></i>',
            'order' => 'Sorrend',
        ]
    ],

    'title' => [
        'add' => ':title hozzáadása',
        'edit' => ':title szerkesztése',
    ], 

    'admins' => [   
        'tab' => 'Admin felhasználók',
        'singular' => 'Admin',
        'singular.edit' => 'Admin hozzáadása',
        'singular.add' => 'Admin hozzáadása',
        'plural' => 'Admin felhasználók',

        'list' => [
            'name' => 'Név',
            'email' => 'Email',
            'role' => 'Jogosultság',
            'status' => 'Státusz',
            'active' => 'Aktív',
            'inactive' => 'Inaktív',
            'button_change_password' => 'Jelszó módosítása',
        ],

        'form' => [
            'image' => 'Profil kép',
            'name' => 'Név',
            'email' => 'Email',
            'firstname' => 'Keresztnév',
            'lastname' => 'Vezetéknév',
            'role' => 'Jogosultság',
            'status' => 'Státusz',
            'active' => 'Aktív',
            'inactive' => 'Inaktív',
            'email_exists' => 'Ez az email cím már létezik',
            'password' => 'Jelszó',
            'password_success_msg' => 'Sikeres jelszó módosítás',
        ],
    ],

    'emails' => [
        'tab' => 'Email sablonok',
        'singular' => 'Email sablon',
        'plural' => 'Email sablonok',
        'skip_confirm' => 'Biztos, hogy nem küldesz ki emailt?',
        'list_label_name' => 'Név',
        'list_label_receiver' => 'Címzett',
        'list_label_trigger' => 'Esemény',
        'list_filter_name' => 'Név',
        'form_label_identifier' => 'Azonosító',
        'form_label_receiver' => 'Címzett',
        'form_label_name' => 'Név',
        'form_label_description' => 'Leírás',
        'form_label_layout' => 'Sablon',
        'form_label_subject' => 'Tárgy',
        'form_label_content' => 'Tartalom',
        'send_label_recipients' => 'Címzettek',
        'send_label_subject' => 'Tárgy',
        'send_success' => 'Email elküldve',
        'send_error' => 'Hiba lépett fel az email küldése során',
    ],

    'translation' => [
        'tab' => 'Weboldal tartalmak',
        'singular' => 'Weboldal tartalom',
        'plural' => 'Weboldal tartalmak',
        'tag_label' => 'Címke',
        'filter_search' => 'Keresés',
        'btn_refresh_list' => 'Lista frissítése',
        'import_success' => 'Frissítés sikeres',
        'import_error' => 'Az importálás sikertelen, kérjük frissítsd az oldald és próbáld meg újból',
    ],
    
    'login' => [
        'email' => 'Email',
        'password' => 'Jelszó',
        'remember' => 'Jegyezzen meg',
        'login' => 'Belépés',
        'wrong_email' => 'Hibás email cím vagy jelszó',
        'inactive' => 'Ez a fiók inaktív',
    ]
];
