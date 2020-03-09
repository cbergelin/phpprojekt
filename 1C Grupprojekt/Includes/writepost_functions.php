<?php 
include("database_connections.php");

session_start();


 
 if (isset($_POST['submit'])) {
    $file = $_FILES['file']['name'];

    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $image = $_POST['file'];
    $user_id = $_SESSION['id'];

    $file_name = $_FILES['file']['name'];
    $file_tmp_name = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_error = $_FILES['file']['error'];
    $file_type = $_FILES['file']['type'];

    $file_ext = explode('.', $file_name);
    $file_actual_ext = strtolower(end($file_ext)); 

    $allowed = array('jpg', 'jpeg', 'png');

    


    if (in_array($file_actual_ext, $allowed)) {
        if ($file_error === 0) {
            if ($file_size < 1000000) {
                $file_new_name = uniqid('', true) . "." . $file_actual_ext;
                $file_destination = '../uploads/' . $file_new_name;
                move_uploaded_file($file_tmp_name, $file_destination);
                header("location: ../index.php");
                $query_post = "INSERT INTO posts(userID, title, category, description, image) VALUES (:user_id, :title, :category, :description, :file_new_name);";
                $sth_writepost = $dbh->prepare($query_post);
                $sth_writepost->bindParam(':user_id', $user_id);
                $sth_writepost->bindParam(':title', $title);
                $sth_writepost->bindParam(':category', $category);
                $sth_writepost->bindParam(':description', $description);
                $sth_writepost->bindParam(':file_new_name', $file_new_name);
                $return = $sth_writepost->execute();
            } else {
                echo "Your file is to big!";
            }
        } else {
            echo "Det blev ett error vid uppladdningen av filen";
        }
    } else {
    echo "Du kan inte ladda upp filer av denna typ";
    }
} 

?>