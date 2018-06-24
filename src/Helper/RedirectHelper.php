<?php

namespace Spqr\Redirect\Helper;

use Pagekit\Application as App;
use Pagekit\Kernel\Exception\NotFoundException;
use Pagekit\Kernel\Exception\ForbiddenException;
use Pagekit\Kernel\Exception\UnauthorizedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


/**
 * Class RedirectHelper
 *
 * @package Spqr\Redirect\Helper
 */
class RedirectHelper
{
    
    /**
     * @param $event
     *
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function process($event)
    {
        $config    = App::module('spqr/redirect')->config();
        $exception = $event->getException();
        
        if ($config['notfound']['enabled'] === true
            && $exception instanceof NotFoundException
        ) {
            $type = 'notfound';
        } elseif ($config['forbidden']['enabled'] === true
            && $exception instanceof ForbiddenException
        ) {
            $type = 'forbidden';
        } elseif ($config['unauthorized']['enabled'] === true
            && $exception instanceof UnauthorizedException
        ) {
            $type = 'unauthorized';
        } else {
            return false;
        }
        
        if (($config[$type]['frontend_only'] === true && App::isAdmin())) {
            return false;
        }
        
        if (in_array(App::request()->getUri(),
                $config['exclusions']['ignore_url'])
            || in_array(App::url()->current(),
                $config['exclusions']['ignore_url'])
        ) {
            return false;
        }
        
        foreach ($config['exclusions']['ignore_ext'] as $ignored_ext) {
            
            if (pathinfo(App::request()->getUri(), PATHINFO_EXTENSION)
                === $ignored_ext
                || (pathinfo(App::url()->current, PATHINFO_EXTENSION)
                    === $ignored_ext)
            ) {
                return false;
            }
        }
        
        $response = isset($config[$type]['response'])
            ? $config[$type]['response'] : $config['response'];
        
        if ($config[$type]['type'] === 'redirect') {
            $url = $config[$type]['url'];
            
            if (empty($url) || $url == null) {
                $url = '@page/1';
            }
            
            $response = new RedirectResponse(App::url($url), $response);
        } elseif ($config[$type]['type'] === 'html') {
            $response = new HttpResponse($config[$type]['html'], $response);
        } else {
            return false;
        }
        
        return $response;
    }
    
}