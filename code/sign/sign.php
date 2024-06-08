<?php
require_once '../database.php'; // 确保引入了更新后的Database类文件

try {
    // 使用Database类获取数据库连接实例
    $db = Database::getInstance();

    // 检查是否接收到POST数据
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 从表单获取数据
        $phone = $_POST['ctel'];
        $nickname = $_POST['cname'];
        $password = password_hash($_POST['cpw'], PASSWORD_DEFAULT); // 使用password_hash加密密码
        $userType = $_POST['userType'];

        try {

            if($userType=='customer'){
                // 使用新方法执行预处理语句及执行
                $stmt = $db->prepareAndExecute("INSERT INTO customer (ctel, cname, cpw) VALUES (?, ?, ?)", [$phone, $nickname, $password]);
            }
            else if($userType=='worker'){
                $updateSql = "UPDATE worker SET cpw = :newPassword WHERE ctel = :ctel";
                $stmt = $db->prepare($updateSql);
                // 绑定参数到预处理语句
                $stmt->bindParam(':newPassword', $password, PDO::PARAM_STR);    
                $stmt->bindParam(':ctel', $phone, PDO::PARAM_STR);
                // 执行更新操作
                $stmt->execute();
            }
            else{
                echo "<script>alert('注册失败！'); window.location.href='sign.html';</script>";
            }

            // 注册成功，准备跳转
            echo "<script>alert('注册成功！'); window.location.href='../login/login.html';</script>";
            
        } catch(PDOException $e) {
            // 注册失败，显示错误信息
            if (strpos($e->getMessage(), 'Trigger') !== false) {
                echo "<script>alert('注册失败: 输入信息不符合规则，请检查电话号码是否合法。');window.location.href='sign.html';</script>";
            } else {
                echo "<script>alert('注册失败: " . htmlspecialchars($e->getMessage()) . "');window.location.href='sign.html';</script>";
            }
        }
    }
} catch (Exception $e) {
    die("发生错误: " . $e->getMessage());
}
?>