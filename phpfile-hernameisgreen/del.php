<?php

include_once "base.php";

$id=$_GET['id'];

//找出檔案路徑並刪除(本機硬碟中的檔案)
$row=find('upload', $id);
$path=$row['path'];
unlink($path);

//刪除資料表中的紀錄(在資料庫的資料)
del('upload', $id);

to('manage.php');