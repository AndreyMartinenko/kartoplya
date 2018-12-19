<?php

class easyreviewsViewhelper
{
    public function show()
    {
        $old_app = wa()->getApp();
        wa('easyreviews')->setActive('easyreviews');
        $action = new easyreviewsFrontendDefaultAction();
        $result = $action->display();
        waSystem::setActive($old_app);
        return $result;
    }

    public function last($num)
    {
        $model = new easyreviewsModel();
        $contacts_model = new waContactModel();

        $allrecords = $model->order('datetime DESC')->fetchAll();
        $records = array_slice($allrecords, 0, $num);

        $asm = new waAppSettingsModel();
        $gravatar = $asm->getByField(array('app_id' => 'easyreviews', 'name' => 'gravatar', 'value' => '1'));

        $i = 0;
        foreach ($records as &$r) {
            if ($r['moderated'] == 1) {
              if ($r['defaultphoto'] == 1) {
                $r['photo_url'] = wa()->getRootUrl(true)."wa-content/img/userpic96.jpg";
              } else {
                if ($r['contact_id']) {
                    $contact = new waContact($r['contact_id']);
                    $data = $contacts_model->getById($contact->getId());
                    if ($data) {
                        $contact->getPhoto();
                        $r['photo_url'] = $contact->getPhoto();
				        if ($r['photo_url'] == "" || $r['photo_url'] == "/wa-content/img/userpic96.jpg") {
				            if ($gravatar) {
								$email = $r['email'];
								$default = wa()->getRootUrl(true)."wa-content/img/userpic96.jpg";
								$size = 96;
								$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
								$r['photo_url'] = $grav_url;
							} else {
								$r['photo_url'] = wa()->getRootUrl(true)."wa-content/img/userpic96.jpg";
							}
				        }
                    } else {
                        if ($gravatar) {
                            $email = $r['email'];
                            $default = wa()->getRootUrl(true)."wa-content/img/userpic96.jpg";
                            $size = 96;
                            $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
                            $r['photo_url'] = $grav_url;
				        } else {
				            $r['photo_url'] = wa()->getRootUrl(true)."wa-content/img/userpic96.jpg";
				        }
                    }
                } else {
				    if ($gravatar) {
				        $email = $r['email'];
                        $default = wa()->getRootUrl(true)."wa-content/img/userpic96.jpg";
						$size = 96;
						$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
						$r['photo_url'] = $grav_url;
				    } else {
					   $r['photo_url'] = wa()->getRootUrl(true)."wa-content/img/userpic96.jpg";
				    }
				}}
            } else {
                unset($records[$i]);
            }
            $i++;
        }

        return $records;
    }
}
