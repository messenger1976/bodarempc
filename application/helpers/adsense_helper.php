<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Google AdSense helpers for the public website.
 */

if (!function_exists('adsense_settings')) {
    /**
     * Load adsense config array.
     *
     * @return array
     */
    function adsense_settings()
    {
        static $settings = null;

        if ($settings !== null) {
            return $settings;
        }

        $CI =& get_instance();
        $CI->config->load('adsense');

        $settings = $CI->config->item('adsense');
        if (!is_array($settings)) {
            $settings = array();
        }

        return $settings;
    }
}

if (!function_exists('adsense_publisher_id_valid')) {
    function adsense_publisher_id_valid($publisherId)
    {
        $publisherId = trim((string) $publisherId);
        if ($publisherId === '' || stripos($publisherId, 'XXXX') !== false) {
            return false;
        }

        return (bool) preg_match('/^ca-pub-\d{10,20}$/', $publisherId);
    }
}

if (!function_exists('adsense_page_allows_ads')) {
    /**
     * True unless the current URI matches a deny rule.
     */
    function adsense_page_allows_ads()
    {
        $CI =& get_instance();
        $uri = strtolower(trim($CI->uri->uri_string(), '/'));
        $settings = adsense_settings();
        $deny = isset($settings['deny_uris']) && is_array($settings['deny_uris'])
            ? $settings['deny_uris']
            : array();

        foreach ($deny as $fragment) {
            $fragment = strtolower(trim((string) $fragment, '/'));
            if ($fragment === '') {
                continue;
            }
            if ($uri === $fragment || strpos($uri, $fragment) !== false) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('adsense_is_enabled')) {
    function adsense_is_enabled()
    {
        if (!adsense_page_allows_ads()) {
            return false;
        }

        $settings = adsense_settings();
        if (empty($settings['enabled'])) {
            return false;
        }

        return adsense_publisher_id_valid(isset($settings['publisher_id']) ? $settings['publisher_id'] : '');
    }
}

if (!function_exists('adsense_render_head')) {
    /**
     * Output AdSense verification meta + Auto ads script for <head>.
     */
    function adsense_render_head()
    {
        $settings = adsense_settings();
        $publisherId = isset($settings['publisher_id']) ? trim((string) $settings['publisher_id']) : '';

        if (adsense_publisher_id_valid($publisherId) && adsense_page_allows_ads()) {
            echo '<meta name="google-adsense-account" content="'
                . htmlspecialchars($publisherId, ENT_QUOTES, 'UTF-8')
                . '">' . "\n";
        }

        if (!adsense_is_enabled()) {
            return;
        }

        $client = htmlspecialchars($publisherId, ENT_QUOTES, 'UTF-8');
        echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client='
            . $client . '" crossorigin="anonymous"></script>' . "\n";
    }
}

if (!function_exists('adsense_slot_id')) {
    function adsense_slot_id($slotKey)
    {
        $settings = adsense_settings();
        $slot = '';
        if (isset($settings['slots'][$slotKey])) {
            $slot = trim((string) $settings['slots'][$slotKey]);
        }

        if ($slot === '' || stripos($slot, 'XXXX') !== false) {
            return '';
        }

        return $slot;
    }
}

if (!function_exists('adsense_render_unit')) {
    /**
     * Render a responsive manual ad unit. No-op until slot ID is configured.
     *
     * @param string $slotKey Key from adsense.php slots array
     * @param string $class   Extra CSS classes for the wrapper
     */
    function adsense_render_unit($slotKey = 'in_content', $class = '')
    {
        if (!adsense_is_enabled()) {
            return;
        }

        $slot = adsense_slot_id($slotKey);
        if ($slot === '') {
            return;
        }

        $settings = adsense_settings();
        $client = htmlspecialchars($settings['publisher_id'], ENT_QUOTES, 'UTF-8');
        $slotEsc = htmlspecialchars($slot, ENT_QUOTES, 'UTF-8');
        $wrapClass = trim('adsense-wrap ' . $class);

        echo '<div class="' . htmlspecialchars($wrapClass, ENT_QUOTES, 'UTF-8') . '">' . "\n";
        echo '  <ins class="adsbygoogle"' . "\n";
        echo '       style="display:block"' . "\n";
        echo '       data-ad-client="' . $client . '"' . "\n";
        echo '       data-ad-slot="' . $slotEsc . '"' . "\n";
        echo '       data-ad-format="auto"' . "\n";
        echo '       data-full-width-responsive="true"></ins>' . "\n";
        echo '  <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>' . "\n";
        echo '</div>' . "\n";
    }
}
