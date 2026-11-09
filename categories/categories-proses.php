<?php 
include '../koneksi.php';

function upload() {
    $namaFile = $_FILES['photo']['name'];
    $error = $_FILES['photo']['error'];
    $tmpName = $_FILES['photo']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4) {
        echo "
            <script>
                alert('Gambar Harus Diisi');
                window.location = 'categories-entry.php';
            </script>
        ";

        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstentiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if(!in_array($ekstensiGambar, $ekstentiGambarValid)) {
        echo "
            <script>
                alert('File Harus Berupa Gambar');
                window.location = 'categories-entry.php';
            </script>
        ";

        return null;
    }

    // lolos pengecekan, upload gambar
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    $oke =  move_uploaded_file($tmpName, '../img_categories/' . $namaFileBaru);
    return $namaFileBaru;

}

if(isset($_POST['simpan'])) {
    $categories = $_POST['categories'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $photo = upload();

    if(!$photo) {
        return false;
    }
    var_dump($photo, $categories, $price, $description);

    $sql = "INSERT INTO tb_categories VALUES(NULL, '$photo', '$categories', '$price','$description')";

    if(empty($categories) || empty($price)|| empty($description)) {
        echo "
            <script>
                alert('Pastikan Anda Mengisi Semua Data');
                window.location = 'categories-entry.php';
            </script>
        ";
    }elseif(mysqli_query($koneksi, $sql)) {
        echo "
            <script>
                alert('Data Categories Berhasil Ditambahkan');
                window.location = 'categories.php'
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = 'categories-entry.php'
            </script>
        ";
    }
}elseif(isset($_POST['edit'])) {
    $id         = $_POST['id'];
    $categories = $_POST['categories'];
    $price      = $_POST['price'];
    $description = $_POST['description'];
    $photoLama = $_POST['photoLama'];

    // cek apakah user pilih gambar atau tidak
    if($_FILES['photo']['error']) {
        $photo = $photoLama;
    }else {
        // foto lama akan dihapus dan diganti foto baru
        unlink('../img_categories/' . $photoLama);
        $photo = upload();
    }

    $sql = "UPDATE tb_categories SET 
            photo = '$photo',
            categories = '$categories',
            price = '$price',
            description = '$description'
            WHERE id = $id 
            ";

    if(mysqli_query($koneksi, $sql)) {
        echo "
            <script>
                alert('Data Categories Berhasil Diubah');
                window.location = 'categories.php';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Terjadi Kesalahan');
                window.location = 'categories-edit.php';
            </script>
        ";
    }
}elseif(isset($_POST['hapus'])) {
    $id = $_POST['id'];

    // hapus gambar
    $sql = "SELECT * FROM tb_categories WHERE id = $id";
    $result = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($result);
    $photo = $row['photo'];
    unlink('../img_categories/' . $photo);
    

    $sql = "DELETE FROM tb_categories WHERE id = $id";
    if(mysqli_query($koneksi, $sql)) {
        echo "
            <script>
                alert('Data Categories Berhasil Dihapus');
                window.location = 'categories.php';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Data Categories Gagal Dihapus');
                window.location = 'categories.php';
            </script>
        ";
    }
}else {
    header('location: categories.php');
}
