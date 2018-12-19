<?php
/**
 * Design section.
 */
class easyreviewsDesignActions extends waDesignActions
{
    public function defaultAction()
    {
        $this->setLayout(new easyreviewsBackendLayout());
        parent::defaultAction();
    }
}
