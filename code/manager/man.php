<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cucu奶茶-店长后台</title>
    <link rel="stylesheet" href="man.css">
    <script src="man.js"></script>
    <script src="../JS/jquery.min.js"></script>
</head>

<body>
    <?php
        //传递状态信息（ID与用户类型）
        session_start();
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'worker') {
            header("Location: login.html");
            exit();
        }
        require_once '../database.php';
        $currentWorkerId = $_SESSION['user_id'];

        try {
            $db = Database::getInstance();//建立连接

            //得到该员工对应的店铺
            $sqlShop = "SELECT wsid FROM worker WHERE wid = :workerId";
            $stmtShop = $db->prepare($sqlShop);
            $stmtShop->bindParam(':workerId', $currentWorkerId, PDO::PARAM_INT);
            $stmtShop->execute();
            $shopId = $stmtShop->fetchColumn();

            //根据店铺信息得到店铺订单信息
            if ($shopId !== false) {
                $sqlOrders = "SELECT * FROM order_view WHERE shopid = :shopId";
                $stmtOrders = $db->prepare($sqlOrders);
                $stmtOrders->bindParam(':shopId', $shopId, PDO::PARAM_INT);
                $stmtOrders->execute();
                $results = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);
            }
            else{
                echo "无法找到该员工所属的店铺信息。";
            }

            //获取店铺员工信息
            $sql_employee = "SELECT wid,wname,ctel,wpos,wage FROM worker WHERE wsid=:shopId";
            $stmt_employee = $db->prepare($sql_employee);
            $stmt_employee->bindParam(':shopId', $shopId, PDO::PARAM_INT);
            $stmt_employee->execute();
            // $stmt_employee = $db->prepareAndExecute($sql_employee);
            $employee_results = $stmt_employee->fetchAll(PDO::FETCH_ASSOC);

            //获取所有商品
            $sql_good = "SELECT gid,gname,gprice,gintro,gbeizhu FROM good";
            $stmt_good = $db->prepareAndExecute($sql_good);
            $good_results = $stmt_good->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        // $db = null; // 关闭数据库连接
    ?>

    <div class="header">
        <div class="logo"></div>
        <div class="lname">Cucu奶茶，用心做好茶!</div>
    </div>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="#page1" class="nav-link">店铺订单</a></li>
                <li><a href="#page4" class="nav-link">员工管理</a></li>
                <li><a href="#page5" class="nav-link">商品管理</a></li>
                <li><a href="#page6" class="nav-link">个人信息</a></li>
            </ul>
        </div>
        <div class="content">
            <div id="page1" class="page">
                <h2>加油！请努力做出美味的奶茶吧！</h2>
                <h3> - 店铺订单</h3>
                <table cellspacing="0" cellpadding="5">
                    <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>商品名称</th>
                            <th>送货地址</th>
                            <th>手机号码</th>
                            <th>收货人</th>
                            <th>备注</th>
                            <th>订单状态</th>
                            <th>处理人</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['订单ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['商品名']); ?></td>
                                <td><?php echo htmlspecialchars($row['收货地址']); ?></td>
                                <td><?php echo htmlspecialchars($row['手机号码']); ?></td>
                                <td><?php echo htmlspecialchars($row['收货人']); ?></td>
                                <td><?php echo htmlspecialchars($row['备注']); ?></td>
                                <td><?php echo htmlspecialchars($row['订单状态']); ?></td>
                                <td><?php echo htmlspecialchars($row['处理人姓名']); ?></td>
                                <td>
                                    <div class="btngroup">
                                        <button type="button" class="btn-error" onclick="errororder(event)">设为error</button>
                                        <button type="button" class="btn-error" onclick="makeorder(event)">设为making</button>
                                        <button type="button" class="btn-error" onclick="distributeorder(event)">设为distributing</button>
                                        <button type="button" class="btn-error" onclick="finishorder(event)">设为finished</button>
                                    </div>

                                    <!-- <select class="status-select">
                                        <option value="">更新状态</option>
                                        <option value="异常">异常</option>
                                        <option value="正在配送">正在配送</option>
                                        <option value="已完成">已完成</option>
                                        <option value="正在制作">正在制作</option>
                                    </select> -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="page4" class="page" style="display: none;">
                <h2>带领你的员工经营最好的奶茶店！</h2>
                <h3>-员工管理</h3>
                <div class="ctop">
                    <button type="button" class="add">添加</button>
                </div>
                <table cellspacing="0" cellpadding="5">
                    <thead>
                        <tr>
                            <th>员工编号</th>
                            <th>姓名</th>
                            <th>职位</th>
                            <th>工资</th>
                            <th>手机号码</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employee_results as $row1): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row1["wid"]); ?></td>
                                    <td><?php echo htmlspecialchars($row1['wname']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['wpos']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['wage']); ?></td>
                                    <td><?php echo htmlspecialchars($row1['ctel']); ?></td>
                                    <td>
                                        <button type="button" class="btn-as">加薪</button>
                                        <button type="button" class="btn-kai" onclick="deleteWorker(event)">开除</button>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="page5" class="page" style="display: none;">
                <h2>又要上新品了吗？</h2>
                <h3>-商品管理</h3>
                <div class="ctop">
                    <button type="button" class="add">添加</button>
                </div>
                <table cellspacing="0" cellpadding="5">
                    <thead>
                        <tr>
                            <th>商品ID</th>
                            <th>商品名</th>
                            <th>简介</th>
                            <th>定价</th>
                            <th>状态</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($good_results as $row2): 
                                //根据ssell更新商品状态
                                $sql_checkstatus = "SELECT COUNT(*) FROM ssellg WHERE gid=:iig AND `sid`=:iis";
                                $stmt_checkstatus = $db->prepare($sql_checkstatus);
                                $stmt_checkstatus->bindParam(':iis', $shopId, PDO::PARAM_INT);
                                $stmt_checkstatus->bindParam(':iig', $row2["gid"], PDO::PARAM_INT);
                                $stmt_checkstatus->execute();
                                $count = $stmt_checkstatus->fetchColumn();
                                $gstatus=$count>0?'上架':'下架';
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row2["gid"]); ?></td>
                                    <td><?php echo htmlspecialchars($row2['gname']); ?></td>
                                    <td><?php echo htmlspecialchars($row2['gprice']); ?></td>
                                    <td><?php echo htmlspecialchars($row2['gintro']); ?></td>
                                    <td><?php echo htmlspecialchars($gstatus); ?></td>
                                    <td><?php echo htmlspecialchars($row2['gbeizhu']); ?></td>
                                    <td>
                                    <?php 
                                        if (htmlspecialchars($gstatus) === '下架') {
                                            echo '<button type="button" class="btn-up" data-gid="'.htmlspecialchars($row2['gid']).'">上架</button>';
                                        } elseif (htmlspecialchars($gstatus) === '上架') {
                                            echo '<button type="button" class="btn-down" data-gid="'.htmlspecialchars($row2['gid']).'">下架</button>';
                                        }
                                    ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="page6" class="page" style="display: none;">
                <h2>做最棒的自己！</h2>
                <h3>- 个人信息</h3>
                <table cellspacing="0" cellpadding="5">
                    <tbody>
                        <tr>
                            <th>姓名</th>
                            <td>百香果双响炮</td>
                        </tr>
                        <tr>
                            <th>员工编号</th>
                            <td>商品B</td>
                        </tr>
                        <tr>
                            <th>职位</th>
                            <td>商品B</td>
                        </tr>
                        <tr>
                            <th>就职门店</th>
                            <td>商品B</td>
                        </tr>
                        <tr>
                            <th>工龄</th>
                            <td>商品C</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<!-- !!!!!!!!!! -->
<!-- 涨工资 -->
    <div id="addsalary" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span> <!-- 关闭按钮 -->
            <h3 id="modal-worker-name">员工姓名</h3>
            <h4 id="modal-worker-id">员工ID</h4>
            <form id="addsalaryForm" method="POST">
                <input type="hidden" id="wkid" name="wkid" >
                <input type="text" id="addsalary" name="aswid" placeholder="请输入目标薪资"><br>
                <button type="submit" class="addsal-button" id="asbut">确认</button>
            </form>
        </div>
    </div>
    <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
            try {
                $empid = $_POST['wkid']; // 员工ID
                $newsala = $_POST['aswid']; // 从输入字段获取的新薪资
                // 调用存储过程
                $stmt = $db->prepare("CALL check_salary(:empid, :newsala)");
                $stmt->bindParam(':empid', $empid, PDO::PARAM_INT);
                $stmt->bindParam(':newsala', $newsala, PDO::PARAM_INT);
                $stmt->execute();
                $errorInfo = $stmt->errorInfo();
                if ($errorInfo[1] == '45000') {
                    echo "<script>alert('". $errorInfo[2] . "');</script>"; 
                } else {
                    echo "<script>if (confirm('加薪操作成功')) {location.reload();} else {location.reload();}</script>";
                    
                }    
            } catch(PDOException $e) {
                echo "数据库操作错误: " . $e->getMessage();
        
            }
        }
    ?>

</body>

<!-- !!!!!!!!!!!!!!!!! -->
<!-- 下架/上架商品 完成 -->
<script>
    $(document).ready(function(){
        $('.btn-down').on('click', function(e){
            e.preventDefault();
            var gid = $(this).data('gid'); // 获取商品ID
            var shopId = <?php echo json_encode((int)$shopId); ?>; // 获取shopId
            
            $.ajax({
                type: "POST",
                url: "manii.php",
                data: { action: 'deleteAndUpdate', gid: gid, shopId: shopId },
                success: function(response){
                    location.reload();
                },
                error: function(){
                    alert('请求失败，请检查网络');
                }
            });
        });
    });
    
    $(document).ready(function(){
        $('.btn-up').on('click', function(e){
            e.preventDefault();
            var gid = $(this).data('gid'); // 获取商品ID
            var shopId = <?php echo json_encode((int)$shopId); ?>; // 获取shopId
            
            $.ajax({
                type: "POST",
                url: "manee.php",
                data: { action: 'addAndUpdate', gid: gid, shopId: shopId },
                success: function(response){
                    location.reload();
                },
                error: function(){
                    alert('请求失败，请检查网络');
                }
            });
        });
    });
</script>


</html>