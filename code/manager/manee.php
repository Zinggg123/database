<?php

$dg = new PDO("mysql:host=localhost;dbname=milktea;charset=utf8", 'root', '2212165');
$dg->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$shopid=$_POST['shopId'];
$good=$_POST['gid'];

if($dg->beginTransaction()){
} else{
    echo('fail begin');
}

try{
    $sql="INSERT INTO ssellg (`sid`, gid) VALUES (:id,:good)";
    $stmt=$dg->prepare($sql);
    
    // 使用bindValue方法
    $stmt->bindParam(':id', $shopid, PDO::PARAM_INT);
    $stmt->bindParam(':good', $good, PDO::PARAM_INT); 
    $stmt->execute();

	$sql2 = "UPDATE `order` SET `ostatus` = 'making' WHERE ogood=:good AND osid=:id";
    $stmt2 = $dg->prepare($sql2);
    $stmt2->bindParam(':good', $good, PDO::PARAM_INT);
    $stmt2->bindParam(':id', $shopid, PDO::PARAM_INT);
    $stmt2->execute();

    $dg->commit();
}catch(Exception $e){
    $dg->rollBack(); // 注意这里需要加上括号来调用rollBack方法
}

$dg = null;
?>