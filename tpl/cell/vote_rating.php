<?php /** @var $field \GDO\Vote\GDT_VoteRating **/
use GDO\UI\GDT_Badge;
use GDO\UI\GDT_Tooltip;
$gdo = $field->getVoteObject(); ?>
<span class="<?=$field->name;?>-vote-rating-<?= $gdo->getID(); ?>">
<?php
$votesNeeded = $gdo->gdoVoteTable()->gdoVotesBeforeOutcome();
$votesHave = $gdo->getVoteCount();
if ($votesHave >= $votesNeeded)
{
    $value = sprintf('%.01f', $gdo->getVoteRating());
	echo GDT_Badge::make()->addClass('vote-rating')->value($value)->render();
}
else 
{
	echo GDT_Tooltip::make()->addClass('vote-rating')->tooltip('tt_gdo_vote_open', [$votesHave, $votesNeeded])->renderCell();
}
?>
</span>
