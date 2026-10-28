<?php
session_start();

if (isset($_POST['simpan'])) {
    $_SESSION['category_data'] = [
        'categories'  => $_POST['categories'],
        'price'       => $_POST['price'],
        'description' => $_POST['Description'],
        'photo'       => $_FILES['photo']['name']
    ];

    $tmp = $_FILES['photo']['tmp_name'];
    $image = $_FILES['photo']['name'];
    move_uploaded_file($tmp, "../assets/thumbnail/" . $image);

    header("Location: categories.php");
    exit();
}
?>