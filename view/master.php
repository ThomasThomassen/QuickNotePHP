<?php

    include ("includes/session.php");
    
    include ("includes/router.php");
    if(!isset($_SESSION))
      {
        session_start();
      }

    include ("templates/head.php");
    
?>
    <body id="container">

<?php

    include ("templates/navigation.php");
  
    // Instantiate Router and parse URI to router
    $router = new Router($_SERVER['REQUEST_URI']);
    
    // Routes
    // Landing page
    $router->get('/', 'view/login');
 
    // Views
    $router->get('signup', 'view/signup');
    $router->get('login', 'view/login');
    $router->get('notes', 'view/notes');
    $router->get('logout', 'view/logout');

?>
</body>











    
