<?php

/*
 * This file is part of the AnchovyCURLBundle package.
 *
 * (c)  Iman Samizadeh <http://github.com/Iman/AnchovyCURLBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package       Anchovy
 * @subpackage    CURLBundle
 * @author        Iman Samizadeh <iman@imanpage.com>  http://imanpage.com
 */

namespace Anchovy\CURLBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CurlController extends Controller {

    public function indexAction() {

        $curl = $this->get('anchovy.curl')
                ->setURL('http://localhost')
                ->setOption('CURLOPT_NOBODY', TRUE)
                ->execute()
                ->getInfo();

        return new Response("<!DOCTYPE html><html><head><title>Anchovy CURL test controller</title></head><body><h1>HTTP Code: {$curl['http_code']}</h1></body></html>");
    }

}

?>
