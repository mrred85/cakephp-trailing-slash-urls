<?php

/**
 * TrailingSlashUrl Helper
 *
 * @link https://github.com/mrred85/cakephp-trailing-slash-urls
 * @copyright 2016 - present Victor Rosu. All rights reserved.
 * @license Licensed under the MIT License.
 */

namespace App\View\Helper;

use Cake\View\Helper\UrlHelper;

/**
 * @package App\View\Helper
 */
class TrailingSlashUrlHelper extends UrlHelper
{
    /**
     * @inheritdoc
     * @param string|array|null $url The URL
     * @param array|bool $options URL options
     * @return string
     */
    public function build($url = null, $options = false): string
    {
        // No query and fragment in URL
        $justBaseURL = false;
        if (isset($options['justBase']) && $options['justBase'] === true) {
            $justBaseURL = true;
            unset($options['justBase']);
        }

        if (is_string($url) && strpos($url, 'data:') === 0) {
            return $url;
        }
        // Url defaults
        $defaults = [
            'fullBase' => false,
            'escape' => false
        ];
        if (!is_array($options)) {
            $options = ['fullBase' => $options];
        }
        $options += $defaults;
        $routerUrl = parent::build($url, $options);
        $plainString = (
            strpos($routerUrl, 'javascript:') === 0
            || strpos($routerUrl, 'mailto:') === 0
            || strpos($routerUrl, 'tel:') === 0
            || strpos($routerUrl, 'sms:') === 0
            || strpos($routerUrl, '#') === 0
            || strpos($routerUrl, '?') === 0
            || strpos($routerUrl, '//') === 0
            || pathinfo($routerUrl, PATHINFO_EXTENSION)
        );

        if ($plainString) {
            return htmlspecialchars_decode($routerUrl);
        }

        return trailing_slash_url($routerUrl, $justBaseURL);
    }
}
