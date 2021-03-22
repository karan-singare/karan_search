<?php

namespace Drupal\karan_search\Controller;
use Drupal\Core\Controller\ControllerBase;

/**
 *
 */
class SearchTutorsPageController extends ControllerBase
{

  public function searchTutorsPage()
  {
    $current_user = \Drupal::currentUser();
    // $user = \Drupal\user\Entity\User::load($current_user->id());
    $user_id = $current_user->id();

    // // or just
    // $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $data = [
      'name' => 'Karan Singh Singare',
      'email' => 'karansingare@gmail.com',
    ];
    return [
      '#title' => 'The tutors search page',
      '#theme' => 'search_tutors_page',
      '#items' => $data,
      '#user_id' => $user_id,
    ];
  }

  public function searchInstitutesPage()
  {
    return [
      '#title' => 'The basic page',
      '#theme' => 'search_institutes_page',
      '#items' => 'This is our Search Institutes Page.',
    ];
  }
}
