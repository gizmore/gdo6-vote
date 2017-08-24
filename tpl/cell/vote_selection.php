<?php
use GDO\Vote\GDO_VoteSelection;
$field instanceof GDO_VoteSelection;
?>
<div
 class="gdo-vote-selection"
 ng-controller="GWFVoteCtrl"
 ng-init='voteInit(<?= $field->initJSON(); ?>);'>
 <jk-rating-stars
 max-rating="5"
 rating="rating"
 read-only="false"
 on-rating="onVote(rating)" >
</jk-rating-stars>
</div>
