<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_model extends CI_Model
{

    public function select($id = null)
    {
        if ($id == null) {
            $data = $this->db->get('permintaan')->result();
            foreach ($data as $key => $value) {
                $value->pelanggan = $this->db->get_where('pelanggan', ['id' => $value->pelangganid])->row_array();
                $value->karyawan = $this->db->get_where('karyawan', ['id' => $value->karyawanid])->row_array();
            }
            return $data;
        } else {
            $data = $this->db->get_where('permintaan', ['id' => $id])->row_array();
            $data['pelanggan'] = $this->db->get_where('pelanggan', ['id' => $data['pelangganid']])->row_array();
            $data['karyawan'] = $this->db->get_where('karyawan', ['id' => $data['karyawanid']])->row_array();
            return $data;
        }
    }
    public function insert($data)
    {
        $this->db->trans_begin();
        $itempermintaan = [
            'noregister' => $data['noregister'],
            'tanggal' => $data['tanggal'],
            'namapemohon' => $data['namapemohon'],
            'status' => $data['status'],
            'pelangganid' => $data['pelanggan']['pelangganid'],
        ];
        $this->db->insert('permintaan', $itempermintaan);
        $data['id'] = $this->db->insert_id();
        if ($result) {
            return $data;
        } else {
            return false;
        }

    }
    public function update($data)
    {
        $this->db->trans_begin();
        $itemusaha = [
            'alamat' => $data['usaha']['alamat'],
            'lat' => $data['usaha']['lat'],
            'long' => $data['usaha']['long'],
            'kategoriid' => $data['usaha']['kategoriid'],
            'permintaanid' => $data['id'],
            'status' => 'true',
            'luas' => $data['luas'],
            'jenisbangunan' => $data['jenisbangunan'],
            'statustempatusaha' => $data['statustempatusaha'],
            'jumlahpegawai' => $data['jumlahpegawai'],
            'distrik' => $data['distrik'],
        ];
        $this->db->where('id', $data['usaha']['id']);
        $this->db->update('usaha', $item);
        $itempermintaan = [
            'nik' => $data['nik'],
            'nama' => $data['nama'],
            'jk' => $data['jk'],
            'nopermintaan' => $data['nopermintaan'],
            'alamat' => $data['alamat'],
            'kontak' => $data['kontak'],
            'email' => $data['email'],
            'petugasid' => $this->session->userdata('id'),
        ];
        $this->db->where('id', $data['id']);
        $this->db->update('permintaan', $itempermintaan);
        if ($this->db->trans_status()) {
            $this->db->trans_commit();
            return $data;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('permintaan');
    }

}

/* End of file Kategori_model.php */
