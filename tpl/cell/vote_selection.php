<?php
use GDO\Vote\GDT_VoteSelection;
$field instanceof GDT_VoteSelection;
?>
<div
 class="gdo-vote-selection"
 ng-controller="GDOVoteCtrl"
 ng-init='voteInit(<?= $field->displayJSON(); ?>);'>
 <jk-rating-stars
 max-rating="5"
 rating="rating"
 read-only="false"
 on-rating="onVote(rating)" >
</jk-rating-stars>
</div>
