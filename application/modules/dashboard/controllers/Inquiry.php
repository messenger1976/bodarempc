<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends MX_Controller {

	function __construct() {
		parent::__construct();

		$logged_in = $this->session->userdata('logged_in');
		$user_position = $this->session->userdata('user_position');
		if (!$logged_in) {
			redirect('access/login', 'refresh');
		} elseif (!in_array($user_position, array('Admin', 'Super Admin', 'Manager', 'Staff'))) {
			redirect('dashboard/index', 'refresh');
		}

		$language = $this->session->userdata('lang');
		$this->lang->load('dashboard', $language);
		$this->load->library('coop_access');
		$this->coop_access->requireAnyRole(array('Super Admin', 'Admin', 'Manager', 'Staff'));
	}

	public function index() {
		redirect('dashboard/inquiry/allinquiries', 'refresh');
	}

	public function allinquiries() {
		$status = $this->input->get('status');
		$this->db->from('inquiry');
		if (in_array($status, array('new', 'read', 'replied', 'closed', 'guest_replied'), TRUE)) {
			$this->db->where('status', $status);
		}
		$this->db->order_by('inquiryid', 'DESC');
		$data['inquiries'] = $this->db->get()->result();
		$data['filter_status'] = $status;
		$data['counts'] = $this->getStatusCounts();

		$this->load->view('Dashboard/header');
		$this->load->view('Inquiry/allinquiries', $data);
		$this->load->view('Dashboard/footer');
	}

	public function view() {
		$inquiryid = (int) $this->uri->segment(4);
		$inquiry = $this->getInquiry($inquiryid);
		if (!$inquiry) {
			$this->session->set_flashdata('notsuccess', 'Inquiry not found.');
			redirect('dashboard/inquiry/allinquiries', 'refresh');
			return;
		}

		if ($inquiry->status === 'new') {
			$this->db->where('inquiryid', $inquiryid);
			$this->db->update('inquiry', array(
				'status' => 'read',
				'updated_at' => date('Y-m-d H:i:s'),
			));
			$inquiry->status = 'read';
		}

		$data['inquiry'] = $inquiry;
		$data['replies'] = $this->getReplies($inquiryid);

		$this->load->view('Dashboard/header');
		$this->load->view('Inquiry/view', $data);
		$this->load->view('Dashboard/footer');
	}

	public function reply() {
		$inquiryid = (int) $this->input->post('inquiryid');
		$inquiry = $this->getInquiry($inquiryid);
		if (!$inquiry) {
			$this->session->set_flashdata('notsuccess', 'Inquiry not found.');
			redirect('dashboard/inquiry/allinquiries', 'refresh');
			return;
		}

		$this->form_validation->set_rules('reply_subject', 'Subject', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('reply_message', 'Message', 'trim|required|max_length[10000]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('notsuccess', strip_tags(validation_errors()));
			redirect('dashboard/inquiry/view/' . $inquiryid, 'refresh');
			return;
		}

		$reply_subject = $this->security->xss_clean($this->input->post('reply_subject'));
		$reply_message = trim($this->input->post('reply_message'));
		$now = date('Y-m-d H:i:s');
		$userid = $this->session->userdata('user_id');

		$info = $this->db->get('websitebasic')->row();
		$siteName = $info && !empty($info->title) ? $info->title : 'BODARE & COMMUNITY MPC';

		$this->load->library('coop_imap');
		$taggedSubject = Coop_imap::tagged_subject($inquiryid, $reply_subject);
		$mailHeaders = array('X-BODARE-Inquiry-ID' => (string) $inquiryid);

		$htmlMessage = '
			<div style="font-family:Arial,sans-serif;line-height:1.6;color:#333;max-width:640px;margin:0 auto;">
				<p>Hi ' . htmlspecialchars($inquiry->name, ENT_QUOTES, 'UTF-8') . ',</p>
				' . nl2br(htmlspecialchars($reply_message, ENT_QUOTES, 'UTF-8')) . '
				<hr style="border:none;border-top:1px solid #ddd;margin:24px 0;" />
				<p style="color:#666;font-size:13px;"><strong>Your original message:</strong><br />
				<strong>Subject:</strong> ' . htmlspecialchars($inquiry->subject, ENT_QUOTES, 'UTF-8') . '<br />
				' . nl2br(htmlspecialchars($inquiry->message, ENT_QUOTES, 'UTF-8')) . '</p>
				<p style="color:#666;font-size:13px;">You can reply to this email to continue the conversation. Please keep the subject line.</p>
				<p style="color:#666;font-size:13px;">— ' . htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') . '</p>
			</div>
		';

		$this->load->library('coop_mail');
		$this->coop_mail->set_profile('contact');
		$contactSettings = $this->coop_mail->get_settings('contact');
		$contactMailbox = ($contactSettings && !empty($contactSettings->from_email)) ? $contactSettings->from_email : NULL;
		$sent = $this->coop_mail->send(
			$inquiry->email,
			$taggedSubject,
			$htmlMessage,
			NULL,
			NULL,
			$contactMailbox,
			$siteName,
			NULL,
			$mailHeaders
		);

		$replyData = array(
			'inquiryid' => $inquiryid,
			'userid' => $userid ? (int) $userid : NULL,
			'direction' => 'outbound',
			'reply_subject' => $taggedSubject,
			'reply_message' => $reply_message,
			'email_sent' => $sent ? 1 : 0,
			'cdate' => date('j F Y'),
			'created_at' => $now,
		);
		$this->db->insert('inquiry_reply', $replyData);

		$this->db->where('inquiryid', $inquiryid);
		$this->db->update('inquiry', array(
			'status' => 'replied',
			'updated_at' => $now,
		));

		if ($sent) {
			$this->session->set_flashdata('success', 'Reply sent successfully to ' . $inquiry->email);
		} else {
			$error = $this->coop_mail->get_last_error();
			$this->session->set_flashdata('notsuccess', 'Reply saved, but email could not be sent. ' . ($error ? $error : 'Check SMTP settings.'));
		}

		redirect('dashboard/inquiry/view/' . $inquiryid, 'refresh');
	}

	public function updatestatus() {
		$inquiryid = (int) $this->input->post('inquiryid');
		$status = $this->input->post('status');
		$allowed = array('new', 'read', 'replied', 'closed', 'guest_replied');

		if (!$inquiryid || !in_array($status, $allowed, TRUE)) {
			$this->session->set_flashdata('notsuccess', 'Invalid status update.');
			redirect('dashboard/inquiry/allinquiries', 'refresh');
			return;
		}

		$this->db->where('inquiryid', $inquiryid);
		$updated = $this->db->update('inquiry', array(
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
		));

		if ($updated) {
			$this->session->set_flashdata('success', 'Inquiry status updated.');
		} else {
			$this->session->set_flashdata('notsuccess', 'Could not update status.');
		}

		redirect('dashboard/inquiry/view/' . $inquiryid, 'refresh');
	}

	public function delete($inquiryid = NULL) {
		$inquiryid = (int) $inquiryid;
		if (!$inquiryid) {
			$this->session->set_flashdata('notsuccess', 'Invalid inquiry.');
			redirect('dashboard/inquiry/allinquiries', 'refresh');
			return;
		}

		$this->db->where('inquiryid', $inquiryid);
		$this->db->delete('inquiry_reply');

		$this->db->where('inquiryid', $inquiryid);
		$deleted = $this->db->delete('inquiry');

		if ($deleted) {
			$this->session->set_flashdata('success', 'Inquiry deleted successfully.');
		} else {
			$this->session->set_flashdata('notsuccess', 'Could not delete inquiry.');
		}

		redirect('dashboard/inquiry/allinquiries', 'refresh');
	}

	public function fetchinbound() {
		$this->load->library('coop_imap');
		$result = $this->coop_imap->import_inbound_replies();

		if (!empty($result['errors'])) {
			$this->session->set_flashdata('notsuccess', implode(' ', $result['errors']));
		} elseif ($result['imported'] > 0) {
			$ids = !empty($result['inquiry_ids']) ? $result['inquiry_ids'] : array();
			if (count($ids) === 1) {
				$this->session->set_flashdata('success', 'Guest email reply imported for Inquiry #' . (int) $ids[0] . '.');
				redirect('dashboard/inquiry/view/' . (int) $ids[0], 'refresh');
				return;
			}
			$this->session->set_flashdata('success', $result['imported'] . ' guest email reply(ies) imported for inquiries: #' . implode(', #', $ids) . '.');
		} else {
			$this->session->set_flashdata('success', 'No new guest email replies found in the mailbox.');
		}

		$redirect = $this->input->post('redirect');
		if ($redirect && strpos($redirect, 'dashboard/inquiry/') === 0) {
			redirect($redirect, 'refresh');
			return;
		}

		redirect('dashboard/inquiry/allinquiries?status=guest_replied', 'refresh');
	}

	public function poll() {
		$imported = 0;
		if ($this->input->get('mail') === '1' && $this->shouldPollInboundMail()) {
			$this->load->library('coop_imap');
			$result = $this->coop_imap->import_inbound_replies();
			$imported = (int) $result['imported'];
			$this->markInboundMailPolled();
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array(
				'count' => $this->getBadgeCount(),
				'imported' => $imported,
			)));
	}

	protected function shouldPollInboundMail() {
		if (!function_exists('imap_open')) {
			return FALSE;
		}

		$this->load->library('coop_mail');
		$settings = $this->coop_mail->get_settings('contact');
		if (!$settings || !$this->db->field_exists('imap_enabled', 'email_smtp_settings') || empty($settings->imap_enabled)) {
			return FALSE;
		}

		$lockFile = APPPATH . 'cache/inquiry_imap_poll.lock';
		if (is_file($lockFile)) {
			$lastPoll = (int) @file_get_contents($lockFile);
			if ($lastPoll > 0 && (time() - $lastPoll) < 5) {
				return FALSE;
			}
		}

		return TRUE;
	}

	protected function markInboundMailPolled() {
		$lockFile = APPPATH . 'cache/inquiry_imap_poll.lock';
		@file_put_contents($lockFile, (string) time(), LOCK_EX);
	}

	protected function getBadgeCount() {
		$this->db->where_in('status', array('new', 'guest_replied'));
		return (int) $this->db->count_all_results('inquiry');
	}

	protected function getInquiry($inquiryid) {
		$query = $this->db->get_where('inquiry', array('inquiryid' => (int) $inquiryid), 1);
		return $query->row();
	}

	protected function getReplies($inquiryid) {
		$this->db->select('inquiry_reply.*, users.fname, users.lname, users.email as admin_email');
		$this->db->from('inquiry_reply');
		$this->db->join('users', 'users.userid = inquiry_reply.userid', 'left');
		$this->db->where('inquiry_reply.inquiryid', (int) $inquiryid);
		$this->db->order_by('inquiry_reply.replyid', 'ASC');
		return $this->db->get()->result();
	}

	protected function getStatusCounts() {
		$counts = array(
			'all' => 0,
			'new' => 0,
			'read' => 0,
			'replied' => 0,
			'closed' => 0,
			'guest_replied' => 0,
		);

		$rows = $this->db->query("SELECT status, COUNT(*) AS total FROM inquiry GROUP BY status")->result();
		foreach ($rows as $row) {
			$counts['all'] += (int) $row->total;
			if (isset($counts[$row->status])) {
				$counts[$row->status] = (int) $row->total;
			}
		}

		return $counts;
	}
}
