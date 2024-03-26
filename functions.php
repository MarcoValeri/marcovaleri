<?php

// Load css
function mv_enqueue_styles() {
    wp_enqueue_style("main-css", get_stylesheet_directory_uri() . "./style.css");
}
add_action("wp_enqueue_scripts", "mv_enqueue_styles");