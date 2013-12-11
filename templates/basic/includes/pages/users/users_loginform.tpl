
<div class="login">
<form name="login-form" action="{$form_submit_url}" method="POST">
  <fieldset>
    <label>{$lang.username}: <input type="text" name="username"></label>
    <label>{$lang.password}: <input type="password" name="password"></label>

  </fieldset>
    <input type="submit" value="Login"> <a href="{$link_restore_password}">{$lang.password_recover}</a>
</form>
</div>
