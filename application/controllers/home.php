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
			$data["close"] = $closest;
			$data["all"] = $locations;
			$this->load->view("locate_results", $data);
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
}
