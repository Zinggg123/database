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
            // 获取所有点单按钮
        var buttons = document.querySelectorAll('.circle-button');
        // 获取模态对话框和关闭按钮
        var modal = document.getElementById('myModal');
        var span = document.getElementsByClassName("close")[0];
    
        // 为每个按钮添加点击事件监听器
        buttons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                // 获取当前按钮所在.good的h4元素
                var productNameElement = event.target.closest('.good').querySelector('h4');
                var productPriceElement = event.target.closest('.good').querySelector('h5');
                // 设置模态框中的商品名称
                document.getElementById('modal-product-name').innerText = productNameElement.innerText;
                document.getElementById('modal-product-price').innerText = productPriceElement.innerText;
                // 显示模态框
    
                modal.style.display = "block";
            });
        });
    
        // 当点击关闭按钮或点击模态背景时，关闭模态框
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

});