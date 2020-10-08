<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_disposisi extends CI_Model {
	
	public function get_jumlah_disposisi() {
        $disposisi_keluar = $this->db
            ->select('count(id_pegawai_pengirim) as total_disposisi_keluar')
            ->where('id_pegawai_pengirim', $this->session->userdata('id_pegawai'))
            ->get('disposisi')->row();

        $disposisi_masuk = $this->db
            ->select('count(id_pegawai_penerima) as total_disposisi_masuk')
            ->where('id_pegawai_penerima', $this->session->userdata('id_pegawai'))
            ->get('disposisi')->row();

        return array(
            'disposisi_keluar' => $disposisi_keluar->total_disposisi_keluar,
            'disposisi_masuk' => $disposisi_masuk->total_disposisi_masuk
        );
    }
	
	public function tambah_disposisi($id_surat) {
		$data_pegawai = $this->db->get_where('pegawai', ['id_pegawai' => $this->input->post('tujuan_pegawai')])->row();
		if($data_pegawai){
			$id_unit = $data_pegawai->id_unit;
		} else {
			$id_unit = 0;
		}
        $data = array(
            'id_surat' => $id_surat,
            'id_unit_pengirim' => $id_unit,
			'id_pegawai_pengirim' => $this->session->userdata('id_pegawai'),
            'id_pegawai_penerima' => $this->input->post('tujuan_pegawai'),
            'keterangan' => $this->input->post('keterangan'),
			'catatan' => $this->input->post('catatan')
        );

        $this->db->insert('disposisi', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function disposisi_selesai($id_surat) {
        $data['status'] = 'selesai';

        $this->db->where('id_surat', $id_surat)
            ->update('surat_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function get_disposisi($id_surat) {
        return $this->db->join('disposisi', 'disposisi.id_surat = surat_masuk.id_surat')
            ->join('unit', 'disposisi.id_unit_pengirim = unit.id_unit')
            ->join('pegawai', 'disposisi.id_pegawai_penerima = pegawai.id_pegawai')
            ->where('disposisi.id_surat', $id_surat)
            ->get('surat_masuk')->result();
    }
	
	public function get_disposisi_masuk($id_pegawai) {
        return $this->db->join('disposisi', 'disposisi.id_surat = surat_masuk.id_surat')
            ->join('pegawai', 'disposisi.id_pegawai_pengirim = pegawai.id_pegawai')
            ->join('unit', 'unit.id_unit = pegawai.id_unit')
            ->where('id_pegawai_penerima', $id_pegawai)
            ->get('surat_masuk')->result();
    }
	
	public function get_disposisi_keluar($id_surat) {
        return $this->db->join('disposisi', 'disposisi.id_surat = surat_masuk.id_surat')
            ->join('pegawai', 'disposisi.id_pegawai_penerima = pegawai.id_pegawai')
            ->join('unit', 'unit.id_unit = pegawai.id_unit')
            ->where('disposisi.id_pegawai_pengirim', $this->session->userdata('id_unit'))
            ->where('disposisi.id_surat', $id_surat)
            ->get('surat_masuk')->result();
    }
	
	public function get_all_disposisi_keluar() {
        return $this->db->join('disposisi', 'disposisi.id_surat = surat_masuk.id_surat')
            ->join('pegawai', 'disposisi.id_pegawai_penerima = pegawai.id_pegawai')
            ->join('unit', 'unit.id_unit = pegawai.id_unit')
            ->where('disposisi.id_pegawai_pengirim', $this->session->userdata('id_pegawai'))
            ->get('surat_masuk')->result();
    }
	
	public function hapus_disposisi($id_disposisi) {
        $this->db->where('id_disposisi', $id_disposisi)
            ->delete('disposisi');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
}