<?php
class easyreviewsBackendUploadController extends waJsonController
{
	public function execute()
	{
        $file = waRequest::file('photo');
        $session = waRequest::cookie('PHPSESSID');

        if ($file->waImage()) {
            $path = wa()->getDataPath('', true);
            waFiles::create($path, true);
						$file->waImage()->resize(100, 100, waImage::INVERSE)->crop(96,96, 0, 0)->save(wa()->getDataPath(''.$session.'/', true)."$file->name");
        } else {return;}
    }
}
