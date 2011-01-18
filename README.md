Installation
============

  1. Add this bundle and the Facebook PHP SDK to your project as Git submodules:

          $ git submodule add git://github.com/FriendsOfSymfony/FacebookBundle.git src/Bundle/FOS/FacebookBundle
          $ git submodule add git://github.com/facebook/php-sdk.git src/vendor/facebook

  2. Add this bundle to your application's kernel:

          // application/ApplicationKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new Bundle\FOS\FacebookBundle\FOSFacebookBundle(),
                  // ...
              );
          }

  3. Configure the `facebook` service in your config:

          # application/config/config.yml
          fos_facebook.api:
              file:   %kernel.root_dir%/../src/vendor/facebook/src/facebook.php
              alias:  facebook
              app_id: 123456879
              secret: s3cr3t
              cookie: true

          # application/config/config.xml
          <fos_facebook:api
              file="%kernel.root_dir%/../src/vendor/facebook/src/facebook.php"
              alias="facebook"
              app_id="123456879"
              secret="s3cr3t"
              cookie="true"
          />

     If you do not include a `file` value in the config you will have to
     configure your application to autoload the `Facebook` class.

Setting up the JavaScript SDK
-----------------------------

A templating helper is included for loading the Facebook JavaScript SDK and
initializing it with parameters from your service container. To setup the
Facebook JavaScript environment, add the following to your layout just after
the opening `body` tag:

      <body>
          <!-- inside a php template -->
          <?php echo $view['facebook']->initialize(array('xfbml' => true)) ?>
          <!-- inside a twig template -->
          {{ facebook_initialize({'xfbml': true}) }}

If you will be adding XFBML markup to your site you may also declare the
namespace, perhaps in the opening `html` tag:

      <html xmlns:fb="http://www.facebook.com/2008/fbml">

Include the login button in your templates
------------------------------------------

Just add the following code in one of your templates:

    <!-- inside a php template -->
    <?php echo $view['facebook']->loginButton(array('autologoutlink' => true)) ?>
    <!-- inside a twig template -->
    {{ facebook_login_button({'autologoutlink': true}) }}
