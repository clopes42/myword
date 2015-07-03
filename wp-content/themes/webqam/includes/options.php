<?php

require_once realpath(__DIR__ . '/class/themeOptionsForm.php');

/*
 

 Types : text, textarea, image
        field = array( label=> '', name=> '', type=> '' )

Tabs = array ( label => '', fields = > array( field, field, field ...))

 
 *  */


$fields_tabs1 = array(
    array(
        "label" => "champ texte",
        "name" => "name1",
        "type" => "text"),
    array(
        "label" => "Champ textarea",
        "name" => "name2",
        "type" => "textarea"),
    array(
        "label" => "Image ",
        "name" => "name3",
        "type" => "image"),
);

$fields_tabs2 = array(
    array(
        "label" => "Un autre champ texte",
        "name" => "name1",
        "type" => "text"),
    array(
        "label" => "Un autre champ textarea",
        "name" => "name2",
        "type" => "textarea"),
    array(
        "label" => "Un autre  image",
        "name" => "name3",
        "type" => "image"),
);


$fields = array(
    "tabs" => array(
        array(
            "label" => "Tab 1",
            "fields" => $fields_tabs1,
        ),
        array(
            "label" => "Tab 2",
            "fields" => $fields_tabs2,
        ),
    ),
);


$theme_options = new ThemeOptionsForm(get_option('sample_theme_options'), $fields);
