<?php

/*
 * This file is part of the CURLBundle package.
 *
 * (c)  Iman Samizadeh <https://github.com/Iman/CURLBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package       CURLBundle
 * @author        Iman Samizadeh <iman@imanpage.com>  http://imanpage.com
 */

namespace Anchovy\CURLBundle\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CurlControllerTest extends WebTestCase {

    public function testIndex() {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Anchovy_curl');

        $this->assertTrue($crawler->filter('html:contains("HTTP Code: 200")')->count() > 0);
    }

}

?>
