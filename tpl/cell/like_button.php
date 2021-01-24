<?php /** @var $field \GDO\Vote\GDT_LikeButton **/
use GDO\User\GDO_User;
use GDO\Vote\GDT_LikeCount;
use GDO\UI\GDT_IconButton;
$user = GDO_User::current();
$gdo = $field->getLikeObject();
$liked = $gdo->hasLiked($user);
$likes = GDT_LikeCount::make()->gdo($gdo)->render();
echo GDT_IconButton::make()->addClass($liked?'liked':'')->addClass('gdt-like-button')->icon('like')->href($field->href)->editable($field->editable)->labelRaw($likes)->render();
