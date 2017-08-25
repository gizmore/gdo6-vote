<?php
use GDO\UI\GDO_Badge;
use GDO\UI\GDO_Tooltip;
use GDO\Vote\GDO_VoteCount;
$field instanceof GDO_VoteCount;
?>
<?php
$gdo = $field->getVoteObject();
$votesNeeded = $gdo->gdoVotesBeforeOutcome();
$votesHave = $gdo->getVoteCount();
if ($votesHave >= $votesNeeded)
{
    echo GDO_Badge::make()->value($field->getGDOVar())->render();
}
else 
{
	echo GDO_Tooltip::make()->tooltip(t('tt_gdo_votecount_open', [$votesHave, $votesNeeded]));
}
