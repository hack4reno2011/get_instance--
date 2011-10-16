<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->view('home');
	}

// Robert created this 
	public function locate()
	{
		$this->load->view('locate');
	}

	public function locate_station()
	{
		@$address = $this->input->post("address");
		if ($address) {
			$q = $this->db->from("stations")
				->select("station_address, station_city, station_zip")
				->where("station_zip >", 0)
				->get();
			$stations = "";
			foreach($q->result() AS $r) {
				$stations .= $r->station_address . " " . $r->station_city . ", NV " . $r->station_zip . "|";
			}
			$stations = trim($stations, "|");
			$url = "http://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($address) . "&destinations=" . urlencode($stations) . "&sensor=false&units=imperial";
			$json = file_get_contents($url);
			$locations = json_decode($json);
			$closest = array();
			foreach($locations->rows["0"]->elements AS $k => $v) {
				$closest[$k] = $v->duration->value;
			}
			asort($closest);
			$closest = array_slice($closest, 0, 3, TRUE);
			$close = $closest;
			$all = $locations;
			$data = array();
			foreach($close AS $station => $d) {
				$addressa = explode(",", $all->destination_addresses[$station]);
				$address = explode(" ", $addressa[0]);
				$address =  $address[0] . " " . substr($address[1], 0, 4);

				$q = $this->db->select("station_num")->from("stations")->like("station_address", $address)->get();
				$station_id = 0;
				if ($q->num_rows() == 1) {
					$r = $q->row();
					$station_id = $r->station_num;
				}
				echo "&bull; <a href='home/result_set/" . $station_id . "'>Station #" . $station_id . " @ " . $all->destination_addresses[$station] . "</a> (" . $all->rows["0"]->elements[$station]->distance->text . ")<br />";
			}
			
		}
	}

	public function result_set()
	{
		@$zip = $this->input->post("zip_code");
		@$station = $this->input->post("station_number");
		if ($zip) {
			$q = $this->db->from("stations")->where("station_zip", $zip)->get();
			$for = "Zip Code " . $zip;
		} elseif ($station) {
			$q = $this->db->from("stations")->where("station_num", $station)->get();
			$for = "Station #" . $station;
		} else if ($this->uri->segment(3)) {
			$q = $this->db->from("stations")->where("id", $this->uri->segment(3))->get();
			$for = "Station #" . $this->uri->segment(3);
		} else {
			$this->session->set_flashdata("error", "I am not able to search without search criteria");
			redirect("");
			exit();
		}
		if ($q->num_rows() > 0) {
			$data = array();
			$data["set"] = array();
			$data["for"] = $for;
			
			foreach($q->result() AS $r) {
				$data["set"][] = $r;
			}
			if ($this->agent->is_mobile()) {
				$this->load->view("result_set_mobile", $data);
			} else {
				$this->load->view("result_set", $data);
			}
		} else {
			$this->session->set_flashdata("error", "I was not able to locate any data with those parameters.");
			redirect("");
			exit();
		}
	}

	public function save_feedback()
	{
		if ($this->input->is_ajax_request()) {
			//if ($this->session->userdata("flood_control") > 10) {
			//	echo "Could not save feedback.";
			//	exit();
			//} else {
				@$flood = $this->session->userdata("flood_control");
				if (!$flood) {
					$flood = 0;
				}
				$flood++;
				$this->session->set_userdata(array("flood_control" => $flood));
				@$name = $this->input->post("name");
				@$rating = $this->input->post("rating");
				if ($rating < 1 || $rating > 5) {
					$rating = 3;
				}
				@$comments = $this->input->post("comments");
				@$station_id = $this->input->post("station_id");
				$insert = array("feedback_id" => NULL,
				"station_id" => $station_id,
				"user_name" => $name,
				"rating" => $rating,
				"rated_dtm" => date("Y-m-d g:i:s"),
				"user_comments" => $comments);
				$this->db->insert("user_feedback", $insert);
				$q = $this->db->from("user_feedback")->where("station_id", $station_id)->get();
				$totals = array();
				$comments = "";
				foreach($q->result() AS $r) {
					$totals[] = $r->rating;
					$comments .= "<hr />" . $r->user_comments;
				}
				echo "<p>" . count($totals) . " user(s) rate this station an average of " . number_format(array_sum($totals) / count($totals), 2) . "</p><h2>User Comments</h2>";
				echo $comments;
				echo "<hr />";
			//}
		}
	}
}
