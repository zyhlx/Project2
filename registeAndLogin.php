
<!-- 模态框 -->
<div class="modal fade" id="Register">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- 模态框头部 -->
            <div class="modal-header">
                <h4 class="modal-title">注册</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- 模态框主体 -->
            <div class="modal-body">
                <form action="registe.php" method="post" name="form_register" id="form_register">
                    <div class="form-group">
                        <label for="username-register" id="username-register-label">用户名:</label>
                        <input type="text" class="form-control" id="username-register" name="username-register" onblur="ontimecheckname()" placeholder="8-16位字母数字">
                    </div>
                    <div class="form-group">
                        <label for="password-register" id="password-register-label">密码:</label>
                        <input type="password" class="form-control" name="password-register" id="password-register" placeholder="8-16位字母数字" onblur="ontimecheckpassword()">
                    </div>
                    <div class="form-group">
                        <label for="pwdconfirm" id="pwdconfirm-register-label">确认密码：</label>
                        <input type="password" class="form-control" name="pwdconfirm-register" id="pwdconfirm-register" placeholder="Enter password" onblur="ontimecheckpassword2()">
                    </div>
                    <div class="form-group">
                        <label for="email" id="email-label">邮箱:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" onblur="ontimecheckemail()">
                    </div>
                    <div class="form-group">
                        <label for="address" id="address-label">地址:</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" onblur="ontimecheckaddress()">
                    </div>
                    <div class="form-group">
                        <label for="tel" id="tel-label">电话:</label>
                        <input type="tel" class="form-control" id="tel" name="tel" placeholder="Enter tel" onblur="ontimechecktel()">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" onclick="registe()">Submit</button>
                    </div>
                </form>
            </div>

            <!-- 模态框底部 -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="Login">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- 模态框头部 -->
            <div class="modal-header">
                <h4 class="modal-title">登录</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- 模态框主体 -->
            <div class="modal-body">
                <form action="login.php" onsubmit="return login()" name="form_login" method="post">
                    <div class="form-group">
                        <label for="username" id="username-label">用户名:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="password" id="password-label">密码:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="yanzhengma">验证码：</label>
                        <input type="text" class="form-control" name="yanzhengma" id="yanzhengma">
                        <div id="check" onclick="change()">
                            <a href="#">点击刷新验证码</a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            <!-- 模态框底部 -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
            </div>

        </div>
    </div>
</div>