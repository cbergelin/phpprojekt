<?php
include("database_connections.php");

// checkar om en roll är tilldelad till admin.
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
    echo "<a href=\"show_posts.php?action=delete&id=" . $row['id'] ."\"> Delete! </a>";
    }
    // tar bort posten som är vald.
    if(isset($_GET['action']) && $_GET['action'] == "delete") {

        $query = "DELETE FROM messages WHERE id=" . $_GET['id'];
        $return = $dbh->exec($query);
        
    
        header('location:index.php');
    
    }