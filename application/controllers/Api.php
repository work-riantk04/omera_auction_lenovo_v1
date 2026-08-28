<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Bid_model', 'Item_model', 'Event_model', 'Notification_model']);
		$this->load->helper(['url', 'form']);
		$this->load->library(['session', 'form_validation']);
		header('Content-Type: application/json');
	}

	public function bid()
	{
		if (!$this->session->userdata('logged_in'))
		{
			echo json_encode(['status' => 'error', 'message' => 'You must be logged in.']);
			return;
		}

		$this->form_validation->set_rules('item_id', 'Item', 'required|integer');
		$this->form_validation->set_rules('amount', 'Bid Amount', 'required|numeric');

		if ($this->form_validation->run() === FALSE)
		{
			echo json_encode(['status' => 'error', 'message' => 'Invalid bid data.']);
			return;
		}

		$item_id = $this->input->post('item_id');
		$amount = $this->input->post('amount');
		$user_id = $this->session->userdata('user_id');

		$item = $this->Item_model->get_by_id($item_id);
		if (empty($item))
		{
			echo json_encode(['status' => 'error', 'message' => 'Item not found.']);
			return;
		}

		if ($item['status'] !== 'approved')
		{
			echo json_encode(['status' => 'error', 'message' => 'Item is not available for bidding.']);
			return;
		}

		$event = $this->Event_model->get_by_id($item['event_id']);
		if (empty($event) || $event['status'] !== 'active')
		{
			echo json_encode(['status' => 'error', 'message' => 'This auction is not active.']);
			return;
		}

		$highest_bid = $this->Bid_model->get_highest_bid($item_id);
		$min_bid = $this->Bid_model->compute_min_bid($item_id);
		$increment = (float) $item['min_increment'];

		if ($amount < $min_bid)
		{
			echo json_encode(['status' => 'error', 'message' => 'Bid must be at least Rp ' . number_format($min_bid, 0, ',', '.')]);
			return;
		}

		if ($increment > 0 && !$this->Bid_model->is_valid_bid_amount($item, $amount))
		{
			$next = number_format((float) $item['starting_price'] + $increment, 0, ',', '.');
			echo json_encode(['status' => 'error', 'message' => 'Bid harus kelipatan Rp ' . number_format($increment, 0, ',', '.') . ' dari harga awal (contoh: ' . $next . ', dst.)']);
			return;
		}

		$placed = $this->Bid_model->place_bid($item['event_id'], $item_id, $user_id, $amount);
		if ($placed === FALSE)
		{
			echo json_encode(['status' => 'error', 'message' => 'Bid could not be saved. Please try again.']);
			return;
		}

		$bids = $this->Bid_model->get_bids_by_item($item_id);
		$new_highest = $this->Bid_model->get_highest_bid($item_id);

		echo json_encode([
			'status' => 'success',
			'message' => 'Bid placed successfully.',
			'data' => [
				'bid_count' => $bids ? count($bids) : 0,
				'highest_bid' => (float) $new_highest['amount'],
				'highest_bidder' => (int) $new_highest['bidder_id']
			]
		]);
	}

	public function events($offset = 0)
	{
		$limit = 10;
		$offset = max(0, (int) $offset);
		$events = $this->Event_model->get_all($limit, $offset) ?: [];
		$total = $this->Event_model->count_all();

		echo json_encode([
			'status' => 'success',
			'data' => $events,
			'has_more' => ($offset + count($events)) < $total
		]);
	}

	public function countdown()
	{
		$events = $this->Event_model->get_active_events();
		$data = [];

		foreach ($events as $event)
		{
			$end_time = strtotime($event['end_date']);
			$now = time();
			$remaining = $end_time - $now;

			$data[] = [
				'event_id' => $event['id'],
				'end_date' => $event['end_date'],
				'remaining_seconds' => max(0, $remaining),
				'status' => $remaining > 0 ? 'active' : 'ended'
			];
		}

		echo json_encode(['status' => 'success', 'data' => $data]);
	}

	public function notifications_count()
	{
		if (!$this->session->userdata('logged_in'))
		{
			echo json_encode(['status' => 'error', 'message' => 'Not authenticated.']);
			return;
		}

		$user_id = $this->session->userdata('user_id');
		$count = $this->Notification_model->get_unread_count($user_id);

		echo json_encode(['status' => 'success', 'count' => $count]);
	}

	public function mark_notification_read($id)
	{
		if (!$this->session->userdata('logged_in'))
		{
			echo json_encode(['status' => 'error', 'message' => 'Not authenticated.']);
			return;
		}

		$this->Notification_model->mark_as_read($id);
		echo json_encode(['status' => 'success', 'message' => 'Notification marked as read.']);
	}
}
