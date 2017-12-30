<?php

namespace Drupal\bt_basic_page\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;

class BasicPageBreadcrumbBuilder implements BreadcrumbBuilderInterface {

    /**
     * @var AccountInterface
     */
    protected $account;

    /**
     * The routes that will change their breadcrumbs.
     */
    private $routes = array(
        'page_manager.page_view_bt_create_basic_page',
    );

    /**
     * Class constructor.
     */
    public function __construct(AccountProxy $current_user) {
        $user_id = $current_user->id();
        $user_account = User::load($user_id);
        $this->account = $user_account;
    }

    /**
    * {@inheritdoc}
    */
    public function applies(RouteMatchInterface $attributes) {
        $match = $this->routes;
        if (in_array($attributes->getRouteName(),$match)) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
    * {@inheritdoc}
    */
    public function build(RouteMatchInterface $route_match) {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->addCacheContexts(["url"]);
        $site_name = \Drupal::config('system.site')->get('name');
        $breadcrumb->addLink(Link::createFromRoute($site_name, 'page_manager.page_view_app_app-panels_variant-0'));
        $breadcrumb->addLink(Link::createFromRoute('Website', 'page_manager.page_view_app_website_app_website-panels_variant-0'));
        $breadcrumb->addLink(Link::createFromRoute('Content', 'page_manager.page_view_app_website_content_app_website_content-panels_variant-0'));
        $breadcrumb->addLink(Link::createFromRoute('Create Content', 'node.add_page'));

        return $breadcrumb;
    }
}