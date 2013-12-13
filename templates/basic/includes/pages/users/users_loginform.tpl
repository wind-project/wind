
<div class="login">
<form name="login-form" action="{$form_submit_url}" method="POST">
	<input type="hidden" name="form_name" value="login"/> 
  <fieldset>
    <label>{$lang.username}: <input type="text" name="username"></label>
    <label>{$lang.password}: <input type="password" name="password"></label>
	<label>{$lang.rememberme}: <input type="checkbox" name="rememberme"></label>
  </fieldset>
  	<div class="notification"></div>
    <input type="submit" value="Login"> <a href="{$link_restore_password}">{$lang.password_recover}</a>
</form>
</div>
