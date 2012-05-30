<?

$ptlist = $this->config->item('page_type_list'); 

$this->load->language('homepage'); 
$this->load->language('membership'); 
$this->load->language('index'); 

?>



<div id="topbanner">
	<img src="<?= base_url("images/logo.png"); ?>" />
	<div id="topbanner_text_right">
	<?= $this->lang->line('misc_welcome'); ?>, <?= $username; ?>! 
	<? if(!signed_in()): ?>
	<?= anchor('membership/signin', $this->lang->line('membership_signin')); ?>
	<? else: ?>
	<?= anchor('membership/do_signout', $this->lang->line('membership_signout')); ?>
	<? endif; ?>
	</div>
</div>

<div id="middlepad">
	<img id="title_logo" src="<?= base_url("images/title.png"); ?>" />
</div>

<div id="content_panel">
	<div id="navibar">
		<a href=<?= site_url('homepage'); ?>><div id="navibar_1" class="navibar_buttom"><?= $this->lang->line('homepage_homepage'); ?></div></a>
		<a href=<?= site_url('membership/profile'); ?>><div id="navibar_2" class="navibar_buttom"><?= $this->lang->line('membership_profile'); ?></div></a>
		<a href=<?= site_url('index'); ?>><div id="navibar_3" class="navibar_buttom"><?= $this->lang->line('index_alumni_index'); ?></div></a>
		<a href=<?= site_url('page/query'); ?>><div id="navibar_4" class="navibar_buttom"><?= $ptlist['AT']; ?></div></a>
	</div>
	<img id="content_top" src="<?= base_url("images/content_top.png"); ?>">
	<div id="content_middle">
