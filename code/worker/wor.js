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




// 完成订单 已实现
function completeorder(event,workerId) {
    console.log(workerId);
    var orderId = event.target.closest('tr').children[0].textContent.trim();
    if (confirm("确认完成制作？")) { // 弹出确认对话框
        $.ajax({
            url: 'worfo.php', // 留空，稍后说明
            type: 'POST',
            data: { action: 'complete', ooid: orderId, owiwd: workerId }, // 发送的数据
            success: function(response) {
                if (response == 'success') {
                    alert('设置成功');
                    location.reload();
                } else {
                    alert('设置失败');
                }
            },
            error: function() {
                alert('请求过程中发生错误！');
            }
        });
    }
    
}