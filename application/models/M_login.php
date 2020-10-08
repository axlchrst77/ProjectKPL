<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function check_user() {
        $query = $this->db->join('unit', 'unit.id_unit = pegawai.id_unit')
            ->where('username', $this->input->post('nik'))
            ->where('password', md5($this->input->post('password')))
            ->get('pegawai');

        if ($query->num_rows() > 0) {
            $data_pegawai = $query->row();
            $session = array(
                'logged_in' => true,
                'nik' => $data_pegawai->username,
                'id_pegawai' => $data_pegawai->id_pegawai,
                'id_unit' => $data_pegawai->id_unit,
                'nama_pegawai' => $data_pegawai->nama_pegawai,
                'nama_unit' => $data_pegawai->nama_unit,
                'level' => $data_pegawai->level
            );

            $this->session->set_userdata($session);
            return true;
        } else {
            return false;
        }
    }

}