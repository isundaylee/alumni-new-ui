<?

require_permission(1); 

$essence = array("name", "email", "year", "class", "state", "city", "university"); 

if (!isset($querydata)) $querydata = array(); 
if (!isset($data)) $data = array(); 

foreach ($essence as $field)
{
	if (!isset($querydata[$field])) $querydata[$field] = ""; 
}

if (!isset($querydata["gender"])) $querydata["gender"] = ""; 
if (!isset($querydata["country"])) $querydata["country"] = ""; 
if (!isset($querydata["major"])) $querydata["major"] = ""; 

$clist = $this->config->item('country_list'); 
$mlist = $this->config->item('major_list'); 

?>

<script language="javascript">

function goto_page(i)
{
	document.getElementById('page').value = i; 
	document.getElementById('queryform').submit();  
}

</script>

<?= form_open('index/query', array("id" => "queryform")); ?>

<input type="hidden" name="page" id="page" value="<?= $querydata['page']; ?>" />

<div class="query_fields">

<?= form_input(array("name" => "name",
					 "id" => "name",
					 "value" => $querydata['name'],
					 "placeholder" => $this->lang->line('membership_ph_name'))); ?>

<?= form_input(array("name" => "email",
					 "id" => "email",
					 "value" => $querydata['email'],
					 "placeholder" => $this->lang->line('membership_ph_email'))); ?>

<?= form_input(array("name" => "year",
					 "id" => "year",
					 "value" => $querydata['year'],
					 "placeholder" => $this->lang->line('membership_ph_year'))); ?>

<?= form_input(array("name" => "class",
					 "id" => "class",
					 "value" => $querydata['class'],
					 "placeholder" => $this->lang->line('membership_ph_class'))); ?>

<?= form_input(array("name" => "city",
					 "id" => "city",
					 "value" => $querydata['city'],
					 "placeholder" => $this->lang->line('membership_ph_city'))); ?>

<?= form_input(array("name" => "university",
					 "id" => "university",
					 "value" => $querydata['university'],
					 "placeholder" => $this->lang->line('membership_ph_university'))); ?>
					 
<?= form_dropdown('gender', 
				  array("M" => $this->lang->line('membership_male'),
				  		"F" => $this->lang->line('membership_female'),
				  		"" => $this->lang->line('misc_any')),
				  $querydata['gender'], 
				  'id="gender"'); ?>
					 
<?= form_dropdown('country',
				  array_merge($this->config->item('country_list'), array("" => $this->lang->line('misc_any'))),
				  $querydata['country'], 
				  'id="country"'); ?>
					 
<?= form_dropdown('major',
				  array_merge($this->config->item('major_list'), array("" => $this->lang->line('misc_any'))),
				  $querydata['major'], 
				  'id="major"'); ?>

</div>

<?= form_submit(array("name" => "submit_button",
					  "id" => "submit_button",
					  "value" => $this->lang->line('index_query_alumni'),
					  "onclick" => "document.getElementById('page').value='1'; ")); ?>

<?= form_close(); ?>

<div class="division"></div>

<? if (count($data) == 0): ?>

<p class="msg"><?= $this->lang->line('misc_msg_no_match_found'); ?></p>

<? else: ?>

<?php

$tmpl = array (
                    'table_open'          => '<table border="0" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr id="table_head">',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr class="table_row">',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr class="table_row_alt">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

$this->table->set_template($tmpl);

$tbdata = array(); 
$i = 0; 

// $tbdata[0]['uid'] = $this->lang->line('membership_uid'); 
$tbdata[0]['name'] = $this->lang->line('membership_name'); 
$tbdata[0]['email'] = $this->lang->line('membership_email'); 
$tbdata[0]['gender'] = $this->lang->line('membership_gender'); 
$tbdata[0]['year'] = $this->lang->line('membership_year'); 
$tbdata[0]['class'] = $this->lang->line('membership_class'); 
$tbdata[0]['country'] = $this->lang->line('membership_country'); 
// $tbdata[0]['state'] = $this->lang->line('membership_state'); 
// $tbdata[0]['city'] = $this->lang->line('membership_city'); 
$tbdata[0]['university'] = $this->lang->line('membership_university'); 
$tbdata[0]['major'] = $this->lang->line('membership_major'); 

foreach ($data as $row)
{
	$i = $i + 1; 
	$tbdata[$i] = array(); 
	// $tbdata[$i]['uid'] = to_html($row->id); 
	$tbdata[$i]['name'] = "<div style=\"min-width: 100px; \">" . anchor('membership/profile/' . $row->id, to_html($row->name)) . "</div>"; 
	$tbdata[$i]['email'] = to_html($row->email); 
	$tbdata[$i]['gender'] = $row->gender == "M" ? to_html($this->lang->line('membership_male')) : to_html($this->lang->line('membership_female')); 
	$tbdata[$i]['year'] = to_html($row->year); 
	$tbdata[$i]['class'] = to_html($row->class); 
	$tbdata[$i]['country'] = to_html($clist[$row->country]); 
	// $tbdata[$i]['state'] = to_html($row->state); 
	// $tbdata[$i]['city'] = to_html($row->city); 
	$tbdata[$i]['university'] = to_html($row->university); 
	$tbdata[$i]['major'] = to_html($mlist[$row->major]); 
}

echo $this->table->generate($tbdata); 

/*

echo $tmpl['table_open']; 

$iii = 0; 

foreach ($tbdata as $row) {
	$style = ""; 
	if ($iii == 0) echo $tmpl["heading_row_start"]; 
	else if ($iii % 2 == 1) echo $tmpl["row_start"]; 
	else echo $tmpl["row_alt_start"]; 
	foreach ($row as $key => $value) {
		if ($iii == 0) echo $tmpl["heading_cell_start"]; 
		else if ($iii % 2 == 1) echo $tmpl["cell_start"]; 
		else echo $tmpl["cell_alt_start"]; 
		echo $value; 
		if ($iii == 0) echo $tmpl["heading_cell_end"]; 
		else if ($iii % 2 == 1) echo $tmpl["cell_end"]; 
		else echo $tmpl["cell_alt_end"]; 
	}
	if ($iii == 0) echo $tmpl["heading_row_end"]; 
	else if ($iii % 2 == 1) echo $tmpl["row_end"]; 
	else echo $tmpl["row_alt_end"]; 
	$iii = $iii + 1; 
}

echo $tmpl['table_close']; */

?>

<div class="navs">

<? if ($querydata['page'] > 1): ?>

<a href="#" onclick="goto_page(1); " class="navigator"><?= $this->lang->line('misc_first_page'); ?></a> &nbsp; 
<a href="#" onclick="goto_page(<?= $querydata['page'] - 1; ?>); " class="navigator"><?= $this->lang->line('misc_prev_page'); ?></a> &nbsp; 

<? endif; ?>

<? if ($querydata['page'] < $totpage): ?>

<a href="#" onclick="goto_page(<?= $querydata['page'] + 1; ?>); " class="navigator"><?= $this->lang->line('misc_next_page'); ?></a> &nbsp; 
<a href="#" onclick="goto_page(<?= $totpage; ?>); " class="navigator"><?= $this->lang->line('misc_last_page'); ?></a>

<? endif; ?>

</div>

<? endif; ?>