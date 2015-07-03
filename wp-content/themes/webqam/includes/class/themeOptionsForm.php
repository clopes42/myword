<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ThemeOptionsForm
{

    private $context = 'sample_theme_options';
    private $options;
    private $fields;

    function __construct($options, $fields)
    {

        add_action('admin_init', array(
            $this,
            'theme_options_init'));
        add_action('admin_menu', array(
            $this,
            'theme_options_add_page'));

        add_action('admin_enqueue_scripts', array(
            $this,
            'enqueue_admin_scripts'));

        $this->options = get_option('sample_theme_options');
        $this->set_fields($fields);
    }

    function enqueue_admin_scripts($hook)
    {
        if ($hook == 'appearance_page_theme_options') {
            // Enqueue custom option panel JS
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('options-js', get_template_directory_uri() . '/includes/assets/options.js', array(
                'jquery',
                'jquery-ui-core',
                'jquery-ui-tabs'), '');

            wp_enqueue_style('options-css', get_template_directory_uri() . '/includes/assets/options.css', array(), '');
        }
    }

    function get_theme_option($opt)
    {
        if (isset($this->options[$opt])) {
            return $this->options[$opt];
        } else {
            return '';
        }
    }

    function set_fields($fields)
    {
        $this->fields = $fields;
    }

    private function get_fields()
    {
        return $this->fields;
    }

    /*
     * Init options page
     */

    function theme_options_init()
    {
        register_setting('sample_options', 'sample_theme_options');
    }

    /*
     *  Add Page to Wordpress      
     */

    function theme_options_add_page()
    {
        add_theme_page(__('Options du thème', 'sampletheme'), __('Options du thème', 'sampletheme'), 'edit_theme_options', 'theme_options', array(
            $this,
            'theme_options_do_page'));
    }

    /*
     *  Display Options Page
     */

    function theme_options_do_page()
    {
        global $select_options;

        if (!isset($_REQUEST['settings-updated'])) {
            $_REQUEST['settings-updated'] = false;
        }

        // TODO: clean this html from here


        echo'<div class="wrap">
                    <h2>' . __('Options du thème', 'sampletheme') . '</h2>';

        if (false !== $_REQUEST['settings-updated']):
            echo '<p><strong>' . __('Options sauvegardées', 'sampletheme') . '</strong></p>';
        endif;
        echo '<form method="post" action="options.php">';
        settings_fields('sample_options');

        $fields = $this->get_fields();
        if (array_key_exists('tabs', $fields)) {

            echo '<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">';
            echo '<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">';
            $i = 1;
            foreach ($fields['tabs'] as $tab) {
                echo '<li class="ui-state-default ui-corner-top" role="tab" tabindex="' . $i . '" aria-controls="tabs-' . $i . '" >';
                echo '<a href="#tabs-' . $i . '" class="ui-tabs-anchor">' . $tab['label'] . '</a>';
                echo '</li>';
                $i++;
            }
            echo '</ul>';

            $i = 1;
            foreach ($fields['tabs'] as $tab) {
                echo '<div id="tabs-' . $i . '" class="ui-tabs-panel ui-widget-content ui-corner-bottom">';
                echo '<table class="form-table">';
                //var_dump('<pre>',$tab, '</pre>');
                foreach ($tab['fields'] as $field) {
                    $action = 'create_field_' . $field['type'];

                    echo $this->$action($field);
                }
                echo '</table>';
                echo '</div>';
                $i++;
            }
            echo '</div>';
        } else {
            echo '<table class="form-table">';
            foreach ($fields['tabs'][0]['fields'] as $field) {
                $action = 'create_field_' . $field['type'];

                echo $this->$action($field);
            }
            echo '</table>';
        }

        echo '<p class="submit" style="clear: both">
                <input id="submit" type="submit" value="' . __('Sauvegarder', 'sampletheme') . '" class="button button-primary"/>
            </p>
    </form>';
    }

    function create_field_text($field)
    {
        $label = $field['label'];
        $name = 'sample_theme_options[' . $field['name'] . ']';
        $value = $this->get_theme_option($field['name']);

        list($prefix, $suffix) = $this->check_container($field);

        return $prefix . '<input type="text" id="' . $name . '" name="' . $name . '" value="' . $value . '" />' . $suffix;
    }

    function create_field_textarea($field)
    {
        $label = $field['label'];
        $name = 'sample_theme_options[' . $field['name'] . ']';
        $value = $this->get_theme_option($field['name']);

        list($prefix, $suffix) = $this->check_container($field);

        return $prefix . '<textarea id="' . $name . '" name="' . $name . '" value="' . esc_textarea($value) . '" class="large-text" cols="50" rows="10">' . $value . '</textarea>' . $suffix;
    }

    function create_field_image($field)
    {

        $label = $field['label'];
        $name = 'sample_theme_options[' . $field['name'] . ']';
        $value = $this->get_theme_option($field['name']);

        $class = '';

        if ($value) {
            $class = ' has-file';
        }

        list($prefix, $suffix) = $this->check_container($field);


        $output = '<input id="' . $name . '" class="upload' . $class . '" type="text" name="' . $name . '" value="' . $value . '" placeholder="' . __('Aucun fichier sélectionné', 'options-framework') . '" />' . "\n";


        if (function_exists('wp_enqueue_media')) {
            if (( $value == '')) {
                $output .= '<input id="upload-' . $name . '" class="upload-button button" type="button" value="' . __('Choisir', 'options-framework') . '" />' . "\n";
            } else {
                $output .= '<input id="remove-' . $name . '" class="remove-file button" type="button" value="' . __('Supprimer', 'options-framework') . '" />' . "\n";
            }
        }


        $output .= '<div class="screenshot" id="' . $name . '-image" style="width:20%">' . "\n";

        if ($value != '') {
            $remove = '<a class="remove-image">' . __('Supprimer', 'options-framework') . '</a>';
            $image = preg_match('/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value);
            if ($image) {
                $output .= '<img src="' . $value . '" alt="" style="width:100%; height: auto" />' . $remove;
            } else {
                $parts = explode("/", $value);
                for ($i = 0; $i < sizeof($parts); ++$i) {
                    $title = $parts[$i];
                }

                // No output preview if it's not an image.
                $output .= '';

                // Standard generic output if it's not an image.
                $title = __('View File', 'options-framework');
                $output .= '<div class="no-image"><span class="file_link"><a href="' . $value . '" target="_blank" rel="external">' . $title . '</a></span></div>';
            }
        }
        $output .= '</div>' . "\n";


        return $prefix . $output . $suffix;
    }

    function check_container($field)
    {
        if (array_key_exists('prefix', $field)) {
            $prefix = $field['prefix'];
        } else {
            $prefix = '<tr>
                <th scope="row">' . $field['label'] . '</th>
                <td>';
        }
        if (array_key_exists('suffix', $field)) {
            $suffix = $field['suffix'];
        } else {
            $suffix = '</td>
            </tr>';
        }

        return array(
            $prefix,
            $suffix);
    }

}
