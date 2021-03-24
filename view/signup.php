<?php

if(isset($_POST["submit"])) {

    # Get Database Connection
    include ("includes/db_con.php");

    $email = $_POST["email"];
    $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

   

    # Instantiate Database Connection
    $query = $dbCon->prepare(

        "INSERT INTO
            users (`email`, `password`)
        VALUES (
            '{$email}',
            '{$hashed_password}'
            );");    

        # Execute query
        $query->execute();

        unset($_POST["email"]);
        unset($_POST["password"]);

        # Redirect user to login page
        redirect_to('/login');
    }
?>

<section class="centered">
    <h1 class="form_title">Signup to QuickNote</h1>

    <form action="/signup" method="post" class="submit_form">
    <label for="email">Email</label>
        <input type="text" name="email" placeholder="email...">
    <label for="password">Password</label>
        <input type="password" name="password" placeholder="password...">

        <button type="submit" name="submit">Sign up</button>
    </form>

    <div>
        <p>To login, click <a href="/login">here</a></p>
    </div>

</section>