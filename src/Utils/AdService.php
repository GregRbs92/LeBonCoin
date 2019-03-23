<?php

namespace App\Utils;

use App\Entity\Ad;

class AdService
{
    /**
     * Call the different setters of the ad corresponding to the keys in the request body
     *
     * @param array $body
     * @param Ad $ad
     * @return Ad
     */
    public function setFields(array &$body, Ad $ad)
    {
        // For each entry in the request's body, try to call the corresponding setter in the Ad instance
        foreach ($body as $key => $value) {
            $methodName = 'set' . ucfirst($key);
            $method = [$ad, $methodName];
            if (is_callable($method)) {
                call_user_func($method, $value);
            }
        }

        return $ad;
    }
}
