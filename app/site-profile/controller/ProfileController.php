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
use LibPagination\Library\Paginator;


class ProfileController extends \Site\Controller
{
    public function indexAction(){
        list($page, $rpp) = $this->req->getPager();

        $profiles = Profile::get([], $rpp, $page, ['id'=>false]);
        if($profiles)
            $profiles = Formatter::formatMany('profile', $profiles);

        $params = [
            'pagination' => null,
            'profiles'   => $profiles,
            'meta'       => Meta::index($profiles, $page)
        ];

        $total = Profile::count([]);
        if($total > $rpp){
            $params['pagination'] = new Paginator(
                $this->router->to('siteProfileIndex'),
                $total,
                $page,
                $rpp,
                10
            );
        }

        $this->res->render('profile/index', $params);
        $this->res->setCache(86400);
        $this->res->send();
    }

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
