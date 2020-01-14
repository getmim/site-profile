<?php
/**
 * ProfileController
 * @package site-profile
 * @version 0.0.1
 */

namespace SiteProfile\Controller;

use SiteProfile\Library\Meta;
use Profile\Model\Profile;
use LibFormatter\Library\Formatter;

class ProfileController extends \Site\Controller
{
    public function singleAction() {
        $name = $this->req->param->name;

        $profile = Profile::getOne(['name'=>$name]);
        if(!$profile)
            return $this->show404();

        $profile = Formatter::format('profile', $profile);

        $params = [
            'profile'   => $profile,
            'meta'      => Meta::single($profile)
        ];

        $this->res->render('profile/single', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }
}