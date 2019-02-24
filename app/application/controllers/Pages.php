<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->data = [];
	}

	private function verifyLogin() {
		$this->user_id = $this->session->user_id;
		if (!$this->user_id) {
			header('Location: /login?redirect_to=/' . uri_string());
		} else {
			$userQuery = $this->db->get_where('user', ['user_id' => $this->user_id])->result();
			if ($userQuery) {
				$this->user = $userQuery[0];
				$this->data["name"] = $this->user->name;
			}
		}
	}

	public function landing() {
		$this->load->view('landing', $this->data);
	}

	public function login() {
		$this->data['google_signin_client_id'] = $this->config->item('login')->web->client_id;
		$this->load->view('login', $this->data);
	}

	public function find() {
		$this->verifyLogin();

		$this->load->view('find', $this->data);
	}

	public function allBuildings() {
		$this->verifyLogin();

		$buildings = $this->db->get('building')->result();
		$this->data['buildings'] = $buildings;
		$this->load->view('allBuildings', $this->data);
	}

	public function building($id) {
		$this->verifyLogin();

	}
}
