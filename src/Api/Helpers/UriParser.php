<?php
/**
 * Created by PhpStorm.
 * User: Thomas Merlin
 * Email: thomas.merlin@fidesio.com
 * Date: 09/03/2018
 * Time: 23:27
 */

namespace App\Api\Helpers;

/**
 * Class UriParser
 * @package App\Api\Helpers
 */
class UriParser
{
    /**
     * Parse a given URI and returns only the parameters.
     *
     * @param string $uri
     *
     * @return array
     */
    public function getUriParameters(string $uri) {
        $parameters = [];
        $parsedUrl = parse_url($uri);

        if (isset($parsedUrl["query"])) {
            $uriParameters = explode("&", $parsedUrl["query"]);

            foreach ($uriParameters as $uriParameter) {
                list($key, $value) = explode("=", $uriParameter);
                $parameters[$key] = $value;
            }
        }

        return $parameters;
    }
}