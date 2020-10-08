<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_memo extends CI_Model {
	
	    public function get_jumlah_memo() {
        $memo_masuk = $this->db->select('count(*) as total_memo_masuk')
            ->get('memo_masuk')->row();

        $memo_keluar = $this->db->select('count(*) as total_memo_keluar')
            ->get('memo_keluar')->row();

        return array(
            'memo_masuk' => $memo_masuk->total_memo_masuk,
            'memo_keluar' => $memo_keluar->total_memo_keluar
        );
    }
	
	public function tambah_memo_masuk($file_memo) {
        $data = array(
            'nomor_memo' => $this->input->post('nomor_memo'),
            'tgl_kirim' => $this->input->post('tgl_kirim'),
            'tgl_terima' => $this->input->post('tgl_terima'),
			'pengirim' => $this->input->post('pengirim'),
			'penerima' => $this->input->post('penerima'),
            'perihal' => $this->input->post('perihal'),
            'file_memo' => $file_memo['file_name']
        );

        $this->db->insert('memo_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function tambah_memo_keluar($file_memo) {
        $data = array(
            'nomor_memo' => $this->input->post('nomor_memo'),
            'tgl_kirim' => $this->input->post('tgl_kirim'),
            'tujuan' => $this->input->post('tujuan'),
            'perihal' => $this->input->post('perihal'),
            'file_memo' => $file_memo['file_name']
        );

        $this->db->insert('memo_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function ubah_memo_masuk() {
        $data = array(
            'nomor_memo' => $this->input->post('ubah_nomor_memo'),
            'tgl_kirim' => $this->input->post('ubah_tgl_kirim'),
            'tgl_terima' => $this->input->post('ubah_tgl_terima'),
            'pengirim' => $this->input->post('ubah_pengirim'),
            'penerima' => $this->input->post('ubah_penerima'),
            'perihal' => $this->input->post('ubah_perihal')
        );

        $this->db->where('id_memo', $this->input->post('ubah_id_memo'))
            ->update('memo_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function ubah_memo_keluar() {
        $data = array(
            'nomor_memo' => $this->input->post('ubah_nomor_memo'),
            'tgl_kirim' => $this->input->post('ubah_tgl_kirim'),
            'tujuan' => $this->input->post('ubah_tujuan'),
            'perihal' => $this->input->post('ubah_perihal'),
        );

        $this->db->where('id_memo', $this->input->post('ubah_id_memo'))
            ->update('memo_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function ubah_file_memo_masuk($file_memo) {
        $data = array(
            'file_memo' => $file_memo['file_name']
        );

        $this->db->where('id_memo', $this->input->post('ubah_file_memo'))
            ->update('memo_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function ubah_file_memo_keluar($file_memo) {
        $data = array(
            'file_memo' => $file_memo['file_name']
        );

        $this->db->where('id_memo', $this->input->post('ubah_file_memo'))
            ->update('memo_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function get_memo_masuk() {
        return $this->db->get('memo_masuk')->result();
    }
	
	public function get_memo_keluar() {
        return $this->db->get('memo_keluar')->result();
    }
	
	public function get_memo_masuk_by_id($id_memo) {
		$this->db->select('*, nomor_memo as nomor_surat'); 
        return $this->db->where('id_memo', $id_memo)->get('memo_masuk')
            ->row();
    }
	
	public function get_memo_keluar_by_id($id_memo) {
        return $this->db->where('id_memo', $id_memo)->get('memo_keluar')
            ->row();
    }
	
	public function get_nama_file_memo_masuk($id_memo) {
        return $this->db->where('id_memo', $id_memo)
            ->get('memo_masuk')->row()->file_memo;
    }
	
	public function get_nama_file_memo_keluar($id_memo) {
        return $this->db->where('id_memo', $id_memo)
            ->get('memo_keluar')->row()->file_memo;
    }
	
	public function cek_status_memo_masuk($id_memo) {
        $query = $this->db->where('id_memo', $id_memo)
            ->get('memo_masuk')->row()->status;

        if ($query == 'proses') {
            return true;
        } else {
            return false;
        }
    }
	
	public function hapus_memo_masuk($id_memo) {
        $this->db->where('id_memo', $id_memo)
            ->delete('memo_masuk');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function hapus_memo_keluar($id_memo) {
        $this->db->where('id_memo', $id_memo)
            ->delete('memo_keluar');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}