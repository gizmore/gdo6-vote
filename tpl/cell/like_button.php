<?php /** @var $field \GDO\Vote\GDT_LikeButton **/
use GDO\User\GDO_User;
use GDO\UI\GDT_IconButton;
$user = GDO_User::current();
$gdo = $field->getLikeObject();
$liked = $gdo->hasLiked($user);
$likes = $gdo->getLikes();
echo GDT_IconButton::make()->icon('plus_one')->href($field->href)->disabled($field->disabled)->rawLabel($likes)->render();
