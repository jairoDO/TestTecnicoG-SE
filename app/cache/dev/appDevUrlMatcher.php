<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                if (0 === strpos($pathinfo, '/_profiler/i')) {
                    // _profiler_info
                    if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                    }

                    // _profiler_import
                    if ($pathinfo === '/_profiler/import') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:importAction',  '_route' => '_profiler_import',);
                    }

                }

                // _profiler_export
                if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]++)\\.txt$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_export')), array (  '_controller' => 'web_profiler.controller.profiler:exportAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        // gse_blog_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'gse_blog_homepage')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\DefaultController::indexAction',));
        }

        if (0 === strpos($pathinfo, '/admin')) {
            if (0 === strpos($pathinfo, '/admin/post')) {
                // post
                if (rtrim($pathinfo, '/') === '/admin/post') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'post');
                    }

                    return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostController::indexAction',  '_route' => 'post',);
                }

                // post_show
                if (preg_match('#^/admin/post/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_show')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostController::showAction',));
                }

                // post_new
                if ($pathinfo === '/admin/post/new') {
                    return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostController::newAction',  '_route' => 'post_new',);
                }

                // post_create
                if ($pathinfo === '/admin/post/create') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_create;
                    }

                    return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostController::createAction',  '_route' => 'post_create',);
                }
                not_post_create:

                // post_edit
                if (preg_match('#^/admin/post/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_edit')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostController::editAction',));
                }

                // post_update
                if (preg_match('#^/admin/post/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_post_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_update')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostController::updateAction',));
                }
                not_post_update:

                // post_delete
                if (preg_match('#^/admin/post/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                        $allow = array_merge($allow, array('POST', 'DELETE'));
                        goto not_post_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_delete')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostController::deleteAction',));
                }
                not_post_delete:

            }

            if (0 === strpos($pathinfo, '/admin/tag')) {
                // tag
                if (rtrim($pathinfo, '/') === '/admin/tag') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'tag');
                    }

                    return array (  '_controller' => 'gse\\BlogBundle\\Controller\\TagController::indexAction',  '_route' => 'tag',);
                }

                // tag_show
                if (preg_match('#^/admin/tag/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'tag_show')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\TagController::showAction',));
                }

                // tag_new
                if ($pathinfo === '/admin/tag/new') {
                    return array (  '_controller' => 'gse\\BlogBundle\\Controller\\TagController::newAction',  '_route' => 'tag_new',);
                }

                // tag_create
                if ($pathinfo === '/admin/tag/create') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_tag_create;
                    }

                    return array (  '_controller' => 'gse\\BlogBundle\\Controller\\TagController::createAction',  '_route' => 'tag_create',);
                }
                not_tag_create:

                // tag_edit
                if (preg_match('#^/admin/tag/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'tag_edit')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\TagController::editAction',));
                }

                // tag_update
                if (preg_match('#^/admin/tag/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_tag_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'tag_update')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\TagController::updateAction',));
                }
                not_tag_update:

                // tag_delete
                if (preg_match('#^/admin/tag/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                        $allow = array_merge($allow, array('POST', 'DELETE'));
                        goto not_tag_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'tag_delete')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\TagController::deleteAction',));
                }
                not_tag_delete:

            }

        }

        if (0 === strpos($pathinfo, '/gse')) {
            // gse
            if (rtrim($pathinfo, '/') === '/gse') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'gse');
                }

                return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostGSEController::indexAction',  '_route' => 'gse',);
            }

            // gse_listar
            if ($pathinfo === '/gse/listar') {
                return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostGSEController::listarAction',  '_route' => 'gse_listar',);
            }

            // gse_new
            if ($pathinfo === '/gse/new') {
                return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostGSEController::newAction',  '_route' => 'gse_new',);
            }

            // gse_create
            if ($pathinfo === '/gse/create') {
                return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostGSEController::createAction',  '_route' => 'gse_create',);
            }

        }

        if (0 === strpos($pathinfo, '/post_tag')) {
            // posttag
            if (rtrim($pathinfo, '/') === '/post_tag') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'posttag');
                }

                return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostTagController::indexAction',  '_route' => 'posttag',);
            }

            // posttag_show
            if (preg_match('#^/post_tag/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'posttag_show')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostTagController::showAction',));
            }

            // posttag_new
            if ($pathinfo === '/post_tag/new') {
                return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostTagController::newAction',  '_route' => 'posttag_new',);
            }

            // posttag_create
            if ($pathinfo === '/post_tag/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_posttag_create;
                }

                return array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostTagController::createAction',  '_route' => 'posttag_create',);
            }
            not_posttag_create:

            // posttag_edit
            if (preg_match('#^/post_tag/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'posttag_edit')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostTagController::editAction',));
            }

            // posttag_update
            if (preg_match('#^/post_tag/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_posttag_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'posttag_update')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostTagController::updateAction',));
            }
            not_posttag_update:

            // posttag_delete
            if (preg_match('#^/post_tag/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_posttag_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'posttag_delete')), array (  '_controller' => 'gse\\BlogBundle\\Controller\\PostTagController::deleteAction',));
            }
            not_posttag_delete:

        }

        // _welcome
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', '_welcome');
            }

            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\WelcomeController::indexAction',  '_route' => '_welcome',);
        }

        if (0 === strpos($pathinfo, '/demo')) {
            if (0 === strpos($pathinfo, '/demo/secured')) {
                if (0 === strpos($pathinfo, '/demo/secured/log')) {
                    if (0 === strpos($pathinfo, '/demo/secured/login')) {
                        // _demo_login
                        if ($pathinfo === '/demo/secured/login') {
                            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::loginAction',  '_route' => '_demo_login',);
                        }

                        // _security_check
                        if ($pathinfo === '/demo/secured/login_check') {
                            return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::securityCheckAction',  '_route' => '_security_check',);
                        }

                    }

                    // _demo_logout
                    if ($pathinfo === '/demo/secured/logout') {
                        return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::logoutAction',  '_route' => '_demo_logout',);
                    }

                }

                if (0 === strpos($pathinfo, '/demo/secured/hello')) {
                    // acme_demo_secured_hello
                    if ($pathinfo === '/demo/secured/hello') {
                        return array (  'name' => 'World',  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',  '_route' => 'acme_demo_secured_hello',);
                    }

                    // _demo_secured_hello
                    if (preg_match('#^/demo/secured/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_secured_hello')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloAction',));
                    }

                    // _demo_secured_hello_admin
                    if (0 === strpos($pathinfo, '/demo/secured/hello/admin') && preg_match('#^/demo/secured/hello/admin/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_secured_hello_admin')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\SecuredController::helloadminAction',));
                    }

                }

            }

            // _demo
            if (rtrim($pathinfo, '/') === '/demo') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', '_demo');
                }

                return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::indexAction',  '_route' => '_demo',);
            }

            // _demo_hello
            if (0 === strpos($pathinfo, '/demo/hello') && preg_match('#^/demo/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_demo_hello')), array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::helloAction',));
            }

            // _demo_contact
            if ($pathinfo === '/demo/contact') {
                return array (  '_controller' => 'Acme\\DemoBundle\\Controller\\DemoController::contactAction',  '_route' => '_demo_contact',);
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
