# AnchovyCURLBundle #

This bundle provides basic interfaces service for cURL php wrapper. CURLBundle is simple, basic and allow developer to extend it to another level on top of Symfony2.

CURLBundle is open source and free to use, I would however be extremely grateful if you can provided constructive feedback from your experience of using it to me via my GitHub account: iman

Please visit [imanpage.com](http://imanpage.com) for more details.


## AnchovyCURLBundle  Continuous Integration Build Status ##

[![Build Status](https://secure.travis-ci.org/Iman/AnchovyCURLBundle.png)](http://travis-ci.org/Iman/AnchovyCURLBundle)


## Installation ##

Put the AnchovyCURLBundle (http://github.com/Iman/AnchovyCURLBundle.git) library into the deps file:

	[AnchovyCURLBundle]
		git=https://github.com/Iman/AnchovyCURLBundle.git
		target=/bundles/Anchovy/CURLBundle

## Using submodules ##

 If you prefer instead to use git submodules, the run the following:

        $ git submodule add https://github.com/Iman/AnchovyCURLBundle.git vendor/bundles/Anchovy/CURLBundle
        $ git submodule update --init

Register the bundle and library namespaces in the `app/autoload.php` file:

    $loader->registerNamespaces(array(
        ...
      'Anchovy'          => __DIR__.'/../vendor/bundles',
        ...
    ));

Add the AnchovyCURLBundle to your application's kernel:

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Anchovy\CURLBundle\AnchovyCURLBundle(),
            ...
        );

## Usage ##

	// Simple call:

	    public function indexAction() {

                    $this->get('anchovy.curl')->setURL('http://localhost')->execute();

		}

	// Adding cURL option:

            $this->get('anchovy.curl')->setURL('http://localhost')->setOption('CURLOPT_NOBODY', FALSE)->execute();

	// Setting cURL opttions as array:

		    $options = array(
				'CURLOPT_NOBODY'=> TRUE,
				'CURLOPT_PROXY' => 'http://123.45.xxx.xxx',
				'CURLOPT_PROXYPORT' => '9090',
				'CURLOPT_PROXYUSERPWD' => 'dummyUsername:dummyPassword'
			);

            $this->get('anchovy.curl')->setURL('http://localhost')->setOptions($options)->execute();

	// Getting cURL info:

	      $this->get('anchovy.curl')->setURL('http://localhost')->setOption('CURLOPT_NOBODY', TRUE)->getInfo();

        // OR

              $curl = $this->get('anchovy.curl')->setURL('http://localhost');

              $curl->execute();  //To execute

              $curl->getInfo(); // To get the CURL info



        // Dump data

	var_dump($curl);

## Test ##

The AnchovyCURLBundle is unit tested by PHPUnit.

Rename the phpunit.xml.dist inside the AnchovyCURLBundle to phpunit.xml and now you can execute the test suite from inside the bundle:

``` bash
$ phpunit
```

### Functional Test ###

Add the bellow code into phpunit.xml

            <testsuites>
                    <testsuite name="CURLBundle test suite">
                    ....
                        <directory>./Tests/Functional</directory>
                    ....
                    </testsuite>
            </testsuites>

And in your routing.yml or routing_test/dev.yml

        _anchovy_curl:
            pattern:  /anchovy_curl
            defaults: { _controller: AnchovyCURLBundle:Curl:index }


## My twitter account ##

If you want to keep up with updates, [follow me on twitter](http://twitter.com/imanpage).

## Bug tracking ##

This bundle uses [GitHub issues](https://github.com/Iman/AnchovyCURLBundle/issues).
If you have found bug, please create an issue.

## License ##

License can be found [here](https://github.com/Iman/AnchovyCURLBundle/blob/master/Resources/meta/LICENSE).

## Author ##

The bundle created by [Iman Samizadeh](http://imanpage.com).
