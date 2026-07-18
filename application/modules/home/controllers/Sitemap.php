<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends MX_Controller {

    public function index()
    {
        $urls = array();

        $static_pages = array(
            array('loc' => '', 'priority' => '1.0', 'changefreq' => 'weekly'),
            array('loc' => 'home/about', 'priority' => '0.9', 'changefreq' => 'monthly'),
            array('loc' => 'home/about_us', 'priority' => '0.8', 'changefreq' => 'monthly'),
            array('loc' => 'home/products', 'priority' => '0.9', 'changefreq' => 'monthly'),
            array('loc' => 'home/contact', 'priority' => '0.8', 'changefreq' => 'monthly'),
            array('loc' => 'home/event', 'priority' => '0.8', 'changefreq' => 'weekly'),
            array('loc' => 'home/gallery', 'priority' => '0.7', 'changefreq' => 'weekly'),
            array('loc' => 'home/cooperative_officers', 'priority' => '0.7', 'changefreq' => 'monthly'),
            array('loc' => 'home/board_of_directors', 'priority' => '0.7', 'changefreq' => 'monthly'),
        );

        foreach ($static_pages as $page) {
            $urls[] = $this->buildUrlEntry($page['loc'], $page['priority'], $page['changefreq']);
        }

        foreach ($this->getCmsPages() as $page) {
            $slug = !empty($page->pageslug) ? $page->pageslug : $page->pageid;
            $urls[] = $this->buildUrlEntry(
                'home/page/' . $slug,
                '0.7',
                'monthly',
                !empty($page->cdate) ? $page->cdate : null
            );
        }

        foreach ($this->getPublishedEvents() as $event) {
            $urls[] = $this->buildUrlEntry(
                'home/event/view/' . $event->eventid,
                '0.6',
                'weekly',
                !empty($event->publish_start_at) ? $event->publish_start_at : null
            );
        }

        foreach ($this->getCooperativeOfficers() as $officer) {
            $urls[] = $this->buildUrlEntry(
                'home/cooperative_officers/view/' . $officer->cooperative_officersid,
                '0.5',
                'monthly'
            );
        }

        foreach ($this->getBoardOfDirectors() as $director) {
            $urls[] = $this->buildUrlEntry(
                'home/board_of_directors/view/' . $director->board_of_directorsid,
                '0.5',
                'monthly'
            );
        }

        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $entry) {
            echo "  <url>\n";
            echo '    <loc>' . htmlspecialchars($entry['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
            if (!empty($entry['lastmod'])) {
                echo '    <lastmod>' . htmlspecialchars($entry['lastmod'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</lastmod>\n";
            }
            echo '    <changefreq>' . $entry['changefreq'] . "</changefreq>\n";
            echo '    <priority>' . $entry['priority'] . "</priority>\n";
            echo "  </url>\n";
        }
        echo '</urlset>';
    }

    protected function buildUrlEntry($path, $priority = '0.5', $changefreq = 'monthly', $lastmod = null)
    {
        $entry = array(
            'loc' => ($path === '') ? rtrim(base_url(), '/') . '/' : rtrim(base_url(), '/') . '/' . ltrim($path, '/'),
            'priority' => $priority,
            'changefreq' => $changefreq,
            'lastmod' => null,
        );

        if (!empty($lastmod)) {
            $timestamp = strtotime($lastmod);
            if ($timestamp) {
                $entry['lastmod'] = date('Y-m-d', $timestamp);
            }
        }

        return $entry;
    }

    protected function getCmsPages()
    {
        if (!$this->db->table_exists('page')) {
            return array();
        }

        $this->db->select('pageid, pageslug, pagetitle, cdate');
        $this->db->order_by('pageid', 'asc');
        return $this->db->get('page')->result();
    }

    protected function getPublishedEvents()
    {
        if (!$this->db->table_exists('event')) {
            return array();
        }

        $now = date('Y-m-d H:i:s');
        $this->db->select('eventid, eventtitle, publish_start_at');
        $this->db->where('status', 'published');
        $this->db->where('publish_start_at <=', $now);
        $this->db->group_start();
        $this->db->where('publish_end_at IS NULL', NULL, FALSE);
        $this->db->or_where('publish_end_at >', $now);
        $this->db->group_end();
        $this->db->order_by('eventid', 'desc');
        return $this->db->get('event')->result();
    }

    protected function getCooperativeOfficers()
    {
        if (!$this->db->table_exists('cooperative_officers')) {
            return array();
        }

        $this->db->select('cooperative_officersid');
        return $this->db->get('cooperative_officers')->result();
    }

    protected function getBoardOfDirectors()
    {
        if (!$this->db->table_exists('board_of_directors')) {
            return array();
        }

        $this->db->select('board_of_directorsid');
        return $this->db->get('board_of_directors')->result();
    }
}
