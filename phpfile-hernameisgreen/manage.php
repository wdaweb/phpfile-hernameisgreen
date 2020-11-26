<?php
 include_once "base.php";
/**
 * 1.建立資料庫及資料表來儲存檔案資訊
 * 2.建立上傳表單頁面
 * 3.取得檔案資訊並寫入資料表
 * 4.製作檔案管理功能頁面
 */


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案管理功能</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table{
            border: 3px double blue;
            padding: 20px;
            border-collapse: collapse;
            text-align:center;
        }
        td{
            border: 1px solid #EEE;
            padding: 5px;
        }
        a.primary, a.danger{
            border-radius: 10px; 
           padding: 3px 8px; 
           color: white; 
           box-shadow:1px 1px 4px;
           font-size: 14px;
           margin: 0 2px;
        }
        
        a.primary{
     background:aqua;
        }
        a.danger{
          
           background: pink; 
     
        }
    </style>
</head>
<body>
<h1 class="header">檔案管理練習</h1>

<!----建立上傳檔案表單及相關的檔案資訊存入資料表機制----->

<a href="upload.php" style="display: block; width:80px; text-align: center;">檔案上傳</a>



<!----透過資料表來顯示檔案的資訊，並可對檔案執行更新或刪除的工作----->
<?php







 if(!empty($_FILES['img']['tmp_name'])){

$subname="";
$subname=explode('.',$_FILES['img']['name']);

$subname=end($subname);


$filename=date("Ymdhis").".".$subname;


     move_uploaded_file($_FILES['img']['tmp_name'],"./img/".$filename);


     $row=[
"name"=>$_FILES['img']['name'],
"path"=>"./img/".$filename,
"type"=>$_POST['type'],
"note"=>$_POST['note']
     ];

print_r($row);
save("upload", $row);

    }


?>



 <!----建立你的表單及設定編碼----->
<form action="?" method="post" enctype="multipart/form-data">
    <div>上傳的檔案:<input type="file" name="img"></div>
    <div>檔案說明<input type="text" name="note"></div>
    <div>檔案類型<select name="type">
        <option value="圖檔">圖檔</option>
        <option value="文件">文件</option>
        <option value="其它">其它</option>
    </select></div>
    <input type="submit" value="上傳">
</form>




<!----建立一個連結來查看上傳後的圖檔---->  
<?php
$rows=all('upload');
echo "<table>";
echo "<td>preview</td>";
echo "<td>檔案名稱</td>";
echo "<td>檔案類型</td>";
echo "<td>檔案說明</td>";
echo "<td>檔案下載</td>";
echo "<td>操作</td>";

foreach($rows as $row){
echo "<tr>";
if($row['type']=='圖檔'){
    echo "<td><img src='{$row['path']}' style='width:100px'></td>";
}else{
    echo "<td></td>";
}
echo "<td>{$row['name']}</td>";
/* echo "<td>{$row['name']}</td>"; */
echo "<td>{$row['type']}</td>";
echo "<td>{$row['note']}</td>";
echo "<td><a href='{$row['path']}' download>下載</a></td>";
echo "<td><a class='danger' href='del.php?id={$row['id']}' >刪除</a>
<a class='primary' href='edit.php?id={$row['id']}' >編輯</a></td>";


echo"</tr>";

}

echo"</table>";



?>




</body>
</html>