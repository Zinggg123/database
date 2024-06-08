<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cucu奶茶-点单</title>
    <link rel="stylesheet" href="../manager/man.css">
    <link rel="stylesheet" href="cus.css">
    <script src="cus.js"></script>
    <script src="../JS/jquery.min.js"></script>

</head>

<body>
    <?php
        session_start();
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'customer') {
            header("Location: login.html");
            exit();
        }
        
        require_once '../database.php'; // 引入Database类
        
        // 获取当前登录的顾客ID
        $userId = $_SESSION['user_id'];
        
        try {
            $db = Database::getInstance();
            $sql = "SELECT cname,ctel,cpoints FROM customer WHERE cid=:cid ";
            $stmt = $db->prepare($sql); 
            $stmt->bindParam(':cid', $userId, PDO::PARAM_INT); 
            $stmt->execute();
            $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql2 = "SELECT gid, gname, gintro, gprice FROM good";
            $stmt2 = $db->query($sql2);

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
                <li><a href="#page1" class="nav-link">点单</a></li>
                <li><a href="#page3" class="nav-link">历史订单</a></li>
                <li><a href="#page4" class="nav-link">个人信息</a></li>
            </ul>
        </div>
        <div class="content">
            <div id="page1" class="page">
                <h2>又到喝奶茶的时间了！</h2>
                <h3>- 点单页面</h3>
                
                    <?php
                            echo '<div class="wrapped">';
                            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                echo '<div class="good">';
                                echo '<img src="../img/mt1.jpg" alt="">'; 
                                echo '<h4>' . htmlspecialchars($row['gname']) . '</h4>';
                                if (!empty($row['gintro'])) { // 如果obeizhu不为空，则正常显示
                                    echo '<p>' . htmlspecialchars($row['gintro']) . '</p>'; 
                                } else { // 如果obeizhu为空，则保持一定的占位
                                    echo '<p>&nbsp;</p>'; 
                                }
                                echo '<h5>￥' . htmlspecialchars($row['gprice']) . '</h5>';
                                echo '<button class="circle-button">&#43;</button>';
                                echo '<p style="display:none" class="gid">'. htmlspecialchars($row['gid']) .'</p>';
                                echo '</div>'; // 结束单个商品的div
                            }
                            echo '</div>'; // 结束商品列表的wrapped div
                    ?>
            </div>
            <div id="page3" class="page" style="display: none;">
                <h2>往昔的快乐！</h2>
                <table cellspacing="0" cellpadding="5">
                    <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>商品</th>
                            <th>收货人</th>
                            <th>手机号码</th>
                            <th>送货地址</th>
                            <th>备注</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                try {
                                    $sql = "SELECT oid, ogood,oname, otel,oaddr, obeizhu,ostatus
                                        FROM `order`
                                        WHERE ocid=:userid" ;
                                    $stmtOrder = $db->prepare($sql);
                                    $stmtOrder->bindParam(':userid', $userId, PDO::PARAM_INT);
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
                                        // 操作列，您可以根据需求添加具体操作链接或按钮
                                        echo "<td><button type='button' class='btn-complete' onclick='completeorder(event," . htmlspecialchars(json_encode($userId), ENT_QUOTES) . ")'>已收货</button></td>";
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
                <h2>个人信息</h2>
                <table cellspacing="0" cellpadding="5">
                    <tbody>
                        <tr>
                            <th>顾客ID</th>
                            <td><?php echo htmlspecialchars($userId ); ?></td>
                        </tr>
                        <tr>
                            <th>昵称</th>
                            <td><?php echo htmlspecialchars($userInfo['cname'] ); ?></td>
                        </tr>
                        <tr>
                            <th>手机号码</th>
                            <td><?php echo htmlspecialchars($userInfo['ctel'] ); ?></td>
                        </tr>
                        <tr>
                            <th>积分</th>
                            <td><?php echo htmlspecialchars($userInfo['cpoints'] ); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span> <!-- 关闭按钮 -->
            <h3 id="modal-product-name">商品名称</h3>
            <h3 id="modal-product-price">商品金额</h3>
            <form id="orderForm" style="margin-top:50px" >
                <input type="hidden" id="goodid" name="goodid">
                <input type="text" id="receiver" name="receiver" placeholder="收件人">
                <input type="text" id="address" name="address" placeholder="地址">
                <input type="text" id="phone" name="phone" placeholder="电话号码">
                <input type="text" id="store" name="store" placeholder="下单门店">
                
                
                    <!-- $gid = document.getElementById('goodid').value; 

                    $sql3 = "SELECT `sid` FROM ssellg WHERE gid = :gid";
                    $stmt3 = $db->prepare($sql3); 
                    $stmt3->execute(['gid' => $gid]);
                    $sids = $stmt3->fetchAll(PDO::FETCH_COLUMN); -->
<!-- 
                     if (empty($sids)) {
                         echo '暂无门店可售';
                     } else {
                         echo '<div id="storeButtons">';
                         foreach ($sids as $sid) {
                             echo '<button type="button" class="storeButton" data-sid="' . htmlspecialchars($sid) . '">' . htmlspecialchars($sid) . '</button>';
                         }
                         echo '</div>';
                     } -->


                <input type="text" id="beizhu" name="beizhu" placeholder="备注"><br>
                <!-- 确认支付按钮 -->
                <button type="submit" class="pay-button" >确认下单</button>
            </form>
        </div>
    </div>
</body>

</html>