<?php

namespace Drupal\karan_search\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Database\Database;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "subscriptions_meta_rest_resource",
 *   label = @Translation("Subscriptions meta rest resource"),
 *   uri_paths = {
 *     "canonical" = "/subscriptions-meta",
 *     "canonical" = "/subscriptions-meta",
 *     "create" = "/subscriptions-meta",
 *     "canonical" = "/subscriptions-meta"
 *   }
 * )
 */
class SubscriptionsMetaRestResource extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->logger = $container->get('logger.factory')->get('karan_search');
    $instance->currentUser = $container->get('current_user');
    return $instance;
  }

    /**
     * Responds to GET requests.
     *
     * @param string $payload
     *
     * @return \Drupal\rest\ResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function get($payload) {

        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }

        $payload = $this->get_record();

        return new ResourceResponse($payload, 200);
    }

    /**
     * Responds to PUT requests.
     *
     * @param string $payload
     *
     * @return \Drupal\rest\ModifiedResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function put($payload) {

        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }
        $payload = $this->update_record($payload);
        return new ModifiedResourceResponse($payload, 201);
    }

    /**
     * Responds to POST requests.
     *
     * @param string $payload
     *
     * @return \Drupal\rest\ModifiedResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function post($payload) {

        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }
        $payload = $this->insert_record($payload);

        return new ModifiedResourceResponse($payload, 200);
    }

    /**
     * Responds to PATCH requests.
     *
     * @param string $payload
     *
     * @return \Drupal\rest\ModifiedResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function patch($payload) {

        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }
        $payload = $this->update_record();
        return new ModifiedResourceResponse($payload, 204);
    }

    private function get_connection() {
      return  Database::getConnection();
    }

    private function get_record() {
      $response = [];
      $connection = $this->get_connection();

      $query = $connection->select('subscriptions_meta', 's')
        ->fields('s')
        ->condition('s.user_id', $this->currentUser->id(), '=');

      $data = $query->execute();
      $results = $data->fetchAll(\PDO::FETCH_ASSOC);
      return $results[0];

    }

    private function insert_record($payload) {
      $connection = $this->get_connection();
      $fields = [];

      foreach ($payload as $key => $value) {
        $fields["$key"] = $value;
      }

      $query = $connection->insert('subscriptions_meta')
        ->fields($fields)
        ->execute();

      if ($query) {
        return $payload;
      }
      $message = [
        'message' => 'Some error ocuured while inserting the record"',
      ];
      return $message;
    }
    /**
     * Helper method for patch requests
     */
    private function update_record($payload) {
      $connection = $this->get_connection();
      $fields = [];

      foreach ($payload as $key => $value) {
        $fields["$key"] = $value;
      }

      $query = $connection->update('subscriptions_meta')
        ->fields($fields)
        ->condition('user_id', $this->currentUser->id(), '=')
        ->execute();

      if ($query) {
        return $payload;
      }
      $message = [
        'message' => 'Some error ocuured while inserting the record',
      ];
      return $message;
    }



}
