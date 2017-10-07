<?php
namespace GDO\Vote;
use GDO\UI\GDT_IconButton;
use GDO\Core\GDT_Template;
/**
 * Show a trophy with level badge.
 * A tooltip explains if your access is granted or restricted.
 * @author gizmore
 */
final class GDT_VotePopup extends GDT_IconButton
{
    public $level = 0;
    public function level($level)
    {
        $this->level = $level;
        return $this;
    }
    
    public function renderCell()
    {
        return GDT_Template::php('Vote', 'cell/vote_popup.php', ['field'=>$this]);
    }
}
