<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coop_audit {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function log($action, $context = array()) {
        $basePath = realpath(APPPATH . '..');
        $logDir = $basePath . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'logs';

        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $entry = array(
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => (string) $action,
            'user_id' => $this->CI->session->userdata('user_id'),
            'role' => $this->CI->session->userdata('user_position'),
            'ip' => $this->CI->input->ip_address(),
            'uri' => uri_string(),
            'context' => $context,
        );

        $line = json_encode($entry) . PHP_EOL;
        file_put_contents($logDir . DIRECTORY_SEPARATOR . 'admin_audit.log', $line, FILE_APPEND);
    }

    protected function logFilePath() {
        $basePath = realpath(APPPATH . '..');
        return $basePath . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'admin_audit.log';
    }

    /**
     * Returns the latest role_updated audit entry per target user id.
     * Result: array keyed by target_user_id => array('changed_by', 'changed_at', 'new_role')
     */
    public function getLatestRoleChangesByUser() {
        $changes = array();
        $logFile = $this->logFilePath();

        if (!is_file($logFile) || !is_readable($logFile)) {
            return $changes;
        }

        $handle = fopen($logFile, 'r');
        if (!$handle) {
            return $changes;
        }

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $entry = json_decode($line, true);
            if (!is_array($entry) || !isset($entry['action']) || $entry['action'] !== 'role_updated') {
                continue;
            }

            $context = isset($entry['context']) && is_array($entry['context']) ? $entry['context'] : array();
            if (!isset($context['target_user_id'])) {
                continue;
            }

            $targetId = (int) $context['target_user_id'];
            $changedBy = '';
            if (isset($context['changed_by_name']) && $context['changed_by_name'] !== '') {
                $changedBy = $context['changed_by_name'];
            } elseif (isset($entry['role'])) {
                $changedBy = $entry['role'];
            }

            // Log is chronological, so later lines overwrite earlier ones (latest wins).
            $changes[$targetId] = array(
                'changed_by' => $changedBy,
                'changed_at' => isset($entry['timestamp']) ? $entry['timestamp'] : '',
                'new_role' => isset($context['new_role']) ? $context['new_role'] : '',
            );
        }

        fclose($handle);

        return $changes;
    }
}
