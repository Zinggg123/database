<?php
require_once '../database.php'; // 引入Database类

// 如果表单被提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ctel = $_POST['ctel']; // 假设手机号码字段为ctel
    $passwordAttempt = $_POST['cpw']; // 用户输入的密码
    $userType = $_POST['userType']; // 新增：区分用户类型（例如，"student"或"teacher"）

    try {
        // 使用Database类获取数据库连接实例
        $db = Database::getInstance();


        // 根据用户类型选择查询的表
        $tableName = ($userType == 'customer') ? 'customer' : 'worker';
        
        // 查询用户是否存在
        $sql = "SELECT * FROM $tableName WHERE ctel = :ctel";
        $stmt = $db->prepareAndExecute($sql, [':ctel' => $ctel]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($passwordAttempt, $user['cpw'])) {
            // 密码验证成功，设置session
            session_start();
            $_SESSION['user_type'] = $userType; 
            
            // 根据用户类型跳转到不同页面
            switch ($userType) {
                case 'customer':
                    $_SESSION['user_id'] = $user['cid'];
                    header("Location: ../customer/cus.php");
                    break;
                case 'worker':
                    $_SESSION['user_id'] = $user['wid'];
                    if($user['wpos']=='店长'){
                        header("Location: ../manager/man.php");
                        break;
                    }
                    else{
                        header("Location: ../worker/wor.php");
                        break;
                    }
                default:
                    echo "未知的用户类型！";
                    break;
            }
            exit();
        } else {
            echo "<script>alert('手机号码或密码错误！'); window.location.href='login.html';</script>";
        }
    } catch (PDOException $e) {
        die("数据库操作失败: " . $e->getMessage());
    }
}
?>