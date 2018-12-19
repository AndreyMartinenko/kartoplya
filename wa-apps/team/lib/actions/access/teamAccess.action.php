<?php
/**
 * Access page in backend. Shows users/apps table with access rights.
 */
class teamAccessAction extends teamContentViewAction
{
    protected static $offset = 0;
    protected static $limit = 50;

    public function execute()
    {
        if (!wa()->getUser()->isAdmin()) {
            throw new waRightsException(_w('Access denied'));
        }

        $view_types = array(
            "users" => array(
                "name" => _w("Users"),
                "uri" => "?view=users"
            ),
            "groups" => array(
                "name" => _w("Groups"),
                "uri" => "?view=groups"
            ),
        );

        $view = waRequest::get('view', '', 'string');
        if ($view && !empty($view_types[$view])) {
            $selected_view_type = $view;
        } else {
            $selected_view_type = 'users';
        }

        $apps = wa()->getApps();

        if ($selected_view_type == 'users') {
            $users = array_values(
                teamUser::getList('users/all', array(
                    'fields' => 'minimal',
                    'offset' => self::$offset,
                    'limit' => self::$limit,
                ))
            );
            foreach ($users as &$u) {
                $user = new waContact($u['id']);
                $u['name'] = $user->getName();
                if (!$user->isAdmin()) {
                    $u['is_admin'] = false;
                    foreach ($apps as $a) {
                        $u['rights'] = min($user->getRights($a['id'], 'backend'), 2);
                        $u['access'][$a['id']] = $u['rights'];
                    }
                } else {
                    $u['is_admin'] = true;
                    $u['access'] = 2;
                }
                if ($u['login']) {
                    $u['uri'] = wa()->getUrl() . 'u/' . $u['login'] . '/';
                } else {
                    $u['uri'] = wa()->getUrl() . 'id/' . $u['id'] . '/';
                }
            }
            unset($u);

        } else {

            $gm = new waGroupModel();
            $groups = $gm->select('*')->order('type,sort')->limit(self::$limit)->fetchAll('id');
            foreach ($groups as &$g) {
                $g = array(
                    'id' => -$g['id'],
                    'is_user' => 0,
                    'login' => '',
                ) + teamGroup::getAppsInfo($g);
            }
            unset($g);
            $users = $groups;

        }

        $this->view->assign(array(
            'apps' => $apps,
            'users' => $users,
            'view_types' => $view_types,
            'selected_view_type' => $selected_view_type,
            'access_types' => teamHelper::getAccessTypes(),
        ));
    }
}
