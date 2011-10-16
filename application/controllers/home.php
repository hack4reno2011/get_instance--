<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->view('home');
	}

	public function result_set()
	{
		@$zip = $this->input->post("zip_code");
		@$station = $this->input->post("station_number");
		if ($zip) {
			$q = $this->db->from("stations")->where("station_zip", $zip)->get();
		} elseif ($station) {
			$q = $this->db->from("stations")->where("station_num", $station)->get();
		} else {
			$this->session->set_flashdata("error", "I am not able to search without search criteria");
			redirect("");
			exit();
		}
		if ($q->num_rows() > 0) {
			$data = array();
			$data["set"] = array();
			$data["debug"] = $this->db->last_query();
			foreach($q->result() AS $r) {
				$data["set"][] = $r;
			}
			$this->load->view("result_set", $data);
		} else {
			$this->session->set_flashdata("error", "I was not able to locate any data with those parameters.");
			redirect("");
			exit();
		}
	}
}