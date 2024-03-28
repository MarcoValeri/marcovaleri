<?php

// Load JS and CSS files
function mv_enqueue_script() {
    wp_enqueue_style("style-css", get_template_directory_uri() . "/style.css", false, "1.1", "all");
    wp_enqueue_style("main-css", get_template_directory_uri() . "/assets/css/main.css", false, "1.1", "all");
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