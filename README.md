Installation
============

  1. Add this bundle and the Facebook PHP SDK to your project as Git submodules:

          $ git submodule add git://github.com/kriswallsmith/FacebookBundle.git src/Bundle/Kris/FacebookBundle
          $ git submodule add git://github.com/facebook/php-sdk.git src/vendor/facebook

  2. Add the `Facebook` class to your project's autoloader bootstrap script:

          // src/autoload.php
          spl_autoload_register(function($class) {
              if ('Facebook' == $class) {
                  require_once __DIR__.'/vendor/facebook/src/facebook.php';
                  return true;
              }
          });

  3. Add this bundle to your application's kernel:

          // application/ApplicationKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new Bundle\Kris\FacebookBundle\KrisFacebookBundle(),
                  // ...
              );
          }

  4. Configure the `facebook` service in your config:

          # application/config/config.yml
          facebook.api:
            alias: facebook
            app_id: 123456879
            secret: s3cr3t
            cookie: true

          # application/config/config.xml
          <facebook:api
            alias="facebook"
            app_id="123456879"
            secret="s3cr3t"
            cookie="true"
          />

Setting up the JavaScript SDK
-----------------------------

A templating helper is included for loading the Facebook JavaScript SDK and
initializing it with parameters from your service container. To setup the
Facebook JavaScript environment, add the following to your layout just after
the opening `body` tag:

      <body>
        <?php echo $view['facebook']->initialize(array('xfbml' => true)) ?>

If you will be adding XFBML markup to your site you must also declare the
namespace, perhaps in the opening `html` tag:

      <html xmlns:fb="http://www.facebook.com/2008/fbml">
