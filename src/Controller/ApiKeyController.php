<?php

namespace Drupal\apikey\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller class will return JSON data.
 */
class ApiKeyController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function nodejsonresponse($key = NULL, NodeInterface $nid = NULL, Request $request) {
    $site_config = $this->config('system.site');
    if (($key == $site_config->get('siteapikey')) && !empty($nid) && ($nid->get('type')->target_id == 'page')) {
      $json_array = [];
      foreach ($nid as $key => $value) {
        $json_array['data'][] = [
          $key => $value->getValue(),
        ];
      }
      return new JsonResponse($json_array);  
    }
    else {
      return new RedirectResponse('/system/403');
    }
  }
}
