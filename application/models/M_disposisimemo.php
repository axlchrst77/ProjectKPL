<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_disposisimemo extends CI_Model {
	
	public function get_jumlah_disposisi_memo() {
        $disposisi_keluar = $this->db
            ->select('count(id_pegawai_pengirim) as total_disposisi_keluar')
            ->where('id_pegawai_pengirim', $this->session->userdata('id_pegawai'))
            ->get('disposisi_memo')->row();

        $disposisi_masuk = $this->db
            ->select('count(id_pegawai_penerima) as total_disposisi_masuk')
            ->where('id_pegawai_penerima', $this->session->userdata('id_pegawai'))
            ->get('disposisi_memo')->row();

        return array(
            'disposisi_keluar' => $disposisi_keluar->total_disposisi_keluar,
            'disposisi_masuk' => $disposisi_masuk->total_disposisi_masuk
        );
    }
	
	public function tambah_disposisi_memo($id_memo) {
		$data_pegawai = $this->db->get_where('pegawai', ['id_pegawai' => $this->input->post('tujuan_pegawai')])->row();
		if($data_pegawai){
			$id_unit = $data_pegawai->id_unit;
		} else {
			$id_unit = 0;
		}
        $data = array(
            'id_memo' => $id_memo,
            'id_unit_pengirim' =>  $id_unit,
			'id_pegawai_pengirim' => $this->session->userdata('id_pegawai'),
            'id_pegawai_penerima' => $this->input->post('tujuan_pegawai'),
            'keterangan' => $this->input->post('keterangan'),
			'catatan' => $this->input->post('catatan')
        );

        $this->db->insert('disposisi_memo', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function disposisi_memo_selesai($id_memo) {
        $data['status'] = 'selesai';

        $this->db->where('id_memo', $id_memo)
            ->update('memo_masuk', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
	public function get_disposisi_memo($id_memo) {
        return $this->db->join('disposisi_memo', 'disposisi_memo.id_memo = memo_masuk.id_memo')
            ->join('unit', 'disposisi_memo.id_unit_pengirim = unit.id_unit')
            ->join('pegawai', 'disposisi_memo.id_pegawai_penerima = pegawai.id_pegawai')
            ->where('disposisi_memo.id_memo', $id_memo)
            ->get('memo_masuk')->result();
    }
	
	public function get_disposisi_memo_masuk($id_pegawai) {
        return $this->db->join('disposisi_memo', 'disposisi_memo.id_memo = memo_masuk.id_memo')
            ->join('pegawai', 'disposisi_memo.id_pegawai_penerima = pegawai.id_pegawai')
            ->join('unit', 'unit.id_unit = pegawai.id_unit')
            ->where('id_pegawai_penerima', $id_pegawai)
            ->get('memo_masuk')->result();
    }
	
	public function get_disposisi_memo_keluar($id_memo) {
        return $this->db->join('disposisi_memo', 'disposisi_memo.id_memo = memo_masuk.id_memo')
            ->join('pegawai', 'disposisi_memo.id_pegawai_penerima = pegawai.id_pegawai')
            ->join('unit', 'unit.id_unit = pegawai.id_unit')
            ->where('disposisi_memo.id_pegawai_pengirim', $this->session->userdata('id_unit'))
            ->where('disposisi_memo.id_memo', $id_memo)
            ->get('memo_masuk')->result();
    }
	
	public function get_all_disposisi_memo_keluar() {
        return $this->db->join('disposisi_memo', 'disposisi_memo.id_memo = memo_masuk.id_memo')
            ->join('pegawai', 'disposisi_memo.id_pegawai_penerima = pegawai.id_pegawai')
            ->join('unit', 'unit.id_unit = pegawai.id_unit')
            ->where('disposisi_memo.id_pegawai_pengirim', $this->session->userdata('id_pegawai'))
            ->get('memo_masuk')->result();
    }
	
	public function hapus_disposisi_memo($id_disposisi) {
        $this->db->where('id_disposisi', $id_disposisi)
            ->delete('disposisi_memo');

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
	
}