<?php 
include 'koneksi.php';

if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO tb_admin VALUES(NULL, '$email', '$password', '$username')";

    if(empty($email) || empty($username) || empty($password)) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = 'register.php';
            </script>
        ";
    }elseif(mysqli_query($koneksi, $sql)) {
        echo "  
            <script>
                alert('Registrasi Berhasil Silahkan login');
                window.location = 'login.php';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = 'register.php';
            </script>
        ";
    }
}
?>
