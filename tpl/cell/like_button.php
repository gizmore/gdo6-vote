<?php
use GDO\User\GDO_User;
use GDO\Vote\GDT_LikeButton;
$field instanceof GDT_LikeButton;
$user = GDO_User::current();
$gdo = $field->getLikeObject();
$liked = $gdo->hasLiked($user);
$likes = $gdo->getLikes();
$field->icon('plus_one');
?>
<a
 class="md-button primary"
 ng-disabled="<?= $liked ? 'true' : 'false'; ?>"
 href="<?= $field->href; ?>"><?= $likes; ?></a>
