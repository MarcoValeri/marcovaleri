<?php

// Add theme support
add_theme_support('post-thumbnails', ['post', 'page']);
add_theme_support('editor-styles');
add_theme_support('wp-block-styles');
add_theme_support('align-wide');

// Load JS and CSS files
function mv_enqueue_script() {
    wp_enqueue_style("style-css", get_template_directory_uri() . "/style.css", false, "1.1", "all");
    wp_enqueue_style("main-css", get_template_directory_uri() . "/assets/css/main.css", false, "1.1", "all");
    wp_enqueue_script("jquery");
}
add_action("wp_enqueue_scripts", "mv_enqueue_script");

/*
* Create a function that get
* @param string as path of url
* and
* @return bool true if
* the current path of the url
* has this path
* false otherwise
*/
function isThisUrlPath($path) {
    if ($_SERVER['REQUEST_URI'] === $path) {
        return true;
    }
    return false;
}

/**
 * Create a function that gets
 * @param string $getCategoryName
 * as the name of the category
 * and
 * @return string as right
 * class for box-shadow
 */
function getCategoryBoxShadow($getCategoryName) {
    $setBoxShadow = "box-shadow-yellow";
    switch ($getCategoryName) {
        case "Esperienze":
            $setBoxShadow = "box-shadow-green";
            break;
        case "Opportunità":
            $setBoxShadow = "box-shadow-blue";
            break;
        case "Vivere all'estero":
            $setBoxShadow = "box-shadow-red";
            break;
        default:
            $setBoxShadow = "box-shadow-yellow";
    }
    return $setBoxShadow;
}