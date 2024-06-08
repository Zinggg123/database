<?php
// 数据库连接配置
require_once "../database.php";
// 创建连接
$conn = Database::getInstance();
session_start();
$userId = $_SESSION['user_id'];

// 检查连接
if ($conn==null) {
    die("连接失败: " . $conn->connect_error);
}

try{
    // 准备SQL语句，这里假设order表有相应字段
    $sql = "INSERT INTO `order` (ogood, oname, oaddr, otel,obeizhu, osid, ocid) VALUES (?, ?, ?, ?,?,?,?)";

    // 预处理SQL语句
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }

    // 绑定参数到预处理语句
    $ogid = $_POST['goodid'];
    $oname = $_POST['receiver'];
    $oaddr = $_POST['address'];
    $otel = $_POST['phone'];
    $osid = $_POST['store'];
    $obeizhu = $_POST['beizhu'];

    // $stmt->bindParam("sdis", $ogid,$oname,$oaddr,$otel,$obeizhu,$osid,$userId);
    $stmt->bindParam(1, $ogid, PDO::PARAM_INT);
    $stmt->bindParam(2, $oname, PDO::PARAM_STR);
    $stmt->bindParam(3, $oaddr, PDO::PARAM_STR);
    $stmt->bindParam(4, $otel, PDO::PARAM_STR);
    $stmt->bindParam(5, $obeizhu, PDO::PARAM_STR);
    $stmt->bindParam(6, $osid, PDO::PARAM_INT);
    $stmt->bindParam(7, $userId, PDO::PARAM_INT);

    // 执行预处理语句
    if ($stmt->execute()) {
        echo "success"; // 如果执行成功，返回'success'
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }
}catch (PDOException $e) {
    if (strpos($e->getMessage(), '该门店暂不售卖该产品') !== false) {
        echo "Error: 订单无法创建，该门店暂不售卖该产品。";
    } else {
        echo "数据库错误: " . $e->getMessage();
    }
} catch (Exception $e) {
    echo "发生错误: " . $e->getMessage();
} finally {
    // 关闭连接（虽然在PDO中通常不需要手动关闭，但保持代码习惯）
    $conn = null;
}
?>