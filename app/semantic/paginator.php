<?php

class SemanticPresenter extends Illuminate\Pagination\Presenter {

    public function getActivePageWrapper($text)
    {
        return '<div class="active item">' . $text . '</div>';
    }

    public function getDisabledTextWrapper($text)
    {
        return '<div class="disabled item">' . $text . '</div>';
    }

    public function getPageLinkWrapper($url, $page, $rel = null)
    {
        return '<a class="item" href="' . $url . '"' . (is_null($rel) ? '' : ' rel="' . $rel . '"') . '>' . $page . '</a>';
    }

    public function getDots()
    {
        return $this->getDisabledTextWrapper('<i class="ellipsis horizontal icon"></i>');
    }

    public function render()
    {
        if ($this->lastPage < 13)
        {
            $content = $this->getPageRange(1, $this->lastPage);
        }
        else
        {
            $content = $this->getPageSlider();
        }

        if ($this->lastPage <= 1)
        {
            return '';
        }
        return '<div class="ui compact menu">' . $this->getPrevious('<i class="left arrow icon"></i>') . $content . $this->getNext('<i class="right arrow icon"></i>') . '</div>';
    }

}