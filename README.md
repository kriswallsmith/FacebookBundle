Installation
============

  1. Add this bundle to your src/ dir and the Facebook PHP SDK to your vendor/ dir:

          $ git submodule add git://github.com/FriendsOfSymfony/FacebookBundle.git src/FOS/FacebookBundle
          $ git submodule add git://github.com/facebook/php-sdk.git vendor/facebook

  2. Add the FOS namespace to your autoloader:

          // app/autoload.php
          $loader->registerNamespaces(array(
                'FOS' => __DIR__.'/../src',
                // your other namespaces
          ));

  3. Add this bundle to your application's kernel:

          // app/ApplicationKernel.php
          public function registerBundles()
          {
              return array(
                  // ...
                  new FOS\FacebookBundle\FOSFacebookBundle(),
                  // ...
              );
          }

  4. Configure the `facebook` service in your config:

          # application/config/config.yml
          fos_facebook:
              file:   %kernel.root_dir%/../vendor/facebook/src/facebook.php
              alias:  facebook
              app_id: 123456879
              secret: s3cr3t
              cookie: true

          # application/config/config.xml
          <fos_facebook:api
              file="%kernel.root_dir%/../vendor/facebook/src/facebook.php"
              alias="facebook"
              app_id="123456879"
              secret="s3cr3t"
              cookie="true"
          />

     If you do not include a `file` value in the config you will have to
     configure your application to autoload the `Facebook` class.

  5. Add this configuration if you want to use the `security component`:

          # application/config/config.yml
          security:
              factories:
                  - "%kernel.root_dir%/../src/FOS/FacebookBundle/Resources/config/security_factories.xml"

              providers:
                  fos_facebook:
                    id: fos_facebook.auth

              firewalls:
                  public:
                      pattern:   /.*
                      fos_facebook:  true
                      anonymous: true

                  only_facebook: # with facebook entry point (redirect to the facebook login url)
                      pattern:   /only_facebook/.*
                      fos_facebook:  true

              access_control:
                  - { path: /.*, role: [ROLE_USER, IS_AUTHENTICATED_ANONYMOUSLY] }

  6. Optionally define a custom user provider class and use it as the provider or define path for login

          # application/config/config.yml
          security:
              factories:
                    - "%kernel.root_dir%/../src/FOS/FacebookBundle/Resources/config/security_factories.xml"

              providers:
                  fos_facebook:
                    id: fos_facebook.user_provider

              firewalls:
                  public:
                      pattern:   /.*
                      fos_facebook:
                          login_path: /facebook
                          check_path: /facebook-check
                          default_target_path: /facebook
                          provider: fos_facebook
                      anonymous: true

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

Example Customer User Provider using the FOS\UserBundle
-------------------------------------------------------

This requires adding a getFacebookId() and setFBData() method to the User model.

    <?php

    namespace Foo\BarBundle\Security\User\Provider;

    use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
    use Symfony\Component\Security\Core\Exception\UnsupportedAccountException;
    use Symfony\Component\Security\Core\User\UserProviderInterface;
    use Symfony\Component\Security\Core\User\AccountInterface;
    use \Facebook;
    use \FacebookApiException;

    class FacebookProvider implements UserProviderInterface
    {
        /**
         * @var \Facebook
         */
        protected $facebook;
        protected $userManager;
        protected $validator;

        public function __construct(Facebook $facebook, $userManager, $validator)
        {
            $this->facebook = $facebook;
            $this->userManager = $userManager;
            $this->validator = $validator;
        }

        public function supportsClass($class)
        {
            return $this->userManager->supportsClass($class);
        }

        public function findUserByFbId($fbId)
        {
            return $this->userManager->findUserBy(array('facebookID' => $fbId));
        }

        public function loadUserByUsername($username)
        {
            $user = $this->findUserByFbId($username);

            try {
                $fbdata = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $fbdata = null;
            }

            if (!empty($fbdata)) {
                if (empty($user)) {
                    $user = $this->userManager->createUser();
                    $user->setEnabled(true);
                    $user->setPassword('');
                    $user->setAlgorithm('');
                }

                // TODO use http://developers.facebook.com/docs/api/realtime
                $user->setFBData($fbdata);

                if (count($this->validator->validate($user, 'Facebook'))) {
                    // TODO: the user was found obviously, but doesnt match our expectations, do something smart
                    throw new UsernameNotFoundException('The facebook user could not be stored');
                }
                $this->userManager->updateUser($user);
            }

            if (empty($user)) {
                throw new UsernameNotFoundException('The user is not authenticated on facebook');
            }

            return $user;
        }

        public function loadUserByAccount(AccountInterface $account)
        {
            if (!$this->supportsClass(get_class($account)) || !$account->getFacebookId()) {
                throw new UnsupportedAccountException(sprintf('Instances of "%s" are not supported.', get_class($account)));
            }

            return $this->loadUserByUsername($account->getFacebookId());
        }
    }
