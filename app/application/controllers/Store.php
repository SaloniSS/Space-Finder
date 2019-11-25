<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	private function verifyLogin() {
		$this->user_id = $this->session->user_id;
		if (!$this->user_id) {
			header('Location: /login');
		} else {
			$userQuery = $this->db->get_where('user', ['user_id' => $this->user_id])->result();
			if ($userQuery) {
				$this->user = $userQuery[0];
			} else {
				header('Location: /login');
			}
		}
	}

	private function checkin($room_id) {
		$checkouts = $this->db->get_where('checkin', ['user_id' => $this->user->user_id])->result();
		foreach ($checkouts as $checkout) {
			$this->checkout($checkout->room_id);
		}

		$this->db->insert('checkin', ['room_id' => $room_id, 'user_id' => $this->user->user_id]);
	}

	private function deleteEvent($event_id) {
		$this->db->where(['id' => $event_id]);
		$this->db->delete('event');
	}

	private function checkout($room_id) {
		$this->db->where(['id' => $room_id]);
		$this->db->update('room', ['private' => false]);

		$checkin = $this->db->get_where('checkin', ['room_id' => $room_id])->result();
		if ($checkin) {
			$checkin = $checkin[0];
			$event_id = $checkin->event_id;
		}

		$this->db->where(['user_id' => $this->user->user_id, 'room_id' => $room_id]);
		$this->db->delete('checkin');

		if ($event_id) {
			$this->db->where(['room_id' => $room_id]);
			$eventCheckinCount = $this->db->count_all_results('checkin');
			if ($eventCheckinCount <= 0) {
				$this->deleteEvent($event_id);

				$this->db->where(['id' => $room_id]);
				$this->db->update('room', ['occupied' => false]);
			}
		} else {
			$this->db->update('room', ['occupied' => false]);
		}
	}

	public function checkinPage($room_id) {
		$this->verifyLogin();

		$checkouts = $this->db->get_where('checkin', ['room_id' => $room_id])->result();
		foreach ($checkouts as $checkout) {
			$this->db->where(['room_id' => $room_id]);
			$this->db->delete('checkin');

			if ($checkout->event_id) {
				$this->db->where(['id' => $checkout->event_id]);
				$this->db->delete('event');
			}
		}
		$this->checkin($room_id);

		$this->db->where(['id' => $room_id]);
		$this->db->update('room', ['private' => true, 'occupied' => true]);

		header('Location: /find/room/' . $room_id);
	}

	public function joinPage($room_id) {
		$this->verifyLogin();
		$this->checkin($room_id);

		$newCheckinId = $this->db->insert_id();

		$allCheckins = $this->db->get_where('checkin', ['room_id' => $room_id])->result();
		foreach ($allCheckins as $checkin) {
			if ($checkin->event_id) {
				$event_id = $checkin->event_id;
			}			
		}

		$this->db->where(['id' => $newCheckinId]);
		$this->db->update('checkin', ['event_id' => $event_id]);

		header('Location: /find/room/' . $room_id);
	}

	public function editEventPage($room_id) {
		$this->verifyLogin();
		if (!is_null($this->input->post('title')) && !is_null($this->input->post('description')) && !is_null($this->input->post('study'))) {
			$title = $this->input->post('title');
			$description = $this->input->post('description');
			$study = $this->input->post('study');

			$checkin = $this->db->get_where('checkin', ['user_id' => $this->user->user_id])->result();
			if ($checkin) {
				$checkin = $checkin[0];
				if ($checkin->event_id) {
					$this->db->where(['id' => $checkin->event_id]);
					$this->db->update('event', ['title' => $title, 'description' => $description, 'study' => $study]);
				} else {
					$this->db->insert('event', ['title' => $title, 'description' => $description, 'study' => $study]);
					$event_id = $this->db->insert_id();
					$this->db->where(['id' => $checkin->id]);
					$this->db->update('checkin', ['event_id' => $event_id]);
				}

				$this->db->where(['id' => $room_id]);
				$this->db->update('room', ['private' => false]);

				header('Location: /find/room/' . $room_id);
			} else {
				header('Location: /find');
			}
		} else {
			header('Location: /find');			
		}
	}

	public function checkoutPage() {
		$this->verifyLogin();
		$checkout = $this->db->get_where('checkin', ['user_id' => $this->user->user_id])->result();
		if ($checkout) {
			$checkout = $checkout[0];
			$this->checkout($checkout->room_id);
			header('Location: /find/room/' . $checkout->room_id);
		} else {
			header('Location: /find');			
		}
	}

}
