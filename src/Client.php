<?php 

namespace SsoClient;

use SsoClient\CurlLibs;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author abuabbas
*/
class Client 
{
   /**
    * Undocumented function
    *
    * @param string $appName
    * @param string $secretKey
    * @return void
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
    * Undocumented function
    *
    * @param array $credentials
    * @return void
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
    * Undocumented function
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