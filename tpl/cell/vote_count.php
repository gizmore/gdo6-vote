<?php
use GDO\UI\GDT_Badge;
use GDO\UI\GDT_Tooltip;
use GDO\Vote\GDT_VoteCount;
$field instanceof GDT_VoteCount;
?>
<?php
$gdo = $field->getVoteObject();
$votesNeeded = $gdo->gdoVotesBeforeOutcome();
$votesHave = $gdo->getVoteCount();
if ($votesHave >= $votesNeeded)
{
    echo GDT_Badge::make()->value($field->getVar())->render();
}
else 
{
	echo GDT_Tooltip::make()->tooltip(t('tt_gdo_votecount_open', [$votesHave, $votesNeeded]));
}
