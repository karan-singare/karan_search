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
 *   id = "subscriptions_rest_resource",
 *   label = @Translation("Subscriptions rest resource"),
 *   uri_paths = {
 *     "canonical" = "/subscriptions",
 *     "canonical" = "/subscriptions",
 *     "create" = "/subscriptions",
 *     "canonical" = "/subscriptions"
 *   }
 * )
 */
class SubscriptionsRestResource extends ResourceBase {

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

        // $payload = $message;

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
        // $payload = $this->insert_record($payload);

        // $payload = [
        //   'response' => "Request is coming",
        // ];
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

        return new ModifiedResourceResponse($payload, 204);
    }

    private function get_connection() {
      return  Database::getConnection();
    }

    private function get_record() {
      $response = [];
      $connection = $this->get_connection();

      $query = $connection->select('subscriptions', 's')
        ->fields('s')
        ->condition('s.user_id', $this->currentUser->id(), '=');

      $data = $query->execute();
      $results = $data->fetchAll(\PDO::FETCH_ASSOC);
      return $results;

    }

    private function insert_record($payload) {
      $connection = $this->get_connection();
      $query = $connection->insert('subscriptions')
        ->fields([
          'user_id' => $payload['user_id'],
          'tutor_id' => $payload['tutor_id'],
          'institute_id' => $payload['institute_id'],
        ])
        ->execute();

      if ($query) {
        return $payload;
      }
      $message = [
        'message' => 'Some error ocuured while inserting the record"',
      ];
      return $message;
    }

}
