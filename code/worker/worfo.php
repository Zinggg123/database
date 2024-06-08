<?php
require_once '../database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'complete') {
        try {
            $conn= Database::getInstance();
        
            $oidud = $_POST['ooid'];
            $owwid = $_POST['owiwd'];
    
            $sql = "UPDATE `order` SET ostatus = 'distrbuting',owid=:wid11 WHERE `oid`=:ooid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':ooid', $oidud, PDO::PARAM_INT);
            $stmt->bindParam(':wid11', $owwid, PDO::PARAM_INT);
    
        
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "failed";
            }
        
        } catch(PDOException $e) {
            die("数据库连接失败: " . $e->getMessage());
        } finally {
            // 关闭数据库连接
            $conn = null;
        }
    }



?>