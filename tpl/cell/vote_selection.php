<?php
use GDO\Vote\GDT_VoteSelection;
use GDO\UI\GDT_Icon;
use GDO\UI\GDT_IconButton;
$field instanceof GDT_VoteSelection;
$vt = $field->voteTable();
// $vot = $vt->gdoVoteObjectTable();
$max = $vt->gdoVoteMax();
?>
<?php for ($i = 1; $i <= $max; $i++) : ?>
<?= GDT_IconButton::make()->icon('star')->href($field->hrefVoteScore($i)); ?>
<?php endfor; ?>
