<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit" value="upload" name="upload">
</form>
<?php
// 建立與MySQL資料庫的連線
include("configure.php");
$link = new PDO('mysql:host=' . $hostname . ';dbname=' . $database . ';charset=utf8', $username, $password);

if (isset($_POST['upload'])) {
    $input_image = $_FILES['image']['name'];
    $image_info = @getimagesize($input_image);
    if ($image_info != false) {
        echo "The selected file is not image.";
    } else {

        $image_array = explode('.', $input_image);
        // $rand = rand(10000, 99999);
        $image_new_name = "p" . strtotime(date("Ymd His")) . "." . $image_array[1];
        // $image_new_name=$image_array[0].'.'.$image_array[1];
        // $image_new_name = $image_array[0] . $rand . '.' . $image_array[1];
        $image_upload_path = "uploads/" . $image_new_name;
        // echo "p".strtotime(date("Ymd His"));


        $is_uploaded = move_uploaded_file($_FILES["image"]["tmp_name"], $image_upload_path);
        if ($is_uploaded) {


            $select = "select * from `bookstore_number`";
            $pic_db = "INSERT INTO `bookstore`.`bookstore_manber` (`IMG`) VALUES (?)";
            $data = [$image_upload_path];
            $sth = $link->prepare($pic_db);
            $sth->execute($data);
            exec($pic_db);
            


            // $file = '../$image_array.png';
            // $type = 'image/jpeg';
            // header('Content-Type:' . $type);
            // header('Content-Length: ' . filesize($file));
            // readfile($file);
            echo 'Image Successfully Uploaded';
        } else {
            echo 'Something Went Wrong!';
        }
    }
}
?>