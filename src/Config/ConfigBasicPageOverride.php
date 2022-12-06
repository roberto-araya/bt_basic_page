<?php

namespace Drupal\bt_basic_page\Config;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Config\StorageInterface;

/**
 * Example configuration override.
 */
class ConfigBasicPageOverride implements ConfigFactoryOverrideInterface {

  /**
   * Config Factory object.
   *
   * @var configFactory
   */
  private $configFactory;

  /**
   * {@inheritdoc}
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public function loadOverrides($names) {
    $overrides = [];

    if (in_array('workflows.workflow.editorial', $names)) {
      $workflow = $this->configFactory->get('workflows.workflow.editorial');
      $entity_types_values = $workflow->get('type_settings.entity_types');
      if (is_array($entity_types_values) && array_key_exists('node', $entity_types_values)) {
        $entity_types_values['node'][] = 'bt_basic_page';
        $overrides['workflows.workflow.editorial']['type_settings']['entity_types']['node'] = $entity_types_values['node'];
      }
      else {
        $values = ['bt_basic_page'];
        $overrides['workflows.workflow.editorial']['type_settings']['entity_types']['node'] = $values;
      }
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
