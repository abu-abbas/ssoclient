<?php 

namespace SsoClient;

use SsoClient\CurlLibs;

/**
*  This is the client class.
*
*  It's responsible for handling client function
*
*  @author abuabbas
*/
class Client 
{
   /**
    * This function for register sso client
    *
    * @param string $appName
    * @param string $secretKey
    * @return object
    */
   public static function registerApp(string $appName, string $secretKey)
   {
      try {
         $curl = new CurlLibs();
         $data = [
               'appname' => $appName,
               'appsecret' => $secretKey
         ];
         $res = $curl->setOptions()->request('GET', 'getAppId', $data)->run();
         return json_decode($res);
      } catch (\RuntimeException $e) {
         die(sprintf('Http error %s with code %d', $e->getMessage(), $e->getCode()));
      }
   }

   /**
    * This function for authenticate token
    *
    * @param array $credentials
    * @return object
    */
   public static function authenticateSso(array $credentials)
   {
      try {
         $curl = new CurlLibs();
         $data = [
            'token' => $credentials['token'],
            'appid' => $credentials['appid'],
            'appsecret' => $credentials['appsecret'],
         ];
         $res = $curl->setOptions()->request('GET', 'validToken', $data)->run();
         return json_decode($res);
      } catch (\RuntimeException $e) {
         die(sprintf('Http error %s with code %d', $e->getMessage(), $e->getCode()));
      }
   }

   /**
    * This function for rediret to sso login page
    *
    * @param array $credentials
    * @return void
    */
   public static function redirectToSso(array $credentials)
   {
      $credentials['origin'] = urlencode($credentials['origin']);
      $query = http_build_query($credentials);
      $linkTo = sprintf('%s/%s?%s', getenv('API_ENDPOINT'), 'login.php', $query);
      header("location: $linkTo");
   }
}