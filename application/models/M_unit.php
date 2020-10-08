<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_unit extends CI_Model {
	
	public function tambah_unit() {
        $data = array(
            'nama_unit' => $this->input->post('nama'),
            'level' => $this->input->post('level'),
            
        );

        $this->db->insert('unit', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function ubah_unit() {
		
		
		$data = array(
			'nama_unit' => $this->input->post('ubah_nama'),
			'level' => $this->input->post('ubah_level'),
		);
		
		
        $this->db->where('id_unit', $this->input->post('ubah_id_unit'))
             ->update('unit', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
		
    }
	
	public function get_unit() {
        return $this->db->get('unit')->result();
    }
	
	public function get_unit_by_id($id_unit) {
        return $this->db->where('id_unit', $id_unit)->get('unit')
            ->row();
    }
	
	public function hapus_unit($id_unit) {
        $this->db->where('id_unit', $id_unit)
            ->delete('unit');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}