document.addEventListener('DOMContentLoaded', function() {
    var navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            var targetId = this.getAttribute('href').substring(1); // 移除#号
            var targetPage = document.getElementById(targetId);
            
            var pages = document.getElementsByClassName('page');
            for(var i = 0; i < pages.length; i++) {
                pages[i].style.display = 'none';
            }
            
            targetPage.style.display = 'block';
        });
    });
});

///////////////////////
// 涨工资//////////////
document.addEventListener('DOMContentLoaded', function() {
    var buttons1 = document.querySelectorAll('.btn-as');
    var modal1 = document.getElementById('addsalary');
    var spanad = document.querySelector('#addsalary .close');
    var wkidInput = document.getElementById('wkid');

    // 为每个按钮添加点击事件监听器
    buttons1.forEach(function(button1) {
        button1.addEventListener('click', function(event) {
            var workerid = event.target.closest('tr').children[0].textContent.trim(); 
            var workername = event.target.closest('tr').children[1].textContent.trim();
            document.getElementById('modal-worker-name').innerText = workername;
            document.getElementById('modal-worker-id').innerText = workerid;
            wkidInput.value = workerid;
            // 显示模态框
            modal1.style.display = "block";
        });
    });

    // 当点击关闭按钮或点击模态背景时，关闭模态框
    spanad.onclick = function() {
        modal1.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
    }
});


//////////////////////////////////
// 开除员工///////////////////////
function deleteWorker(event) {
    var workerId = event.target.closest('tr').children[0].textContent.trim();
    if (confirm("确定要删除该员工吗？")) { // 弹出确认对话框
        $.ajax({
            url: 'mandw.php', // 留空，稍后说明
            type: 'POST',
            data: { action: 'deleteWorker', kaiid: workerId }, // 发送的数据
            success: function(response) {
                if (response == 'success') {
                    alert('已成功开除该员工');
                } else {
                    alert('开除失败');
                }
            },
            error: function() {
                alert('请求过程中发生错误！');
            }
        });
    }
}

/////////////////////////////////
// 更新订单状态//////////////////
function errororder(event) {
    var orderId = event.target.closest('tr').children[0].textContent.trim();
    if (confirm("确定要把该订单状态更新为异常吗？")) { // 弹出确认对话框
        $.ajax({
            url: 'manorder.php', // 留空，稍后说明
            type: 'POST',
            data: { action: 'errororder', oid: orderId, status:'error' }, // 发送的数据
            success: function(response) {
                if (response == 'success') {
                    alert('已完成状态更新');
                    location.reload();
                } else {
                    alert('状态更新失败');
                }
            },
            error: function() {
                alert('请求过程中发生错误！');
            }
        });
    }
}

function makeorder(event) {
    var orderId = event.target.closest('tr').children[0].textContent.trim();
    if (confirm("确定要把该订单状态更新为正在制作吗？")) { // 弹出确认对话框
        $.ajax({
            url: 'manorder.php', // 留空，稍后说明
            type: 'POST',
            data: { action: 'makeorder', oid: orderId, status:'making' }, // 发送的数据
            success: function(response) {
                if (response == 'success') {
                    alert('已完成状态更新');
                    location.reload();
                } else {
                    alert('状态更新失败');
                }
            },
            error: function() {
                alert('请求过程中发生错误！');
            }
        });
    }
}

function distributeorder(event) {
    var orderId = event.target.closest('tr').children[0].textContent.trim();
    if (confirm("确定要把该订单状态更新为正在配送吗？")) { // 弹出确认对话框
        $.ajax({
            url: 'manorder.php', // 留空，稍后说明
            type: 'POST',
            data: { action: 'distributeorder', oid: orderId, status:'distributing' }, // 发送的数据
            success: function(response) {
                if (response == 'success') {
                    alert('已完成状态更新');
                    location.reload();
                } else {
                    alert('状态更新失败');
                }
            },
            error: function() {
                alert('请求过程中发生错误！');
            }
        });
    }
}

function finishorder(event) {
    var orderId = event.target.closest('tr').children[0].textContent.trim();
    if (confirm("确定要把该订单状态更新为已完成吗？")) { // 弹出确认对话框
        $.ajax({
            url: 'manorder.php', // 留空，稍后说明
            type: 'POST',
            data: { action: 'finishorder', oid: orderId, status:'finished' }, // 发送的数据
            success: function(response) {
                if (response == 'success') {
                    alert('已完成状态更新');
                    location.reload();
                } else {
                    alert('状态更新失败');
                }
            },
            error: function() {
                alert('请求过程中发生错误！');
            }
        });
    }
}
