<?php
use GDO\UI\GDT_Badge;
use GDO\UI\GDT_Tooltip;
use GDO\Vote\GDT_VoteRating;
$field instanceof GDT_VoteRating;
?>
<?php
$gdo = $field->getVoteObject();
$votesNeeded = $gdo->gdoVotesBeforeOutcome();
$votesHave = $gdo->getVoteCount();
if ($votesHave >= $votesNeeded)
{
    $value = sprintf('%.01f', $field->getVar());
    echo GDT_Badge::make()->value($value)->render();
}
else 
{
	echo GDT_Tooltip::make()->tooltip('tt_gdo_votecount_open', [$votesHave, $votesNeeded]);
}
