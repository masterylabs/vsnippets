<?php

// requires vue module
add_action( 'admin_menu', function() use($app, $options) {
  new Masteryl_WpAdminPage($app, $options);
});


// admin page