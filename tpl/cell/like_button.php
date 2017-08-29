<?php
use GDO\User\User;
use GDO\Vote\GDT_LikeButton;
$field instanceof GDT_LikeButton;
$user = User::current();
$gdo = $field->getLikeObject();
$liked = $gdo->hasLiked($user);
$likes = $gdo->getLikes();
$field->icon('plus_one');
?>
<a
 class="md-button primary"
 ng-disabled="<?= $liked ? 'true' : 'false'; ?>"
 href="<?= $field->href; ?>"><?= $likes; ?></a>
