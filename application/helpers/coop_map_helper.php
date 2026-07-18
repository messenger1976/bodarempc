<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('coop_map_embed')) {

    /**
     * Render a Google Maps embed with automatic pin and info card.
     *
     * If $location contains coordinates ("9.6729,123.8721"), the embed is
     * forced to show a labeled pin at that spot. Otherwise the location is
     * used as a place search so Google can show its own place card.
     *
     * @param string $location Address, place name, or "lat,lng" coordinates.
     * @param string $label Title used for the pin label and info card.
     * @param int $height Map height in pixels.
     * @param bool $interactive FALSE disables pan/zoom (decorative maps).
     * @param bool $show_info Whether to render the overlay info card.
     * @return string HTML for the map block.
     */
    function coop_map_embed($location, $label = '', $height = 380, $interactive = TRUE, $show_info = TRUE) {
        static $cssPrinted = FALSE;

        $location = trim((string) $location);
        $label = trim((string) $label);

        // Detect "lat,lng" coordinates.
        $coords = NULL;
        if (preg_match('/^(-?\d+(?:\.\d+)?)\s*,\s*(-?\d+(?:\.\d+)?)$/', $location, $matches)) {
            $coords = array('lat' => $matches[1], 'lng' => $matches[2]);
        }

        if ($coords) {
            // Coordinates: force a labeled pin so Google shows marker + label.
            $query = $coords['lat'] . ',' . $coords['lng'];
            if ($label !== '') {
                $query .= ' (' . $label . ')';
            }
            $embedUrl = 'https://maps.google.com/maps?q=' . rawurlencode($query)
                . '&hl=en&z=16&ie=UTF8&iwloc=B&output=embed';
            $externalUrl = 'https://www.google.com/maps?q=' . rawurlencode($coords['lat'] . ',' . $coords['lng']);
            $infoTitle = $label !== '' ? $label : 'Location';
            $infoSubtitle = $coords['lat'] . ', ' . $coords['lng'];
        } else {
            // Place/address text: place search lets Google show its place card.
            $embedUrl = 'https://www.google.com/maps?q=' . rawurlencode($location)
                . '&hl=en&z=15&output=embed';
            $externalUrl = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($location);
            $infoTitle = $label !== '' ? $label : 'Location';
            $infoSubtitle = $location;
        }

        $html = '';

        if (!$cssPrinted) {
            $cssPrinted = TRUE;
            $html .= '<style>
                .coop-map-wrap {
                    position: relative;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 0 30px rgba(0, 0, 0, .08);
                }
                .coop-map-wrap iframe {
                    display: block;
                    width: 100%;
                    border: 0;
                }
                .coop-map-info {
                    position: absolute;
                    top: 16px;
                    left: 16px;
                    z-index: 2;
                    max-width: min(320px, calc(100% - 32px));
                    background: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 12px rgba(0, 0, 0, .18);
                    padding: 12px 14px;
                    text-align: left;
                }
                .coop-map-info h5 {
                    margin: 0 0 4px;
                    font-size: 15px;
                    color: #222;
                }
                .coop-map-info p {
                    margin: 0 0 8px;
                    font-size: 13px;
                    color: #666;
                    line-height: 1.4;
                }
                .coop-map-info a {
                    font-size: 13px;
                    font-weight: 600;
                    color: #02245b;
                    text-decoration: none;
                }
                .coop-map-info a:hover {
                    text-decoration: underline;
                }
                .coop-map-info .coop-map-pin {
                    color: #ea4335;
                    margin-right: 4px;
                }
            </style>';
        }

        $iframeStyle = $interactive ? '' : ' style="pointer-events: none;"';

        $html .= '<div class="coop-map-wrap">';

        if ($show_info) {
            $html .= '<div class="coop-map-info">'
                . '<h5><i class="fa fa-map-marker-alt coop-map-pin"></i>' . htmlspecialchars($infoTitle, ENT_QUOTES, 'UTF-8') . '</h5>'
                . '<p>' . htmlspecialchars($infoSubtitle, ENT_QUOTES, 'UTF-8') . '</p>'
                . '<a href="' . htmlspecialchars($externalUrl, ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener noreferrer">Open in Google Maps</a>'
                . '</div>';
        }

        $html .= '<iframe'
            . ' height="' . (int) $height . '"'
            . ' src="' . htmlspecialchars($embedUrl, ENT_QUOTES, 'UTF-8') . '"'
            . $iframeStyle
            . ' allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">'
            . '</iframe>';

        $html .= '</div>';

        return $html;
    }

}
