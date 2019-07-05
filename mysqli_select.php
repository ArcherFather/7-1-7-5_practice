<?php
$mysqli = new mysqli('localhost','root','','cy');
$mysqli->set_charset('utf8');

$sql = 'SELECT * FROM cust';
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->store_result();
echo $stmt->num_rows . '<hr>';
$stmt->bind_result($id,$cname,$tel,$birthday);

// 顯示資料方法(1)
// $stmt->fetch();  // 抓第一筆
// echo "{$id} : {$cname} : {$tel} : {$birthday}<br>";
// $stmt->fetch();  // 在抓下一筆
// echo "{$id} : {$cname} : {$tel} : {$birthday}<br>";
// $stmt->fetch();
// echo "{$id} : {$cname} : {$tel} : {$birthday}<br>";

// 顯示資料方法(2)
// while($stmt->fetch()){
//     echo "{$id} : {$cname} : {$tel} : {$birthday}<br>";
// }

echo '<hr>';

// 顯示資料方法(3)，印出json格式 (API回傳常見)
$ret = new stdClass();    // 就是JAVA的Object
if($stmt->num_rows>0){
    $ret->result = $stmt->num_rows;
    $row = [];
    while($stmt->fetch()){
        $row['id'] = $id;
        $row['cname'] = $cname;
        $row['tel'] = $tel;
        $row['birthday'] = $birthday;

        $ret->data[] = $row;
    }
}else{
    $ret->result = "no data";
}

$stmt->free_result();
$stmt->close();

echo json_encode($ret);