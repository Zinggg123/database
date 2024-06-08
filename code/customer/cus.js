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


document.addEventListener('DOMContentLoaded', function() {
        var buttons = document.querySelectorAll('.circle-button');
        var modal = document.getElementById('myModal');
        var span = document.getElementsByClassName("close")[0];
    
        buttons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                var productNameElement = event.target.closest('.good').querySelector('h4');
                var productPriceElement = event.target.closest('.good').querySelector('h5');
                var productid=event.target.closest('.good').querySelector('.gid').textContent;
                document.getElementById('modal-product-name').innerText = productNameElement.innerText;
                document.getElementById('modal-product-price').innerText = productPriceElement.innerText;
                document.getElementById('goodid').value=productid;
    
                modal.style.display = "block";

                document.getElementById('orderForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // 阻止表单默认提交行为
                    let phoneNumber = document.getElementById('phone').value;
            
                    if (phoneNumber.length === 11 && /^\d+$/.test(phoneNumber)) {
                        placeOrder(phoneNumber);
                    } else {
                        alert('请输入有效的11位数字电话号码');
                    }
                });
            });
        });
    
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
});



function placeOrder(phoneNumber) {
    // 准备表单数据
    var formData = $('#orderForm').serializeArray();
    formData.push({ name: 'phone', value: phoneNumber }); // 重新添加phone，确保使用验证过的电话号码
    
    $.ajax({
        url: 'cusso.php', 
        type: 'POST',
        data: formData , 
        success: function(response) {
            if (response == 'success') {
                alert('下单成功');
                location.reload();
            } else {
                alert('下单失败');
            }
        },
        error: function() {
            alert('请求过程中发生错误！');
        }
    });
}


//////////////////////
// 确认收获////////////
function completeorder(event,userId) {
    var orderId = event.target.closest('tr').children[0].textContent.trim();
    if (confirm("确认确认收货？")) { // 弹出确认对话框
        $.ajax({
            url: 'cusfo.php', // 留空，稍后说明
            type: 'POST',
            data: { action: 'complete', ooid: orderId, owiwd: userId }, // 发送的数据
            success: function(response) {
                if (response == 'success') {
                    alert('已收货');
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
