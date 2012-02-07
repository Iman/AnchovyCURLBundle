# AnchovyCURLBundle #

## About ##

This bundle provides basic interfaces service for cURL php wrapper. CURLBundle is simple, basic and allow develpper to extend it to onother level on top of Symfony2. 

CURLBundle is open source and free to use, I would however be extremely grateful if you can provided constructive feedback from your experience of using it to me via my GitHub account: iman

Please visit [imanpage.com](http://imanpage.com) for more details.

## Installation ##

Put the AnchovyCURLBundle(https://github.com/Iman/CURLBundle) library into the deps file:

	[AnchovyCURLBundle]
		git=https://github.com/Iman/AnchovyCURLBundle.git
		target=/bundles/Anchovy/CURLBundle
		
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
	   
	Simple call: 
	
	    public function indexAction() {

			$this->get('anchovy.curl')->setURL('http://localhost')->execute();
			
		}

	Adding cURL option:

            $this->get('anchovy.curl')->setURL('http://localhost')->setOption('CURLOPT_NOBODY', TRUE)->execute();

	Setting cURL opttions as array:

		    $options = array(
				'CURLOPT_NOBODY'=> TRUE,
				'CURLOPT_PROXY' => 'http://123.45.xxx.xxx',
				'CURLOPT_PROXYPORT' => '9090',
				'CURLOPT_PROXYUSERPWD' => 'dummyUsername:dummyPassword'
			);
			
            $this->get('anchovy.curl')->setURL('http://localhost')->setOptions($options)->execute();

	Getting cURL info:
	
	        $this->get('anchovy.curl')->setURL('http://localhost')->setOption('CURLOPT_NOBODY', TRUE)->execute()->getInfo();

## My twitter account ##

If you want to keep up with updates, [follow me on twitter](http://twitter.com/imanpage).

## Bug tracking ## 

This bundle uses [GitHub issues](https://github.com/Iman/CURLBundle/issues).
If you have found bug, please create an issue.

## License ##

License can be found [here](https://github.com/Iman/CURLBundle/Resources/meta/LICENSE).

## Author ##

The bundle created by [Iman Samizadeh](http://imanpage.com).
