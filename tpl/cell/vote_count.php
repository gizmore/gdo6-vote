<?php /** @var $field \GDO\Vote\GDT_VoteCount **/
use GDO\UI\GDT_Badge;
use GDO\UI\GDT_Tooltip;
$gdo = $field->getVoteObject(); ?>
<span class="<?=$field->name;?>-vote-count-<?= $gdo->getID(); ?>">
<?php
$votesNeeded = $gdo->gdoVoteTable()->gdoVotesBeforeOutcome();
$votesHave = $gdo->getVoteCount();
if ($votesHave >= $votesNeeded)
{
	echo GDT_Badge::make()->value($field->getVar())->render();
}
else 
{
	echo GDT_Tooltip::make()->tooltip(t('tt_gdo_vote_open', [$votesHave, $votesNeeded]))->render();
}
?>
</span>