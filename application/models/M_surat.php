<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_surat extends CI_Model {
	
    public function get_jumlah_surat() {
        $surat_masuk = $this->db
		->select('count(*) as total_surat_masuk')
            ->get('surat_masuk')->row();

        $surat_keluar = $this->db->select('count(*) as total_surat_keluar')
            ->get('surat_keluar')->row();

        return array(
            'surat_masuk' => $surat_masuk->total_surat_masuk,
            'surat_keluar' => $surat_keluar->total_surat_keluar
        );
    }
	
	
	public function tambah_surat_masuk($file_surat) {
        $data = array(
            'nomor_surat' => $this->input->post('nomor_surat'),
            'tgl_kirim' => $this->input->post('tgl_kirim'),
            'tgl_terima' => $this->input->post('tgl_terima'),
			'pengirim' => $this->input->post('pengirim'),
			'penerima' => $this->input->post('penerima'),
            'perihal' => $this->input->post('perihal'),
            'file_surat' => $file_surat['file_name']
        );

        $this->db->insert('surat_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
		public function tambah_surat_keluar($file_surat) {
        $data = array(
            'nomor_surat' => $this->input->post('nomor_surat'),
            'tgl_kirim' => $this->input->post('tgl_kirim'),
            'tujuan' => $this->input->post('tujuan'),
            'perihal' => $this->input->post('perihal'),
            'file_surat' => $file_surat['file_name']
        );

        $this->db->insert('surat_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	 public function ubah_surat_masuk() {
        $data = array(
            'nomor_surat' => $this->input->post('ubah_nomor_surat'),
            'tgl_kirim' => $this->input->post('ubah_tgl_kirim'),
            'tgl_terima' => $this->input->post('ubah_tgl_terima'),
            'pengirim' => $this->input->post('ubah_pengirim'),
            'penerima' => $this->input->post('ubah_penerima'),
            'perihal' => $this->input->post('ubah_perihal')
        );

        $this->db->where('id_surat', $this->input->post('ubah_id_surat'))
            ->update('surat_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
		public function ubah_surat_keluar() {
        $data = array(
            'nomor_surat' => $this->input->post('ubah_nomor_surat'),
            'tgl_kirim' => $this->input->post('ubah_tgl_kirim'),
            'tujuan' => $this->input->post('ubah_tujuan'),
            'perihal' => $this->input->post('ubah_perihal'),
        );

        $this->db->where('id_surat', $this->input->post('ubah_id_surat'))
            ->update('surat_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function ubah_file_surat_masuk($file_surat) {
        $data = array(
            'file_surat' => $file_surat['file_name']
        );

        $this->db->where('id_surat', $this->input->post('ubah_file_surat'))
            ->update('surat_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
		public function ubah_file_surat_keluar($file_surat) {
        $data = array(
            'file_surat' => $file_surat['file_name']
        );

        $this->db->where('id_surat', $this->input->post('ubah_file_surat'))
            ->update('surat_keluar', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function get_surat_masuk() {
        return $this->db->get('surat_masuk')->result();
    }
	
		public function get_surat_keluar() {
        return $this->db->get('surat_keluar')->result();
    }
	
	public function get_surat_masuk_by_id($id_surat) {
        return $this->db->where('id_surat', $id_surat)->get('surat_masuk')
            ->row();
    }
	
		public function get_surat_keluar_by_id($id_surat) {
        return $this->db->where('id_surat', $id_surat)->get('surat_keluar')
            ->row();
    }
	
	public function get_nama_file_surat_masuk($id_surat) {
        return $this->db->where('id_surat', $id_surat)
            ->get('surat_masuk')->row()->file_surat;
    }
	
		public function get_nama_file_surat_keluar($id_surat) {
        return $this->db->where('id_surat', $id_surat)
            ->get('surat_keluar')->row()->file_surat;
    }
	
	public function cek_status_surat_masuk($id_surat) {
        $query = $this->db->where('id_surat', $id_surat)
            ->get('surat_masuk')->row()->status;

        if ($query == 'proses') {
            return true;
        } else {
            return false;
        }
    }
	
	public function hapus_surat_masuk($id_surat) {
        $this->db->where('id_surat', $id_surat)
            ->delete('surat_masuk');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	

	public function hapus_surat_keluar($id_surat) {
        $this->db->where('id_surat', $id_surat)
            ->delete('surat_keluar');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
}