<?php /** @var $field \GDO\Vote\GDT_VoteCount **/
use GDO\UI\GDT_Badge;
$gdo = $field->getVoteObject(); ?>
<span class="<?=$field->name;?>-vote-count-<?= $gdo->getID(); ?>">
<?php
$value = t('vote_count', [$gdo->getVoteCount()]);
echo GDT_Badge::make()->val($value)->renderCell();
?>
</span>
