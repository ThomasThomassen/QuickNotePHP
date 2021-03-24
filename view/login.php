<?php

if(isset($_POST["email"]) && isset($_POST["password"])) {

    # Get Database Connection
    include ("includes/db_con.php");

    # Instantiate Database Connectiopn
    $query = $dbCon->prepare(

        "
        SELECT
            *
        FROM
            users
        WHERE
            email = '{$_POST["email"]}'

        ");    
        
        # Execute query
        $query->execute();

        # Fetch user
        $user = $query->fetch();

        # If match is found, login the user
        if($user) {

            if(password_verify($_POST["password"], $user['password'])) {

                # Set user session
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_email"] = $user["email"];

                redirect_to('/notes');

            } else {
                echo "Password didn't match";
            }

        } else {
            echo "user not found";
        }

    unset($_POST["email"]);
    unset($_POST["password"]);
}

?>


<section class="centered">
    <h1 class="form_title">Login to QuickNote</h1>

    <form action="/login" method="post" class="submit_form">
    <label for="email">Email</label>
        <input type="text" name="email" placeholder="email...">
    <label for="password">Password</label>
        <input type="password" name="password" placeholder="password...">
        <button type="submit" name="submit">Login</button>

    </form>
    <div>
        <p>To register, click <a href="/signup">here</a></p>
    </div>

</section>