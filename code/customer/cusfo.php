<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'complete') {
        $conn = new PDO("mysql:host=localhost;dbname=milktea;charset=utf8", 'root', '2212165');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->beginTransaction();
        try {
            
            $oidud = $_POST['ooid'];
            $cid = $_POST['owiwd'];
    
            $sql = "UPDATE `order` SET ostatus = 'finished' WHERE `oid`=:ooid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ooid', $oidud, PDO::PARAM_INT);
            $stmt->execute();
    
            $sql2="UPDATE `customer` SET `cpoints` = `cpoints` + 1 WHERE cid=:cid";
            $stmt2=$conn->prepare($sql2);
            $stmt2->bindParam(':cid',$cid,PDO::PARAM_INT);
            $stmt2->execute();

            $conn->commit();
            echo 'success';
        } catch(PDOException $e) {
            die("数据库连接失败: " . $e->getMessage());
            $conn->rollBack();
        } finally {
            // 关闭数据库连接
            $conn = null;
        }
    }
?>