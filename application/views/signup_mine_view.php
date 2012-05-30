<? if (count($pages) == 0): ?>

<p class="msg"><?= $this->lang->line('signup_msg_no_signup'); ?></p>

<? else: ?>

<?php foreach ($pages as $page): ?>

<a class="signup_entry" href="<?= site_url('page/show/' . $page->id); ?>"><?= $page->title; ?></a>

<?php endforeach; ?>

<? endif; ?>