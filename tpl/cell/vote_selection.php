<?php /** @var $field \GDO\Vote\GDT_VoteSelection **/
use GDO\UI\GDT_IconButton;
$vt = $field->voteTable();
$own = $field->ownVote();
$max = $vt->gdoVoteMax(); ?>
<?php for ($i = 1; $i <= $max; $i++) : ?>
<?php $color = $own < $i ? '#999' : '#ffd700'; ?>
<?= GDT_IconButton::make()->icon('star')->noFollow()->color($color)->href($field->hrefVoteScore($i))->render(); ?>
<?php endfor; ?>
