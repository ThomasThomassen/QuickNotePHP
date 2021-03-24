<?php

confirm_logged_in(); 

 # Include Database Connection script
 include ("includes/db_con.php");

# Create new category

    if(isset($_POST["add_category"])) {

        # Instantiate Database Connectiopn
        $create_category = $dbCon->prepare(

            "
            INSERT INTO 
                categories (name, user_id)
            VALUES (
                '{$_POST["category_name"]}',
                '{$_SESSION["user_id"]}'
                )
            ");    

            # Execute query
            $create_category->execute();

            redirect_to("/notes");
            
        unset($_POST["add_category"]);

    }

# Create new notes

    if(isset($_POST["add_note"])) {

        if(isset($_POST["title"]) && isset($_POST["description"])) {

            # Instantiate Database Connectiopn
            $create_note = $dbCon->prepare(
        
                "
                INSERT INTO 
                    notes (user_id, category_id, title, description)
                VALUES (
                    '{$_SESSION["user_id"]}',
                    '{$_POST["category_id"]}',
                    '{$_POST["title"]}',
                    '{$_POST["description"]}'
                    )
                ");    
        
                # Execute query
                $create_note->execute();

                redirect_to("/notes");
        
            unset($_POST["add_note"]);

        }
    }


# Read categories from logged in user

    # Prepare SQL query
    $read_category = $dbCon->prepare(
        "
        SELECT
            c.*,
            u.id AS user_id

        FROM
            categories AS c

        LEFT JOIN
            users AS u
            ON u.id = c.user_id 

        WHERE
            c.user_id = '{$_SESSION["user_id"]}'
        ");   

    # Execute query
    $read_category->execute();

    # Fetch All categories
    $categories = $read_category->fetchAll();


# Read notes from logged in user

    # Prepare SQL query
    $read_notes = $dbCon->prepare(

        "
        SELECT
            n.*,
            c.name AS category_name

        FROM
            notes AS n

        LEFT JOIN
            categories AS c
            ON c.id = n.category_id 

        WHERE
            n.user_id = '{$_SESSION["user_id"]}'
        ");    

    # Execute query
    $read_notes->execute();

    # Fetch notes
    $notes = $read_notes->fetchAll();


# Update existing note
    if(isset($_POST["update_note"])) {

        if(isset($_POST["title"]) && isset($_POST["description"])) {
        
            # Instantiate Database Connectiopn
            $update_note = $dbCon->prepare(
        
                "
                UPDATE
                    notes
                SET
                    title = '{$_POST["title"]}',
                    description = '{$_POST["description"]}'
                WHERE
                    id = '{$_POST["note_id"]}'
                    
                ");    
        
                # Execute query
                $update_note->execute();

                redirect_to("/notes");
        
            unset($_POST["update_note"]);

        }
    }


# Delete note

    if(isset($_POST["delete_note"])) {

        # Instantiate Database Connectiopn
        $delete_note = $dbCon->prepare(

            "
            DELETE FROM
                notes
            WHERE
                id = '{$_POST["note_id"]}'
                
            ");    

            # Execute query
            $delete_note->execute();

            redirect_to("/notes");

        unset($_POST["delete_note"]);

    }


# Delete category

    if(isset($_POST["delete_category"])) {

        # Instantiate Database Connectiopn
        $delete_category = $dbCon->prepare(

            "
            DELETE FROM
                categories
            WHERE
                id = '{$_POST["category_id"]}'
                
            ");    

            # Execute query
            $delete_category->execute();

            redirect_to("/notes");

        unset($_POST["delete_category"]);

    }
        
?>
<section class="all_cat">
<!-- Add categories -->
    <div class="add_cat">
<h1>Add more categories</h1>

<form class="" action="" method="POST">

    <input type="text" name="category_name">

    <input type="hidden" name="add_category">
    <input type="submit" value="Add your category">
</form>
</div>

<!-- Render categories -->
    <section class="cat">
        <h1>Your categories</h1>
        <ul id="categories">
            <?php
                foreach($categories as $category) {
                    echo '
                        <li onclick="filterNotes(value)" value="' . $category["id"] . '" class="category">
                        <form action="" method="POST" class="delete">
                        <input type="hidden" name="delete_category">
                        <input type="hidden" name="category_id" value="' . $category["id"] . '">   
                        <input type="submit" class="btnDelete" value="">
                        </form>
                        '. $category["name"] .'

                        </li>
                    ';
                }   
            ?>
                        <li onclick="filterNotes(value)" value="0" class="category">All notes</li>
            </ul>
    </section>
                <script>
                function filterNotes(value) {
                    var note = document.querySelectorAll('.note');
                    
                    for (i = 0; i < note.length; i++) {
                        var values = note[i].getAttribute('value');

                        if (values != value && value != '0'){
                            note[i].style.display = "none";
                        } else {
                            note[i].style.display = "flex";
                        }
                    }
             }
                </script>

</section>
<section class="all_notes">
    <!-- Add notes -->
    <section class="add_notes">
    <h1>Add more notes</h1>
<div class="add_note">
<form action="" method="POST">

    <label for="title">Title</label>
    <input type="text" name="title" placeholder="note title...">

    <br>

    <label for="description">Description</label>
    <textarea type="text" name="description" placeholder="note description..."></textarea>

    <br>

    <?php  
    
        # if $categories exist, show the option to select a category
        if($categories) {
            echo   '<label for="category">Select Category</label>
                    <select name="category_id">
            ';
        
            # foreach category make a select option

            foreach ($categories as $category) {

                echo '<option value="'. $category["id"] .'">
                    '. $category["name"] .'
                    </option>';

            }

            echo '</select>';
        } 

    ?>

    

    <input type="hidden" name="add_note">
    <input type="submit" value="Add your note">
</form>
</div>
    </section>

    <section class="notes">
        <h1>Your notes</h1>
    <div id="notes">
<?php
#Render notes
    foreach($notes as $note) {

    echo '
        <div class="note" value="'. $note["category_id"] .'">

            
            <form action="" method="POST" class="delete">
            <input type="hidden" name="delete_note">
            <input type="hidden" name="note_id" value="' . $note["id"] . '">   
             <input type="submit" class="btnDelete" value="">
             </form>

            <form action="" method="POST">

                <input type="text" name="title" value="' . $note["title"] . '" placeholder="note title...">
                <textarea type="text" name="description" placeholder="note description..." value="' . $note["description"] . '">'. $note["description"] .'</textarea>

                <input type="hidden" name="update_note">
                <input type="hidden" name="note_id" value="'. $note["id"] .'">
                <input type="hidden" name="category_id" value="'. $note["category_id"] .'">
                <input type="submit" value="Update note">
            </form>

        </div>
    ';

    }

?>
</div>
</section>
</section>