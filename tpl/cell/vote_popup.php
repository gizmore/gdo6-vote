<?php
use GDO\Vote\GDT_VotePopup;
use GDO\Vote\GDT_VoteSelection;
$field instanceof GDT_VotePopup;
$gdo = $field->gdo;
$id = $gdo->gdoTableName().$gdo->getID();

$votes = $gdo->getVoteCountColumn()->renderCell();
$rating = $gdo->getVoteRatingColumn()->renderCell();


$voteButton = sprintf('<md-button ng-click="showDialogId(\'#%s\', $event)" class="md-icon-button">', $id);
$voteButton .= sprintf('<md-icon class="material-icons">stars</md-icon>%s', $rating);
$voteButton .= "</md-button>\n";
echo $voteButton;
?>

<!-- Dialog Rate -->
<div style="visibility: hidden;">
  <div class="md-dialog-container" id="<?= $id; ?>">
	<md-dialog layout-padding>
	  <h2><?= t('dlg_votepopup_title'); ?></h2>
	  <p>
		<?= t('votepopup_rating', [$rating]); ?><br/>
		<?= t('votepopup_votes', [$votes]); ?><br/>
		<?= GDT_VoteSelection::make()->gdo($gdo)->renderCell(); ?>
	  </p>
	</md-dialog>
  </div>
</div>
