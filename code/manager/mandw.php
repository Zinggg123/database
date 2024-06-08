<?php
    require_once '../database.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'deleteWorker') {
        try {
            $conn= Database::getInstance();

            // 从POST请求中获取要删除的员工ID
            $widToDelete = $_POST['kaiid'];

            $sql = "DELETE FROM worker WHERE wid = :wid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':wid', $widToDelete, PDO::PARAM_INT);

            // 执行删除操作
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
