<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('seo_plain_text')) {
    /**
     * Strip HTML and collapse whitespace for meta descriptions.
     */
    function seo_plain_text($html, $limit = 160)
    {
        $text = (string) $html;
        $text = preg_replace('/<\s*(br|\/p|\/div|\/h[1-6]|\/li)\s*\/?>/i', ' ', $text);
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text);
        $text = trim($text);

        if ($text === '') {
            return '';
        }

        if (function_exists('mb_strlen') && mb_strlen($text) > $limit) {
            $text = rtrim(mb_substr($text, 0, $limit - 3)) . '...';
        } elseif (strlen($text) > $limit) {
            $text = rtrim(substr($text, 0, $limit - 3)) . '...';
        }

        return $text;
    }
}

if (!function_exists('seo_absolute_url')) {
    /**
     * Build an absolute URL from a path or full URL.
     */
    function seo_absolute_url($path = '')
    {
        if ($path === null || $path === '') {
            return rtrim(base_url(), '/') . '/';
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return rtrim(base_url(), '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('seo_current_url')) {
    /**
     * Canonical-friendly current URL without query strings.
     */
    function seo_current_url()
    {
        $ci =& get_instance();
        $uri = trim($ci->uri->uri_string(), '/');

        if ($uri === '' || $uri === 'home' || $uri === 'home/index') {
            return seo_absolute_url();
        }

        return seo_absolute_url($uri);
    }
}

if (!function_exists('seo_site_pages')) {
    /**
     * Default title/description/keywords for known public routes.
     */
    function seo_site_pages($site_name = 'BODARE & Community MPC')
    {
        $name = $site_name;

        return array(
            '' => array(
                'title' => $name . ' | Bohol DAR Employee & Community Multi-Purpose Cooperative',
                'description' => $name . ' is a duly registered cooperative in Bohol offering lending, savings, time deposits, mortuary aid, building rental, and community services since 1991.',
                'keywords' => 'BODARE, Bohol cooperative, DAR employees cooperative, multi-purpose cooperative, lending, savings, Bohol MPC',
            ),
            'home' => array(
                'title' => $name . ' | Bohol DAR Employee & Community Multi-Purpose Cooperative',
                'description' => $name . ' is a duly registered cooperative in Bohol offering lending, savings, time deposits, mortuary aid, building rental, and community services since 1991.',
                'keywords' => 'BODARE, Bohol cooperative, DAR employees cooperative, multi-purpose cooperative, lending, savings, Bohol MPC',
            ),
            'home/about' => array(
                'title' => 'About Us | ' . $name,
                'description' => 'Learn the history and mission of ' . $name . ', organized in 1991 by DAR employees to provide financial assistance and cooperative services in Bohol.',
                'keywords' => 'about BODARE, cooperative history, Bohol DAR cooperative, BODARE mission',
            ),
            'home/about_us' => array(
                'title' => 'About Us | ' . $name,
                'description' => 'Discover who we are at ' . $name . ' — our background, values, and commitment to members and the Bohol community.',
                'keywords' => 'about us, BODARE cooperative, Bohol multi-purpose cooperative',
            ),
            'home/products' => array(
                'title' => 'Products & Services | ' . $name,
                'description' => 'Explore ' . $name . ' products and services including loans, savings and time deposits, mortuary aid, building rental, and other member benefits.',
                'keywords' => 'cooperative loans, savings, time deposit, mortuary aid, building rental, BODARE products',
            ),
            'home/contact' => array(
                'title' => 'Contact Us | ' . $name,
                'description' => 'Contact ' . $name . ' for membership inquiries, loans, deposits, and other cooperative services. Visit our office or send a message online.',
                'keywords' => 'contact BODARE, Bohol cooperative contact, membership inquiry',
            ),
            'home/event' => array(
                'title' => 'Events | ' . $name,
                'description' => 'Stay updated with the latest events, activities, and announcements from ' . $name . '.',
                'keywords' => 'BODARE events, cooperative activities, Bohol cooperative news',
            ),
            'home/gallery' => array(
                'title' => 'Gallery | ' . $name,
                'description' => 'Browse photos from ' . $name . ' activities, programs, and community events.',
                'keywords' => 'BODARE gallery, cooperative photos, Bohol community events',
            ),
            'home/cooperative_officers' => array(
                'title' => 'Cooperative Officers | ' . $name,
                'description' => 'Meet the cooperative officers who lead and manage the day-to-day operations of ' . $name . '.',
                'keywords' => 'cooperative officers, BODARE management, Bohol MPC officers',
            ),
            'home/board_of_directors' => array(
                'title' => 'Board of Directors | ' . $name,
                'description' => 'Meet the Board of Directors of ' . $name . ', guiding the cooperative with accountable and member-focused leadership.',
                'keywords' => 'board of directors, BODARE BOD, cooperative leadership',
            ),
            'home/sermon' => array(
                'title' => 'Sermons | ' . $name,
                'description' => 'Read sermons and inspiring messages shared by ' . $name . '.',
                'keywords' => 'sermons, BODARE messages',
            ),
        );
    }
}

if (!function_exists('seo_resolve')) {
    /**
     * Merge page overrides with route defaults and site identity.
     *
     * Supported override keys:
     * title, description, keywords, canonical, image, type, robots, site_name, json_ld
     */
    function seo_resolve($overrides = array(), $basic = null)
    {
        if ($basic === null) {
            $basic = function_exists('getBasic') ? getBasic() : false;
        }

        $site_name = (!empty($basic->title)) ? trim($basic->title) : 'BODARE & Community MPC';
        $site_tag = (!empty($basic->tag)) ? trim($basic->tag) : 'Bohol DAR Employee & Community Multi-Purpose Cooperative';
        $default_image = (!empty($basic->logo))
            ? seo_absolute_url('images/website/' . $basic->logo)
            : seo_absolute_url('themes/bodare/website/assets/img/about-1.jpg');
        $favicon = (!empty($basic->favicon))
            ? seo_absolute_url('images/website/' . $basic->favicon)
            : seo_absolute_url('themes/bodare/website/assets/img/favicon.ico');

        $ci =& get_instance();
        $uri = trim($ci->uri->uri_string(), '/');
        if ($uri === 'home/index') {
            $uri = '';
        }

        $pages = seo_site_pages($site_name);
        $route_key = $uri;
        if (!isset($pages[$route_key])) {
            // Fall back to the first two segments for detail pages like home/event/view/1
            $parts = explode('/', $uri);
            if (count($parts) >= 2) {
                $route_key = $parts[0] . '/' . $parts[1];
            }
        }

        $defaults = isset($pages[$route_key]) ? $pages[$route_key] : array(
            'title' => $site_name . ' | ' . $site_tag,
            'description' => $site_name . ' — ' . $site_tag . '. Serving members and the community in Bohol with cooperative financial and social services.',
            'keywords' => 'BODARE, Bohol cooperative, multi-purpose cooperative',
        );

        $seo = array_merge(array(
            'title' => $defaults['title'],
            'description' => $defaults['description'],
            'keywords' => $defaults['keywords'],
            'canonical' => seo_current_url(),
            'image' => $default_image,
            'type' => 'website',
            'robots' => 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1',
            'site_name' => $site_name,
            'locale' => 'en_PH',
            'favicon' => $favicon,
            'json_ld' => array(),
        ), $overrides);

        $seo['title'] = trim((string) $seo['title']);
        $seo['description'] = seo_plain_text($seo['description'], 160);
        $seo['keywords'] = trim((string) $seo['keywords']);
        $seo['canonical'] = seo_absolute_url($seo['canonical']);
        $seo['image'] = seo_absolute_url($seo['image']);

        if (empty($seo['json_ld'])) {
            $seo['json_ld'] = array(seo_organization_schema($basic, $seo));
        } elseif (!isset($seo['json_ld'][0])) {
            $seo['json_ld'] = array($seo['json_ld']);
        }

        return $seo;
    }
}

if (!function_exists('seo_organization_schema')) {
    /**
     * Organization / Cooperative JSON-LD for the whole site.
     */
    function seo_organization_schema($basic = null, $seo = array())
    {
        if ($basic === null) {
            $basic = function_exists('getBasic') ? getBasic() : false;
        }

        $site_name = !empty($seo['site_name'])
            ? $seo['site_name']
            : ((!empty($basic->title)) ? $basic->title : 'BODARE & Community MPC');

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $site_name,
            'alternateName' => array(
                'BODARE & Community MPC',
                'Bohol DAR Employee & Community Multi-Purpose Cooperative',
            ),
            'url' => seo_absolute_url(),
            'logo' => !empty($seo['image']) ? $seo['image'] : seo_absolute_url(),
            'description' => !empty($seo['description'])
                ? $seo['description']
                : 'Bohol DAR Employee & Community Multi-Purpose Cooperative providing member financial and community services since 1991.',
        );

        if (!empty($basic->email)) {
            $schema['email'] = seo_plain_text($basic->email, 120);
        }
        if (!empty($basic->contact)) {
            $phone = seo_plain_text($basic->contact, 80);
            // Prefer a phone-like value; skip leftover rich-text address content.
            if ($phone !== '' && preg_match('/[0-9]/', $phone) && strlen($phone) < 40) {
                $schema['telephone'] = $phone;
            }
        }
        if (!empty($basic->address) || !empty($basic->map)) {
            $street = seo_plain_text(!empty($basic->address) ? $basic->address : $basic->map, 200);
            if ($street !== '') {
                $schema['address'] = array(
                    '@type' => 'PostalAddress',
                    'streetAddress' => $street,
                    'addressLocality' => 'Bohol',
                    'addressCountry' => 'PH',
                );
            }
        }

        $same_as = array();
        foreach (array('facebook', 'twitter', 'youtube', 'linkedin') as $network) {
            if (empty($basic->$network)) {
                continue;
            }
            $url = trim($basic->$network);
            if ($url === '' || $url === '#' || $url === '/' || !preg_match('#^https?://#i', $url)) {
                continue;
            }
            $same_as[] = $url;
        }
        if (!empty($same_as)) {
            $schema['sameAs'] = array_values(array_unique($same_as));
        }

        return $schema;
    }
}

if (!function_exists('seo_breadcrumb_schema')) {
    /**
     * Build BreadcrumbList JSON-LD from label => url pairs.
     */
    function seo_breadcrumb_schema($crumbs = array())
    {
        $items = array();
        $position = 1;

        foreach ($crumbs as $name => $url) {
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $name,
                'item' => seo_absolute_url($url),
            );
        }

        return array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        );
    }
}

if (!function_exists('seo_event_schema')) {
    /**
     * Build Event JSON-LD from an event row object.
     */
    function seo_event_schema($event, $basic = null)
    {
        if (empty($event)) {
            return array();
        }

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event->eventtitle,
            'description' => seo_plain_text($event->eventdescription, 300),
            'url' => seo_current_url(),
            'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
            'eventStatus' => 'https://schema.org/EventScheduled',
            'organizer' => array(
                '@type' => 'Organization',
                'name' => ($basic && !empty($basic->title)) ? $basic->title : 'BODARE & Community MPC',
                'url' => seo_absolute_url(),
            ),
        );

        if (!empty($event->eventimage)) {
            $schema['image'] = array(seo_absolute_url('images/event/feature/' . $event->eventimage));
        }

        if (!empty($event->eventlocation)) {
            $schema['location'] = array(
                '@type' => 'Place',
                'name' => $event->eventlocation,
                'address' => $event->eventlocation,
            );
        }

        if (!empty($event->eventdate)) {
            $start = $event->eventdate;
            if (!empty($event->eventtime)) {
                $start .= ' ' . $event->eventtime;
            }
            $timestamp = strtotime($start);
            if ($timestamp) {
                $schema['startDate'] = date('c', $timestamp);
            } else {
                $schema['startDate'] = $event->eventdate;
            }
        }

        return $schema;
    }
}

if (!function_exists('seo_render_head')) {
    /**
     * Echo complete SEO-related head tags.
     */
    function seo_render_head($seo)
    {
        $title = htmlspecialchars($seo['title'], ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($seo['description'], ENT_QUOTES, 'UTF-8');
        $keywords = htmlspecialchars($seo['keywords'], ENT_QUOTES, 'UTF-8');
        $canonical = htmlspecialchars($seo['canonical'], ENT_QUOTES, 'UTF-8');
        $image = htmlspecialchars($seo['image'], ENT_QUOTES, 'UTF-8');
        $type = htmlspecialchars($seo['type'], ENT_QUOTES, 'UTF-8');
        $robots = htmlspecialchars($seo['robots'], ENT_QUOTES, 'UTF-8');
        $site_name = htmlspecialchars($seo['site_name'], ENT_QUOTES, 'UTF-8');
        $locale = htmlspecialchars($seo['locale'], ENT_QUOTES, 'UTF-8');
        $favicon = htmlspecialchars($seo['favicon'], ENT_QUOTES, 'UTF-8');

        echo '<title>' . $title . "</title>\n";
        echo '    <meta name="description" content="' . $description . "\">\n";
        echo '    <meta name="keywords" content="' . $keywords . "\">\n";
        echo '    <meta name="robots" content="' . $robots . "\">\n";
        echo '    <meta name="author" content="' . $site_name . "\">\n";
        echo '    <meta name="theme-color" content="#02245b">' . "\n";
        echo '    <link rel="canonical" href="' . $canonical . "\">\n";
        echo '    <link rel="shortcut icon" type="image/png" href="' . $favicon . "\">\n";
        echo '    <link rel="icon" type="image/png" href="' . $favicon . "\">\n";
        echo '    <link rel="apple-touch-icon" href="' . $favicon . "\">\n";

        echo '    <meta property="og:locale" content="' . $locale . "\">\n";
        echo '    <meta property="og:type" content="' . $type . "\">\n";
        echo '    <meta property="og:title" content="' . $title . "\">\n";
        echo '    <meta property="og:description" content="' . $description . "\">\n";
        echo '    <meta property="og:url" content="' . $canonical . "\">\n";
        echo '    <meta property="og:site_name" content="' . $site_name . "\">\n";
        echo '    <meta property="og:image" content="' . $image . "\">\n";
        echo '    <meta property="og:image:alt" content="' . $title . "\">\n";

        echo '    <meta name="twitter:card" content="summary_large_image">' . "\n";
        echo '    <meta name="twitter:title" content="' . $title . "\">\n";
        echo '    <meta name="twitter:description" content="' . $description . "\">\n";
        echo '    <meta name="twitter:image" content="' . $image . "\">\n";

        if (!empty($seo['json_ld']) && is_array($seo['json_ld'])) {
            foreach ($seo['json_ld'] as $schema) {
                if (empty($schema)) {
                    continue;
                }
                echo '    <script type="application/ld+json">'
                    . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
                    . "</script>\n";
            }
        }
    }
}
