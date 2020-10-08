<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_ketdisposisi extends CI_Model {
	
	
	public function tambah_ketdisposisi() {
        $data = array(
            'nama' => $this->input->post('nama'),
            
        );

        $this->db->insert('ket_disposisi', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function ubah_ketdisposisi() {
		
		
		$data = array(
			'nama' => $this->input->post('ubah_nama'),
			
		);
		
		
        $this->db->where('id', $this->input->post('ubah_id_disposisi'))
             ->update('ket_disposisi', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
		
    }
	
	public function get_ketdisposisi() {
        return $this->db->get('ket_disposisi')->result();
    }
	
	public function get_ketdisposisi_by_id($id) {
        return $this->db->where('id', $id)->get('ket_disposisi')
            ->row();
    }
	
	public function hapus_ketdisposisi($id) {
        $this->db->where('id', $id)
            ->delete('ket_disposisi');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
}