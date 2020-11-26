<?php

include_once "base.php";


/* 不能用ISSSET因為是系統變數 */
if (!empty($_GET['id'])) {
    $row = find('upload', $_GET['id']);
    /* 表單隱藏項目 */
}
if (!empty($_POST)) {
    $row = find('upload', $_POST['id']);

    if (!empty($_FILES['img']['tmp_name'])) {
        $row['name'] = $_FILES['img']['name'];
        $subname = "";
        $subname = explode('.', $_FILES['img']['name']);
        $subname = end($subname);
        $filename = date("Ymdhis") . "." . $subname;
        unlink($row['path']);

        $row['path'] = "./img/".$filename;
        move_uploaded_file($_FILES['img']['tmp_name'], $row['path']);
    }



    $row['type'] = $_POST['type'];
    $row['note'] = $_POST['note'];
    save('upload', $row);
    to('manage.php');
}
?>
<style>
    form {
        border: 3px solid blue;
        margin: auto;
        padding: 20px;
        width: 300px;
    }

    form div {
        margin: 5px 0;
    }

    img {
        border: 2px solid #ccc;
        box-shadow: 0 0 5px #ccc;
    }
</style>

<body>
    <h1 class="header">檔案上傳練習</h1>
    <!----建立你的表單及設定編碼----->
    <form action="?" method="post" enctype="multipart/form-data">
        <div><img src="<?= $row['path']; ?>" style="width:200px"></div>
        <div>上傳的檔案:<input type="file" name="img"></div>
        <div>檔案說明<input type="text" name="note" value="<?= $row['note']; ?>"></div>
        <div>檔案類型<select name="type">
                <option value="圖檔" <?= ($row['type'] == '圖檔') ? 'selected' : ''; ?>>圖檔</option>
                <option value="文件" <?= ($row['type'] == '文件') ? 'selected' : ''; ?>>文件</option>
                <option value="其它" <?= ($row['type'] == '其他') ? 'selected' : ''; ?>>其它</option>
            </select></div>
        <input type="hidden" name="id" value="<?= $row['id']; ?>">
        <input type="submit" value="更新">
    </form>