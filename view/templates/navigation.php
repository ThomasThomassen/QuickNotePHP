<nav>
    <div class="wrapper">
        <?php
        if(isset($_SESSION["user_id"])){
            echo '<a href="/notes"><h1>QuickNote</h1></a>';
        } else {
            echo '<a href="/"><h1>QuickNote</h1></a>';
        }
        ?>
        <ul>
        <?php
            if(isset($_SESSION["user_id"])) {
                echo '<li><a href="/notes">Notes</a></li>';
                echo '<li><a href="/logout">Log out</a></li>';
            } else {
                echo "<li><a href='/login'>Log in</a></li>";
                echo "<li><a href='/signup'>Sign up</a></li>";
             
            }
        ?>
        </ul>
    </div>
</nav>