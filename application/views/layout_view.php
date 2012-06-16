<?

if (!isset($extra_css)) $extra_css = array(); 

?>

<!DOCTYPE html>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?= $title ?></title>
		<link rel="stylesheet" type="text/css" href="<?= $css ?>" />
		<? foreach ($extra_css as $sheet): ?>
		<link rel="stylesheet" type="text/css" href="<?= $css_base . $sheet . '.css'; ?>" />
		<? endforeach; ?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>
		if (jQuery.browser.msie && jQuery.browser.version.slice(0, 1) <= "8") window.location.href = "<?= $this->config->item('base_url') . "unsupported.html"; ?>"; 
		else alert("You are fine. "); 
		</script>
	</head>
	
	<body>
		<?= $header ?>
		<?= $content ?>
		<?= $footer ?>
	</body>
</html>