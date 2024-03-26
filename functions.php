<?php

// Load JS and CSS files
function mv_enqueue_script() {
    wp_enqueue_style("style-css", get_stylesheet_directory_uri() . "./style.css");
    wp_enqueue_style("main-css", get_stylesheet_directory_uri() . "./assets/css/main.css");
}
add_action("wp_enqueue_scripts", "mv_enqueue_script");