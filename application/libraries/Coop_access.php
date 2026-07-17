<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coop_access {

    protected $CI;

    protected $roleRank = array(
        'Viewer' => 1,
        'Staff' => 2,
        'Manager' => 3,
        'Admin' => 4,
        'Super Admin' => 5,
    );

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function normalizeRole($role) {
        $role = trim((string) $role);

        if ($role === 'Contibutor' || $role === 'Contributor') {
            return 'Staff';
        }

        if ($role === 'Subscriber') {
            return 'Viewer';
        }

        if (!array_key_exists($role, $this->roleRank)) {
            return 'Viewer';
        }

        return $role;
    }

    public function getCurrentRole() {
        $role = $this->CI->session->userdata('user_position');
        return $this->normalizeRole($role);
    }

    public function getAvailableRoles() {
        return array_keys($this->roleRank);
    }

    public function hasAnyRole($roles, $currentRole = NULL) {
        if (!is_array($roles)) {
            $roles = array($roles);
        }

        $normalizedAllowed = array();
        foreach ($roles as $role) {
            $normalizedAllowed[] = $this->normalizeRole($role);
        }

        $currentRole = $currentRole ? $this->normalizeRole($currentRole) : $this->getCurrentRole();
        return in_array($currentRole, $normalizedAllowed, true);
    }

    public function hasMinimumRole($minimumRole, $currentRole = NULL) {
        $minimumRole = $this->normalizeRole($minimumRole);
        $currentRole = $currentRole ? $this->normalizeRole($currentRole) : $this->getCurrentRole();

        return $this->roleRank[$currentRole] >= $this->roleRank[$minimumRole];
    }

    public function requireAnyRole($roles, $redirect = 'dashboard/index') {
        if (!$this->hasAnyRole($roles)) {
            redirect($redirect, 'refresh');
        }
    }
}
