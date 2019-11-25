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
				$this->data["user"] = $this->user;

				$myCheckin = $this->db->get_where('checkin', ['user_id' => $this->user->user_id])->result();
				if ($myCheckin) {
					$myCheckin = $myCheckin[0];
					$myRoom = $this->db->get_where('room', ['id' => $myCheckin->room_id])->result()[0];
					$myBuilding = $this->db->get_where('building', ['id' => $myRoom->building_id])->result()[0];
					$this->data['user']->room = $myRoom;
					$this->data['user']->room->building = $myBuilding;
				}
			} else {
				header('Location: /login?redirect_to=/' . uri_string());
			}
		}
	}

	private function calculateColor($room) {
		if (!$room->private && !$room->occupied) {
			return 2;
		} else if (!$room->private && $room->occupied) {
			return 1;
		}
		return 0;
	}	

	private function comparePlaces($a, $b) {
		if ( $a->color < $b->color ) {
			return true;
		} else if ($a->color > $b->color) {
			return false;
		} else {
			if ( strcmp($a->name, $b->name) > 0 ) {
				return true;
			} else if ( strcmp($a->name, $b->name) < 0 ) {
				return false;
			} else {
				return false;
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

		$events = $this->db->get('event')->result();
		for ($i=0; $i < count($events); $i++) {
			$checkin = $this->db->get_where('checkin', ['event_id' => $events[$i]->id])->result()[0];
			$events[$i]->checkin = $checkin;
			$room = $this->db->get_where('room', ['id' => $checkin->room_id])->result()[0];
			$events[$i]->checkin->room = $room;
			$building = $this->db->get_where('building', ['id' => $room->building_id])->result()[0];
			$events[$i]->checkin->room->building = $building;
		}

		$this->data['events'] = $events;

		$this->data['titleBar'] = $this->load->view('components/titleBar', $this->data, TRUE);
		$this->data['myRoom'] = $this->load->view('components/myRoom', $this->data, TRUE);
		$this->load->view('find', $this->data);
	}

	public function allBuildings() {
		$this->verifyLogin();

		$buildings = $this->db->get('building')->result();
		for ($i = 0; $i < count($buildings); $i++) {
			$this->db->where(['building_id' => $buildings[$i]->id, 'private' => false, 'occupied' => false]);
			$green = $this->db->count_all_results('room');
			$buildings[$i]->greenRoomCount = $green;

			$this->db->where(['building_id' => $buildings[$i]->id, 'private' => false, 'occupied' => true]);
			$yellow = $this->db->count_all_results('room');
			$buildings[$i]->yellowRoomCount = $yellow;

			$color = 0;
			if ($green > 0) {
				$color = 2;
			} else if ($yellow > 0) {
				$color = 1;
			}

			$buildings[$i]->color = $color;
		}
		usort($buildings, [$this, "comparePlaces"]);

		$this->data['buildings'] = $buildings;

		$this->data['titleBar'] = $this->load->view('components/titleBar', $this->data, TRUE);
		$this->data['myRoom'] = $this->load->view('components/myRoom', $this->data, TRUE);
		$this->load->view('allBuildings', $this->data);
	}

	public function building($id) {
		$this->verifyLogin();

		$building = $this->db->get_where('building', ['id' => $id])->result()[0];
		$this->data['building'] = $building;

		$rooms = $this->db->get_where('room', ['building_id' => $id])->result();
		for ($i = 0; $i < count($rooms); $i++) {			
			$rooms[$i]->color = $this->calculateColor($rooms[$i]);
		}
		usort($rooms, [$this, "comparePlaces"]);

		$this->data['rooms'] = $rooms;

		$this->data['titleBar'] = $this->load->view('components/titleBar', $this->data, TRUE);
		$this->data['myRoom'] = $this->load->view('components/myRoom', $this->data, TRUE);
		$this->load->view('building', $this->data);
	}

	public function room($id) {
		$this->verifyLogin();

		$room = $this->db->get_where('room', ['id' => $id])->result()[0];
		$room->color = $this->calculateColor($room);

		$building = $this->db->get_where('building', ['id' => $room->building_id])->result()[0];
		$room->building = $building;

		$checkin = $this->db->get_where('checkin', ['room_id' => $id])->result();
		$room->checkin_user = null;
		if ($checkin) {
			$checkin = $checkin[0];
			$room->checkin_user = $this->db->get_where('user', ['user_id' => $checkin->user_id])->result()[0];

			if ($checkin->event_id) {
				$event = $this->db->get_where('event', ['id' => $checkin->event_id])->result()[0];
				$room->event = $event;
			}
		}

		$this->data['room'] = $room;

		$this->data['titleBar'] = $this->load->view('components/titleBar', $this->data, TRUE);
		$this->data['myRoom'] = $this->load->view('components/myRoom', $this->data, TRUE);

		$this->load->view('room', $this->data);
	}

	public function createEvent($room_id) {
		$this->verifyLogin();

		$this->data['form'] = [
			'study' => true,
			'description' => '',
			'title' => ''
		];

		$room = $this->db->get_where('room', ['id' => $room_id])->result()[0];
		$room->color = $this->calculateColor($room);

		$building = $this->db->get_where('building', ['id' => $room->building_id])->result()[0];
		$room->building = $building;

		$checkin = $this->db->get_where('checkin', ['room_id' => $room_id])->result();
		$room->checkin_user = null;
		if ($checkin) {
			$checkin = $checkin[0];
			$room->checkin_user = $this->db->get_where('user', ['user_id' => $checkin->user_id])->result()[0];

			if ($checkin->event_id) {
				$event = $this->db->get_where('event', ['id' => $checkin->event_id])->result()[0];
				$this->data['form'] = [
					'study' => $event->study,
					'description' => $event->description,
					'title' => $event->title
				];
			}
		}

		$this->data['room'] = $room;

		$this->data['titleBar'] = $this->load->view('components/titleBar', $this->data, TRUE);
		$this->data['myRoom'] = $this->load->view('components/myRoom', $this->data, TRUE);
		$this->load->view('event', $this->data);
	}
}
