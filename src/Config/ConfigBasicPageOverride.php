<?php

namespace Drupal\bt_basic_page\Config;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * Example configuration override.
 */
class ConfigBasicPageOverride implements ConfigFactoryOverrideInterface {

  private $createContent;
  private $deleteContent;
  private $deleteOwnContent;
  private $editContent;
  private $viewsAdminContent;
  private $viewsFullAdminContent;

  public function __construct(ConfigFactory $configFactory) {

    $this->createContent = $configFactory->get('user.role.bt_create_content');
    $this->deleteContent = $configFactory->get('user.role.bt_delete_content');
    $this->deleteOwnContent = $configFactory->get('user.role.bt_delete_own_content');
    $this->editContent = $configFactory->get('user.role.bt_edit_publish_content');
    $this->viewsAdminContent = $configFactory->get('views.view.bt_admin_content');
    $this->viewsFullAdminContent = $configFactory->get('views.view.bt_full_admin_content');
  }

  public function loadOverrides($names) {
    $overrides = array();

    // Add article permissions to bt_create_content role.
    if (in_array('user.role.bt_create_content', $names)) {
      $basic_page_permissions = [
        'create bt_basic_page content',
        'edit own bt_basic_page content',
        'revert bt_basic_page revisions',
        'view bt_basic_page revisions',
      ];
      $content_role = $this->createContent;
      $permissions = array_merge($content_role->get('permissions'), $basic_page_permissions);
      $overrides['user.role.bt_create_content']['permissions'] = $permissions;
    }
    // Add article permissions to bt_delete_content role.
    if (in_array('user.role.bt_delete_content', $names)) {
      $basic_page_permissions = [
        'delete any bt_basic_page content',
        'delete bt_basic_page revisions',
      ];
      $content_role = $this->deleteContent;
      $permissions = array_merge($content_role->get('permissions'), $basic_page_permissions);
      $overrides['user.role.bt_delete_content']['permissions'] = $permissions;
    }
    // Add article permissions to bt_delete_own_content role.
    if (in_array('user.role.bt_delete_own_content', $names)) {
      $basic_page_permissions = [
        'delete own bt_basic_page content',
      ];
      $content_role = $this->deleteOwnContent;
      $permissions = array_merge($content_role->get('permissions'), $basic_page_permissions);
      $overrides['user.role.bt_delete_own_content']['permissions'] = $permissions;
    }
    // Add article permissions to bt_edit_publish_content role.
    if (in_array('user.role.bt_edit_publish_content', $names)) {
      $basic_page_permissions = [
        'edit any bt_basic_page content',
      ];
      $content_role = $this->editContent;
      $permissions = array_merge($content_role->get('permissions'), $basic_page_permissions);
      $overrides['user.role.bt_edit_publish_content']['permissions'] = $permissions;
    }
    $basic_page_values = [
      'bt_basic_page' => 'bt_basic_page',
    ];
    // Add article filter values to views.view.bt_admin_content view.
    if (in_array('views.view.bt_admin_content', $names)) {
      $views = $this->viewsAdminContent;
      $filter_values = $views->get('display.default.display_options.filters.type.value');
      $values = array_merge($filter_values, $basic_page_values);
      $overrides['views.view.bt_admin_content']['display']['default']['display_options']['filters']['type']['value'] = $values;
      $overrides['views.view.bt_admin_content']['display']['default']['display_options']['filters']['type_expose']['value'] = $values;
    }
    // Add article filter values to views.view.bt_full_admin_content view.
    if (in_array('views.view.bt_full_admin_content', $names)) {
      $views = $this->viewsFullAdminContent;
      $filter_values = $views->get('display.default.display_options.filters.type.value');
      $values = array_merge($filter_values, $basic_page_values);
      $overrides['views.view.bt_full_admin_content']['display']['default']['display_options']['filters']['type']['value'] = $values;
      $overrides['views.view.bt_full_admin_content']['display']['default']['display_options']['filters']['type_expose']['value'] = $values;
    }

    return $overrides;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheSuffix() {
    return 'ConfigBasicPageOverride';
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata($name) {
    return new CacheableMetadata();
  }

  /**
   * {@inheritdoc}
   */
  public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
    return NULL;
  }

}
