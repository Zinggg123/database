<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cucu奶茶-员工后台</title>
    <link rel="stylesheet" href="../manager/man.css">
    <script src="wor.js"></script>
    <script src="../JS/jquery.min.js"></script>
</head>

<body>
<?php
    session_start();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'worker') {
        header("Location: login.html");
        exit();
    }
    
    require_once '../database.php'; // 引入Database类
    
    // 获取当前登录的工人ID
    $workerId = $_SESSION['user_id'];
    
    try {
        $db = Database::getInstance();

        $sql = "SELECT wpos, wname,ctel,waddr,wsid,wage FROM worker WHERE wid = :wid";
        $stmt = $db->prepareAndExecute($sql, [':wid' => $workerId]);
        $workerInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("数据库操作失败: " . $e->getMessage());
    }
?>

    <div class="header">
        <div class="logo"></div>
        <div class="lname">Cucu奶茶，用心做好茶!</div>
    </div>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="#page1" class="nav-link">待完成订单</a></li>
                <li><a href="#page2" class="nav-link">历史订单</a></li>
                <li><a href="#page4" class="nav-link">个人信息</a></li>
            </ul>
        </div>
        <div class="content">
            <div id="page1" class="page">
                <?php 
                    echo "<h2>欢迎，" . htmlspecialchars($workerInfo['wname']) . "！</h2>";
                 ?>
                <h2>请努力做出美味的奶茶吧！</h2>
                <h3> - 未完成订单</h3>
                <table cellspacing="0" cellpadding="5">
                    <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>商品</th>
                            <th>收货人</th>
                            <th>手机号码</th>
                            <th>收货地址</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            try {
                                $sql = "SELECT `oid`, ogood,oname, otel,oaddr, obeizhu
                                    FROM `order`
                                    WHERE (ostatus='making' OR ostatus='error') AND osid=:shopid" ;
                                $stmtOrder = $db->prepare($sql);
                                $stmtOrder->bindParam(':shopid', $workerInfo['wsid'], PDO::PARAM_INT);
                                $stmtOrder->execute();

                                while ($order = $stmtOrder->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($order['oid']) . "</td>";
                                    echo "<td>" . htmlspecialchars($order['ogood']) . "</td>";
                                    echo "<td>" . htmlspecialchars($order['oname']) . "</td>";
                                    echo "<td>" . htmlspecialchars($order['otel']) . "</td>";
                                    echo "<td>" . htmlspecialchars($order['oaddr']) . "</td>";
                                    echo "<td>" . htmlspecialchars($order['obeizhu']) . "</td>";
                                    echo "<td><button type='button' class='btn-complete' onclick='completeorder(event," . htmlspecialchars(json_encode($workerId), ENT_QUOTES) . ")'>完成</button></td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "查询订单失败：" . $e->getMessage();
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="page2" class="page" style="display: none;">
                <h2>你做得很棒！</h2>
                <h3> - 已完成订单</h3>
                <table cellspacing="0" cellpadding="5">
                    <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>商品</th>
                            <th>收货人</th>
                            <th>手机号码</th>
                            <th>送货地址</th>
                            <th>备注</th>
                            <th>订单状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                try {
                                    $sql = "SELECT oid, ogood,oname, otel,oaddr, obeizhu,ostatus
                                        FROM `order`
                                        WHERE owid=:wwid" ;
                                    $stmtOrder = $db->prepare($sql);
                                    $stmtOrder->bindParam(':wwid', $workerId, PDO::PARAM_INT);

                                    $stmtOrder->execute();

                                    while ($order = $stmtOrder->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($order['oid']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['ogood']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['oname']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['otel']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['oaddr']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['obeizhu']) . "</td>";
                                        echo "<td>" . htmlspecialchars($order['ostatus']) . "</td>";
                                        echo "</tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "查询订单失败：" . $e->getMessage();
                                }
                            ?>
                    </tbody>
                </table>
            </div>
            <div id="page4" class="page" style="display: none;">
                <table cellspacing="0" cellpadding="5">
                    <tbody>
                    <tr>
                        <th>姓名</th>
                        <td><?php echo htmlspecialchars($workerInfo['wname'] ); ?></td>
                    </tr>
                    <tr>
                        <th>员工编号</th>
                        <td><?php echo htmlspecialchars($workerId); ?></td>
                    </tr>
                    <tr>
                        <th>手机号码</th>
                        <td><?php echo htmlspecialchars($workerInfo['ctel']); ?></td>
                    </tr>
                    <tr>
                        <th>家庭住址</th>
                        <td><?php echo htmlspecialchars($workerInfo['waddr']); ?></td>
                    </tr>
                    <tr>
                        <th>职位</th>
                        <td><?php echo htmlspecialchars($workerInfo['wpos']); ?></td>
                    </tr>
                    <tr>
                        <th>就职门店</th>
                        <td><?php echo htmlspecialchars($workerInfo['wsid']); ?></td>
                    </tr>
                    <tr>
                        <th>薪资</th>
                        <td><?php echo htmlspecialchars($workerInfo['wage']); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>