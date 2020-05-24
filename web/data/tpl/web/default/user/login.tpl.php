<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header-base', TEMPLATE_INCLUDEPATH)) : (include template('common/header-base', TEMPLATE_INCLUDEPATH));?>
<div class="system-login" <?php  if(!empty($_W['setting']['copyright']['background_img']) && function_exists('to_global_media')) { ?> style="background-image:url('<?php  echo to_global_media($_W['setting']['copyright']['background_img']);?>')" <?php  } else { ?> style="background-image: url('./resource/images/bg-login.png');" <?php  } ?>>

	<div class="head">
		<?php  if(!empty($_W['setting']['copyright']['showhomepage'])) { ?>
		<a href="<?php  echo url('account/welcome')?>" class="pull-right">首页</a>
		<?php  } ?>
	</div>
 <style type="text/css">
	body{
		min-width: 0!important;
		min-height: 100vh;
		padding-bottom: 
	}
  /*按钮颜色*/
  .btn-primary{
  		background-color: #5b6be8;
    	border-color: #5b6be8;
  }
  .btn-primary:hover{
  		background-color: #5b6be8;
    	opacity:0.8;
    	border-color: #5b6be8;
  }
	.footer{
		width: 100%;
	}
	.system-login{
		
		min-height: 100vh!important;
        position:relative;
	}
	.system-login .login-panel{
		padding: 3.25rem;
		padding-top: 2rem;
		box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.05);
	    background: #ffffff7a;
	    border-radius: 4px;
	    position: fixed;
	    width: 25%;
	    left: 37%;
        top:9%;
	}
	.login-panel .title, .register .title{
		border-bottom: none;
	}
	.login-panel .input-group-vertical>input, .register-panel .input-group-vertical>input{
		margin: 2rem 0;
	}
	.loginbxbyzm>h3{
		padding-bottom: 3rem;
	}
	.loginbxbyzm .form-inline{
		padding: 1rem 0;
	}
	.loginbxbyzm .pull-left,.loginbxbyzm .text-right{
		padding: 1rem 0;
	}
	.loginbxbyzm .pull-left a,.loginbxbyzm .text-right a{
		color:#707070 !important;
	}
	@media(max-width:1400px){
		.system-login .login-panel{
		    width: 30%;
		    left: 35%;
		}
	}
	@media(max-width:1024px){
		.system-login .login-panel{
		     padding: 3.25rem;
		padding-top: 2rem;
		box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.05);
	    background: #ffffff8c;
	    border-radius: 4px;
	    position: fixed;
	    width: 25%;
	    left: 37%;
        top:9%;}
	}
	@media(max-width:768px){
		.system-login .login-panel{
		    padding: 3.25rem;
		padding-top: 2rem;
		box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.05);
	    background: #ffffff8c;
	    border-radius: 4px;
	    position: fixed;
	    width: 25%;
	    left: 37%;
        top:9%;
		}
	}
	@media(max-width:590px){
		.system-login+.footer .friend-link a, .system-register+.footer .friend-link a{
			padding: 0 10px;
			font-size: 12px;
		}
		.system-login .login-panel{
		    width: 80%;
		    left: 10%;
		    padding: 2.25rem;
		}
		.loginbxbyzm>h3{
			padding-bottom: 0.5rem;
		}
		.login-panel .input-group-vertical>input, .register-panel .input-group-vertical>input{
			margin: 1rem 0;
		}
		.loginbxbyzm .form-inline{
			padding: 0rem 0;
		}
		.loginbxbyzm .pull-left,.loginbxbyzm .text-right{
			padding: 0.5rem 0;
		}
	}
  
	.large-header {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		/* background: #333; */
		overflow: hidden;
		background-size: cover;
		background-position: center center;
		z-index: 0;
	}
</style>
	<div class="login-panel">
		<div class="title">
			<a href="/" class="logo-version">
			<img src="<?php  if(!empty($_W['setting']['copyright']['flogo']) && function_exists('to_global_media')) { ?><?php  echo to_global_media($_W['setting']['copyright']['flogo'])?><?php  } else { ?>./resource/images/logo/logo.png<?php  } ?>" class="logo">
			<span class="version hidden"><?php echo IMS_VERSION;?></span>
		</a>
		</div>
		<form action="" method="post" role="form" id="form1" onsubmit="return formcheck();" class="we7-form">

			<div class="input-group-vertical">
				<input name="login_type" type="hidden" class="form-control " value="system">
				<input name="username" type="text" class="form-control " placeholder="请输入用户名/手机登录">
				<input name="password" type="password" class="form-control password" placeholder="请输入登录密码">
				<?php  if(!empty($_W['setting']['copyright']['verifycode'])) { ?>
				<div class="input-group">
					<input name="verify" type="text" class="form-control" placeholder="请输入验证码">
					<a href="javascript:;" id="toggle" class="input-group-btn imgverify"><img id="imgverify" src="<?php  echo url('utility/code')?>" title="点击图片更换验证码" /></a>
				</div>
				<?php  } ?>
			</div>

			<div class="form-inline" style="margin-bottom: 15px;">
				<div class="pull-right">
					<a href="<?php  echo url('user/find-password');?>" target="_blank" class="color-default"></a>
				</div>
				<div class="checkbox">
					<input type="checkbox" value="true" id="rember" name="rember">
					<label for="rember">记住用户名</label>
				</div>
			</div>
			<div class="login-submit text-center">
				<input type="submit" id="submit" name="submit" value="登录" class="btn btn-primary btn-block" />
				<div class="text-right">
					<?php  if(!$_W['siteclose'] && $setting['register']['open']) { ?>
						<?php  if(empty($_GPC['login_type']) || $_GPC['login_type'] == 'system') { ?>
						<a href="<?php  echo url('user/register');?>" class="color-default">立即注册</a>
						<?php  } ?>
						<?php  if($_GPC['login_type'] == 'mobile') { ?>
						<a href="<?php  echo url('user/register', array('register_type' => 'mobile'))?>" class="color-default">立即注册</a>
						<?php  } ?>
					<?php  } ?>
				</div>
				<input name="token" value="<?php  echo $_W['token'];?>" type="hidden" />
			</div>
			<?php  if(!empty($setting['thirdlogin']['qq']['authstate']) || !empty($setting['thirdlogin']['wechat']['authstate'])) { ?>
			<div class="text-center">
				<span class="color-gray">使用第三方账号登录</span>
				<div class="form-control-static">
					<?php  if(!empty($setting['thirdlogin']['qq']['authstate'])) { ?><a href="<?php  echo $login_urls['qq'];?>"><img src="./resource/images/qqlogin.png" width="35px"></a>&nbsp;&nbsp;<?php  } ?>
					<?php  if(!empty($setting['thirdlogin']['wechat']['authstate'])) { ?><a href="<?php  echo $login_urls['wechat'];?>"><img src="./resource/images/wxlogin.png" width="35px"></a><?php  } ?>
				</div>
			</div>
			<?php  } ?>
		</form>
	</div>
</div>
<script>
function formcheck() {
	if($('#remember:checked').length == 1) {
		cookie.set('remember-username', $(':text[name="username"]').val());
	} else {
		cookie.del('remember-username');
	}
	return true;
}
var h = document.documentElement.clientHeight;
$(".system-login").css('height',h);
$('#toggle').click(function() {
	$('#imgverify').prop('src', '<?php  echo url('utility/code')?>r='+Math.round(new Date().getTime()));
	return false;
});
<?php  if(!empty($_W['setting']['copyright']['verifycode'])) { ?>
	$('#form1').submit(function() {
		var verify = $(':text[name="verify"]').val();
		if (verify == '') {
			alert('请填写验证码');
			return false;
		}
	});
<?php  } ?>
</script>
