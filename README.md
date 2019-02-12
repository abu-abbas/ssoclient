# ssoclient
small library to connect sso
```php
require_once 'vendor/autoload.php';
use SsoClient\Client;

# for register new app
echo Client::registerApp('YOUR_APPNAME', 'YOUR_APPKEY');

# for authenticate token
$credentials = [
    'token' => '',
    'appid' => 'YOUR_APPID',
    'appsecret' => 'YOUR_APPSECRET'
];
Client::authenticateSso($credentials);

# for redirect to sso login page
$credentials = [
    'appid' => 'YOUR_APPID',
    'appsecret' => 'YOUR_APPSECRET',
    'origin' => 'https://your-website.com',
];
Client::redirectToSso($credentials);
```

### Installing ssoclient
The recommended way to install ssoclient is through [Composer](http://getcomposer.org/).
```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of ssoclient:
```bash
composer init
composer require bows/ssoclient
```

Then create an index.php file that will load the autoloader:
```php
require 'vendor/autoload.php';
```

