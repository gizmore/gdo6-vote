<?php /** @var $field \GDO\Vote\GDT_LikeButton **/
use GDO\User\GDO_User;
use GDO\UI\GDT_Link;
use GDO\Vote\GDT_LikeCount;
$user = GDO_User::current();
$gdo = $field->getLikeObject();
$liked = $gdo->hasLiked($user);
$likes = GDT_LikeCount::make()->gdo($gdo)->render();
echo GDT_Link::make()->klass('gdt-like-button')->icon('like')->href($field->href)->editable($field->editable)->rawLabel($likes)->render();
