<?php

add_action('init', 'custom_stock');
function custom_stock(){
    register_post_type('stock', array(
        'labels'             => array(
            'name'               => 'Акции', // Основное название типа записи
            'singular_name'      => 'Акция', // отдельное название записи типа Book
            'add_new'            => 'Добавить',
            'add_new_item'       => 'Добавить новую акцию',
            'edit_item'          => 'Редактировать акцию',
            'new_item'           => 'Новая акция',
            'view_item'          => 'Посмотреть акцию',
            'search_items'       => 'Найти акцию',
            'not_found'          =>  'Акций не найдено',
            'not_found_in_trash' => 'В корзине не найдено акций',
            'parent_item_colon'  => '',
            'menu_name'          => 'Акции',

        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'show_in_rest'       => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title','editor','thumbnail'),
        'menu_icon'          => 'dashicons-food',
    ));
}

function my_dashicons() {
    wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'my_dashicons' );

//Enqueue the Dashicons script
add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
    wp_enqueue_style( 'dashicons' );
}
