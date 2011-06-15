<?php

// Create configuration content
$config_content= "<?php\n"
	. "\$config = " . var_export($_SESSION['config'], true) . ";\n";
if (!@file_put_contents($_GLOBALS['root_path'] . '/config/config.php', $config_content)) {
	show_error('Cannot write configuration at "<strong>config\config.php</strong>. Check file permissions.');
} else {
?>
<div class="finish"><em>You have succesfully finished installing WiND!</em>
<p>In order to <a href="<?php echo surl('/../'); ?>">view</a> the site, You have to <strong>remove folder "install"</strong>, eitherwise WiND will prevent you from normal
operation.</p>
<p>Don't forget that you can further parametrize WiND by directly editing <strong>config/config.php</strong>.
You can find a documented configuration sample at <strong>config-sample/config.php</strong></p>
</div>

<?php 
}
