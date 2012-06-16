<?php

$essence = array("title", "content", "author"); 

if (!isset($querydata)) $querydata = array(); 

foreach ($essence as $field) if (!isset($querydata[$field])) $querydata[$field] = ""; 

if (!isset($querydata["type"])) $querydata["type"] = ""; 

function msubstr($str, $start, $len) {
    $tmpstr = "";
    $strlen = $start + $len;
     for($i = 0; $i < $strlen; $i++) {
         if(ord(substr($str, $i, 1)) > 0xa0) {
            $tmpstr .= substr($str, $i, 2);
            $i++;
         } else
            $tmpstr .= substr($str, $i, 1);
     }
     return $tmpstr;
}

function cut_str($sourcestr,$cutlength) 
{ 
   $returnstr=''; 
   $i=0; 
   $n=0; 
   $str_length=strlen($sourcestr);//字符串的字节数 
   while (($n<$cutlength) and ($i<=$str_length)) 
    { 
      $temp_str=substr($sourcestr,$i,1); 
      $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码 
      if ($ascnum>=224)    //如果ASCII位高与224，
      { 
         $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符         
         $i=$i+3;            //实际Byte计为3
         $n++;            //字串长度计1
      }
       elseif ($ascnum>=192) //如果ASCII位高与192，
      { 
         $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符 
         $i=$i+2;            //实际Byte计为2
         $n++;            //字串长度计1
      }
       elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
      { 
         $returnstr=$returnstr.substr($sourcestr,$i,1); 
         $i=$i+1;            //实际的Byte数仍计1个
         $n++;            //但考虑整体美观，大写字母计成一个高位字符
      }
       else                //其他情况下，包括小写字母和半角标点符号，
      { 
         $returnstr=$returnstr.substr($sourcestr,$i,1); 
         $i=$i+1;            //实际的Byte数计1个
         $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽...
      } 
    } 
          if ($str_length>$cutlength){
          $returnstr = $returnstr . "...";//超过长度时在尾处加上省略号
      }
     return $returnstr; 

}

?>


<script language="javascript">
function goto_page(i)
{
	document.getElementById('page').value = i; 
	document.getElementById('queryform').submit();  
}
</script>

<?= form_open('page/query', array("id" => "queryform")); ?>

<input type="hidden" name="page" id="page" value="<?= $querydata['page']; ?>" />

<div class="fields">

<?= form_input(array("name" => "title", 
					 "id" => "title", 
					 "value" => $querydata['title'], 
					 "placeholder" => $this->lang->line('page_ph_title'))); ?>
					 
<?= form_input(array("name" => "author", 
					 "id" => "author", 
					 "value" => $querydata['author'], 
					 "placeholder" => $this->lang->line('page_ph_author'))); ?>

<?= form_input(array("name" => "content", 
					 "id" => "content", 
					 "value" => $querydata['content'], 
					 "placeholder" => $this->lang->line('page_ph_content'))); ?>
					 
<?= form_dropdown("type", 
				  array_merge($this->config->item('page_type_list'), array("" => $this->lang->line('page_any'))), 
				  $querydata['type'],
				  'id="type"'); ?>

</div>

<?= form_submit(array("name" => "submit_button", 
					  "id" => "submit_button", 
					  "value" => $this->lang->line('page_query_page'),
					  "onclick" => "document.getElementById('page').value = '1'")); ?>

<?= form_close(); ?>

<div class="division"></div>

<? if(count($data) == 0): ?>

<p class="msg"><?= $this->lang->line('misc_msg_no_match_found'); ?></p>

<? else: ?>

<? $start = true; ?>

<? foreach ($data as $row): ?>

<div class="article_entity">
<div class="article_desc">
<h2><?= anchor("page/show/" . $row->id, to_html($row->title)) . " "; ?></h2>
<p class="author"><?= to_html($row->author); ?></p>
<p class="preview">
<?
	$preview = to_html_rich_plain($row->content); 
	if (strlen($preview) > $this->config->item('page_preview_length')) $preview = cut_str($preview, $this->config->item('page_preview_length')) . "……"; 
	$thumbnail = fetch_tag_value($row->content, 'thumbnail'); 
?>
<?= $preview; ?>
</p>
</div>
<div class="article_image">
<? if ($thumbnail != ""): ?>

<img src="<?= $thumbnail; ?>" width="<?= $this->config->item('article_image_width'); ?>" />

<? endif; ?>

</div>
</div>

<div class='division'></div>

<? endforeach; ?>

<div class="navs">

<? if ($querydata['page'] > 1): ?>

<a href="#" onclick="goto_page(1); " class="navigator"><?= $this->lang->line('misc_first_page'); ?></a>
<a href="#" onclick="goto_page(<?= $querydata['page'] - 1; ?>); " class="navigator"><?= $this->lang->line('misc_prev_page'); ?></a> 

<? endif; ?>

<? if ($querydata['page'] < $totpage): ?>

<a href="#" onclick="goto_page(<?= $querydata['page'] + 1; ?>); " class="navigator"><?= $this->lang->line('misc_next_page'); ?></a> 
<a href="#" onclick="goto_page(<?= $totpage; ?>); " class="navigator"><?= $this->lang->line('misc_last_page'); ?></a>

<? endif; ?>

</div>

<? endif; ?>