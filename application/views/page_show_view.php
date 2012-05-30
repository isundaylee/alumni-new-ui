<?php

$ptlist = $this->config->item('page_type_list'); 

?>

<h2><?= $title; ?></h2>
<h3><?= $this->lang->line('page_author'); ?> <?= to_html($author); ?> <?= $this->lang->line('page_editor'); ?> <?= anchor('membership/profile/' . $owner, to_html($editor->name)); ?></h3>


<p><?= to_html_rich($content, array("pid" => $id)); ?></p>

<div class="navs">

<? if ($editable): ?>

<?= anchor('page/update_page/' . $id, $this->lang->line('page_update_this_page'), 'class="navigator"'); ?>

<?= anchor('page/delete_page/' . $id, $this->lang->line('page_delete_this_page'), 'class="navigator"'); ?>

<? endif; ?>

</div>

<? if (signed_in()): ?>

<?= form_open('page/do_comment'); ?>

<?= form_hidden(array("pid" => $id,
					  "owner" => $this->session->userdata('uid'))); ?>

<?= form_textarea(array("name" => "content",
						"id" => "content",
						"value" => "", 
						"placeholder" => $this->lang->line('page_ph_comment'))); ?>
						
<?= form_submit(array("name" => "submit_button", 
					  "id" => "submit_button",
					  "value" => $this->lang->line('page_comment'))); ?>

<?= form_close(); ?>

<? endif; ?>

<? if (count($comments) == 0): ?>

<p class="msg"><?= $this->lang->line('page_msg_no_comment'); ?></p>

<? else: ?>

<div class="division"></div>

<? foreach ($comments as $rid => $row): ?>

<p class="comment_title"><?= anchor('membership/profile/' . $commenters[$rid]->id, $commenters[$rid]->name); ?> <?= $this->lang->line('misc_said'); ?> </p>
<p class="comment_content"><?= to_html($row->content); ?></p>

<? endforeach; ?>

<? endif; ?>

<div class="navs">

<? if ($more): ?>

<?= anchor('page/comment/' . $id . '/1', $this->lang->line('page_see_all_comments'), 'class="navigator"'); ?>

<? endif; ?>

</div>