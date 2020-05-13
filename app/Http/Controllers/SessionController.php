<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function GetUserIP()
  {
      // Get real visitor IP behind CloudFlare network
      if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
      }
      $client = @$_SERVER['HTTP_CLIENT_IP'];
      $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
      $remote = $_SERVER['REMOTE_ADDR'];

      if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
      } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
      } else {
        $ip = $remote;
      }
      return $ip;
   }

    public function GetRealAgent()
    {
      $user_agent = $_SERVER['HTTP_USER_AGENT'];
      $content_nav['name'] = 'Unknown';

      if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) {

        $content_nav['name'] = 'Opera';

        if (strpos($user_agent, 'OPR/')) {
          $content_nav['reel_name'] = 'OPR/';
        } else {
          $content_nav['reel_name'] = 'Opera';
        }

      } elseif (strpos($user_agent, 'Edge')) {
        $content_nav['name'] = $content_nav['reel_name'] = 'Edge';
      } elseif (strpos($user_agent, 'Chrome')) $content_nav['name'] = $content_nav['reel_name'] = 'Chrome';
      elseif (strpos($user_agent, 'Safari')) $content_nav['name'] = $content_nav['reel_name'] = 'Safari';
      elseif (strpos($user_agent, 'Firefox')) $content_nav['name'] = $content_nav['reel_name'] = 'Firefox';
      elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7') || strpos($user_agent, 'Trident/7.0; rv:')) {
        $content_nav['name'] = 'Internet Explorer';

        if (strpos($user_agent, 'Trident/7.0; rv:')) {
          $content_nav['reel_name'] = 'Trident/7.0; rv:';
        } elseif (strpos($user_agent, 'Trident/7')) {
          $content_nav['reel_name'] = 'Trident/7';
        } else {
          $content_nav['reel_name'] = 'Opera';
        }

      }

      $pattern = '#' . $content_nav['reel_name'] . '\/*([0-9\.]*)#';

      $matches = array();

      if (preg_match($pattern, $user_agent, $matches)) {

        $content_nav['version'] = $matches[1];
        return $content_nav;

      }

      return array('name' => $content_nav['name'], 'version' => 'Inconnu');
    }
}
