<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php


?>
<body>
    <table border="1">
        <tr>
            <td>id</td>
            <td>name</td>
            <td>age</td>
            <td>修改</td>
            <td>刪除</td>
        </tr>
        <? for ($i = 0; $i < $total_records; $i++) {
            $row = mysqli_fetch_assoc($result); //將陣列以欄位名索引  
        ?>

            <tr>

                <td><? echo $row[id]; ?></td>

                <td><? echo $row[name]; ?></td>

                <td><? echo $row[age]; ?></td>

                <td>修改</td>

                <td><a href="del.php?id=<? echo $row[id]; ?>">刪除</a></td>

            </tr>

        <?  }  ?>
</body>

</html>

