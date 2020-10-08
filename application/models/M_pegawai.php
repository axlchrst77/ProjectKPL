<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_pegawai extends CI_Model {
	
	public function tambah_user() {
        $data = array(
			'nip' => $this->input->post('nip'),
            'username' => $this->input->post('nik'),
            'nama_pegawai' => $this->input->post('nama'),
            'id_unit' => $this->input->post('unit'),
            'password' => md5($this->input->post('password')),
            
        );

        $this->db->insert('pegawai', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function ubah_user() {
		
		if($this->input->post('ubah_password')==''){
				$data = array(
				'nip' => $this->input->post('ubah_nip'),
				'username' => $this->input->post('ubah_nik'),
				'nama_pegawai' => $this->input->post('ubah_nama'),
				'id_unit' => $this->input->post('ubah_unit'),
			);

		} else {
			$data = array(
				'nip' => $this->input->post('ubah_nip'),
				'username' => $this->input->post('ubah_nik'),
				'nama_pegawai' => $this->input->post('ubah_nama'),
				'id_unit' => $this->input->post('ubah_unit'),
				'password' => md5($this->input->post('ubah_password')),
			);
		}
		
		
        $this->db->where('id_pegawai', $this->input->post('ubah_id_user'))
             ->update('pegawai', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
		
    }
	
	public function get_pegawai() {
        return $this->db
		       ->join('unit', 'pegawai.id_unit = unit.id_unit')
		       ->get('pegawai')->result();
    }

	public function get_pegawai_by_id($id_user) {
        return $this->db->where('id_pegawai', $id_user)->get('pegawai')
            ->row();
    }
	
	public function get_pegawai_by_unit($id_unit) {
        return $this->db->where('id_unit', $id_unit)
            ->get('pegawai')->result();
    }
	
	public function hapus_user($id_user) {
        $this->db->where('id_pegawai', $id_user)
            ->delete('pegawai');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
}