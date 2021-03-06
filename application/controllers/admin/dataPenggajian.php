<?php
class dataPenggajian extends CI_Controller
{
  public function index()
  {
    $data['judul'] = 'Data Gaji Pegawai';

    if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
      $bulan = $_GET['bulan'];
      $tahun = $_GET['tahun'];
      $bulantahun = $bulan . $tahun;
    } else {
      $bulan = date('m');
      $tahun = date('Y');

      $bulantahun = $bulan . $tahun;
    }

    // Ambil Data Potongan Gaji
    $data['potongan'] = $this->penggajianModel->getData('potongan_gaji')->result();

    // Query
    $data['gaji'] = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jenis_kelamin, data_jabatan.nama_jabatan, data_jabatan.gaji_pokok, data_jabatan.tj_transport, data_jabatan.uang_makan, data_kehadiran.alpha
    FROM data_pegawai
    INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik
    INNER JOIN data_jabatan ON data_jabatan.nama_jabatan=data_pegawai.jabatan
    WHERE data_kehadiran.bulan='$bulantahun'
    ORDER BY data_pegawai.nama_pegawai ASC
    ")->result();


    //Load view
    $this->load->view('templates_admin/header', $data);
    $this->load->view('templates_admin/sidebar');
    $this->load->view('admin/dataGaji', $data);
    $this->load->view('templates_admin/footer');
  }

  public function cetakGaji()
  {
    $data['judul'] = 'Cetak Data Gaji Pegawai';

    if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
      $bulan = $_GET['bulan'];
      $tahun = $_GET['tahun'];
      $bulantahun = $bulan . $tahun;
    } else {
      $bulan = date('m');
      $tahun = date('Y');
      $bulantahun = $bulan . $tahun;
    }
    // Ambil Data Potongan Gaji
    $data['potongan'] = $this->penggajianModel->getData('potongan_gaji')->result();
    // Query
    $data['cetakGaji'] = $this->db->query("SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jenis_kelamin, data_jabatan.nama_jabatan, data_jabatan.gaji_pokok, data_jabatan.tj_transport, data_jabatan.uang_makan, data_kehadiran.alpha
    FROM data_pegawai
    INNER JOIN data_kehadiran ON data_kehadiran.nik=data_pegawai.nik
    INNER JOIN data_jabatan ON data_jabatan.nama_jabatan=data_pegawai.jabatan
    WHERE data_kehadiran.bulan='$bulantahun'
    ORDER BY data_pegawai.nama_pegawai ASC")->result();
    // echo $this->db->last_query();
    // exit();

    //Load view
    $this->load->view('templates_admin/header', $data);
    $this->load->view('admin/cetakDataGaji', $data);
  }
}
