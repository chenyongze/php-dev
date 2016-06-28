
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>直播课教师后台</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">

  <!-- Stylesheets -->
  <link href="/css/bootstrap.css" rel="stylesheet">
  <link href="/css/common.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/font-awesome.css">
  <link href="/css/style.css" rel="stylesheet">
  <link href="/css/pafu.css" rel="stylesheet">
  
  <!-- HTML5 Support for IE -->
  <!--[if lt IE 9]>
  <script src="js/html5shim.js"></script>
  <![endif]-->

  <!-- Favicon -->
  <link rel="shortcut icon" href="img/favicon/favicon.png">
</head>

<body>

<!-- Form area -->
<div class="admin-form">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <!-- Widget starts -->
            <div class="widget worange">
              <!-- Widget head -->
              <div class="widget-head">
                <i class="icon-lock"></i> 登录 
              </div>

              <div class="widget-content">
                <div class="padd">
                  <!-- Login form -->
                  <form class="form-horizontal" id="loginForm" method="POST">
                    <!--{if isset($login_errors) }-->
                    <!-- error -->
                    <div class="form-group">
                      <!--<label class="control-label col-lg-3 pafu_login_error" for="inputEmail">*error</label>-->
                      <div class="col-lg-9 pafu_login_error">
                      <!--
                      {foreach $login_errors as $error}
                        {$error[0]}<br/>
                      {/foreach}
                      -->
                      </div>
                    </div>
                    <!--{/if}-->
                    <!-- Email -->
                    <div class="form-group">
                      <label class="control-label col-lg-3" for="inputEmail">用户名</label>
                      <div class="col-lg-9">
                        <input type="text" class="form-control" id="inputEmail" placeholder="请输入教师名" name="username">
                      </div>
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                      <label class="control-label col-lg-3" for="inputPassword">密码</label>
                      <div class="col-lg-9">
                        <input type="password" class="form-control" id="inputPassword" placeholder="请输入密码" name="password">
                      </div>
                    </div>
                    <!-- Remember me checkbox and sign in button -->
                    <div class="form-group">
					<div class="col-lg-9 col-lg-offset-3">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="1" name="rememberMe"> 记住我
                        </label>
						</div>
					</div>
					</div>
                        <div class="col-lg-9 col-lg-offset-2">
							<button type="submit" id="btn_login" class="btn btn-danger">登录</button>
							<button type="reset" class="btn btn-default">重置</button>
						</div>
                    <br />
                  </form>
				  
				</div>
                </div>
                <div class="widget-foot">
                	没有账号? 请向教务申请开通
                </div>
            </div>  
      </div>
    </div>
  </div> 
</div>
<div id="error_msg" style="display:none;" class="alert alert_error">
</div>
<script>
    var domainName = "<{$domainName}>";
</script>

<!-- JS -->
<script src="/js/jquery.js"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/bootstrap.js"></script>
<script src="/js/app/common.js"></script>
<script src="/js/jquery.validate.js"></script>
<script src="/js/jquery.validate.additional.js"></script>
<script src="/js/underscore.js"></script>
<script src="/js/backbone.js"></script>
<script src="/js/plugins/jQuery.md5.js"></script>
<script src="/js/app/login.js"></script>
</body>
</html>
