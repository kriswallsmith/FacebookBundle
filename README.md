Installation
------------

  1. Add this bundle and the Facebook PHP SDK to your project as Git submodules:

        $ git submodule add git://github.com/kriswallsmith/FacebookBundle.git src/Bundle/FacebookBundle
        $ git submodule add git://github.com/facebook/php-sdk.git src/vendor/Facebook

  2. Add the `Facebook` class to your project's autoloader bootstrap script:

        // src/autoload.php
        spl_autoload_register(function($class) {
            if ('Facebook' == $class) {
                require_once __DIR__.'/vendor/Facebook/src/facebook.php';
                return true;
            }
        });

  3. Add this bundle to your application's kernel:

        // application/ApplicationKernel.php
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new Bundle\FacebookBundle\Bundle(),
                // ...
            );

            if ($this->isDebug())
            {
                $bundles[] = new Symfony\Framework\ProfilerBundle\Bundle();
            }

            return $bundles;
        }

  4. Configure the `facebook` service:

        # application/config/config.yml
        facebook.api:
          app_id: ~
          secret: ~
          cookie: true
          domain: ~
