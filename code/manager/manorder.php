<?php
    require_once '../database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        try {
            $conn= Database::getInstance();

            $oidd = $_POST['oid'];
            $stat = $_POST['status'];

            $sql = "UPDATE `order` SET `ostatus`=:stat WHERE `oid`=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $oidd, PDO::PARAM_INT);
            $stmt->bindParam(':stat',$stat,PDO::PARAM_STR);

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