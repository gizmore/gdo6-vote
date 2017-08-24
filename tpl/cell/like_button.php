<?php
use GDO\User\User;
use GDO\Vote\GDO_LikeButton;
$field instanceof GDO_LikeButton;
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
