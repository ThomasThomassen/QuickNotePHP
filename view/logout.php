<?php

session_destroy();
unset($_SESSION['user_id']);

redirect_to("/login");


