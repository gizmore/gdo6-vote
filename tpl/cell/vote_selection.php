<?php /** @var $field \GDO\Vote\GDT_VoteSelection **/
use GDO\UI\GDT_IconButton;
$vt = $field->voteTable();
$max = $vt->gdoVoteMax(); ?>
<?php for ($i = 1; $i <= $max; $i++) : ?>
<?= GDT_IconButton::make()->icon('star')->href($field->hrefVoteScore($i))->render(); ?>
<?php endfor; ?>
