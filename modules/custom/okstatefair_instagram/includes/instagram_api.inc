<?php
/**
 * @file istagram api
 */

/**
 * Class Instagram api
 */
class InstagramApi {

  const INSTAGRAM_API_URL = 'https://api.instagram.com/v1/';

  protected $client_id;

  /**
   * @param $id
   * Client_id - register new http://instagram.com/developer/clients/register/
   */
  public function __construct($id) {
    $this->client_id = $id;
  }

  /**
   * Return recent media by tag
   *
   * @param string $tag
   * @param integer $max_tag_id
   * @param integer $min_tag_id
   * @return bool|mixed
   */
  public function get_tag_media_recent($tag, $max_tag_id = NULL, $min_tag_id = NULL) {
    $params = array();
    if(isset($max_tag_id)) {
      $params['max_tag_id'] = $max_tag_id;
    }
    if(isset($min_tag_id)) {
      $params['min_tag_id'] = $min_tag_id;
    }

    return $this->call_request('tags/' . $tag . '/media/recent', $params);
  }


  protected function call_request($method_path, $params) {
    $options = array(
      'headers' => array('Accept' => 'application/json'),
      'method' => 'GET',
    );
    $params['client_id'] = $this->client_id;

    $full_url = url(INSTAGRAM_API_URL . $method_path, array('query' => $params));

    $response_result = drupal_http_request($full_url, $options);

    $result = FALSE;

    if($response_result->code == 200) {
      try {
        $result = json_decode($response_result->data);
      } catch (Exception $e) {
        watchdog('instagram', 'Error parsing response');
      }
    } else {
      watchdog('instagram', 'Http request error: @message', array('@message' => $response_result->error));
    }

    return $result;
  }

}