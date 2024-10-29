<?php
defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */

// use namespace
use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

/**
 * 
 */
class Karyawan extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db2 = $this->load->database('db2', TRUE);
        $this->db_absensi = $this->load->database('db_absensi', TRUE);


        $this->load->model('master/M_Karyawan');
    }

    public function index_get()
    {
        $nik = $this->get('nik_baru');
        $lokasi_struktur = $this->get('lokasi_struktur');
        $keyword = $this->get('keyword');


        $karyawan = $this->M_Karyawan->getKaryawan($lokasi_struktur, $nik, $keyword);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    public function index_induk_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'nama_lengkap' => $this->post('nama_lengkap') != null ? $this->post('nama_lengkap') : '-',
            'foto' => $this->post('foto') != null ? $this->post('foto') : '-',
            'digit_ktp' => $this->post('digit_ktp') != null ? $this->post('digit_ktp') : '-',
            'digit_npwp' => $this->post('digit_npwp') != null ? $this->post('digit_npwp') : '-',
            'digit_bpjs_ket' => $this->post('digit_bpjs_ket') != null ? $this->post('digit_bpjs_ket') : '-',
            'digit_bpjs_kes' => $this->post('digit_bpjs_kes') != null ? $this->post('digit_bpjs_kes') : '-',
            'digit_bpjs_kes_suami_istri' => $this->post('digit_bpjs_kes_suami_istri') != null ? $this->post('digit_bpjs_kes_suami_istri') : '-',
            'digit_bpjs_kes_anak_1' => $this->post('digit_bpjs_kes_anak_1') != null ? $this->post('digit_bpjs_kes_anak_1') : '-',
            'digit_bpjs_kes_anak_2' => $this->post('digit_bpjs_kes_anak_2') != null ? $this->post('digit_bpjs_kes_anak_2') : '-',
            'digit_bpjs_kes_anak_3' => $this->post('digit_bpjs_kes_anak_3') != null ? $this->post('digit_bpjs_kes_anak_3') : '-',
            'digit_kk' => $this->post('digit_kk') != null ? $this->post('digit_kk') : '-',
            'sim_a' => $this->post('sim_a') != null ? $this->post('sim_a') : '-',
            'sim_b' => $this->post('sim_b') != null ? $this->post('sim_b') : '-',
            'sim_b1' => $this->post('sim_b1') != null ? $this->post('sim_b1') : '-',
            'sim_b1_umum' => $this->post('sim_b1_umum') != null ? $this->post('sim_b1_umum') : '-',
        ];

        if ($this->M_Karyawan->createDataInduk($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_detail_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'tanggal_lahir' => $this->post('tanggal_lahir') != null ? $this->post('tanggal_lahir') : '-',
            'tempat_lahir' => $this->post('tempat_lahir') != null ? $this->post('tempat_lahir') : '-',
            'jenis_kelamin' => $this->post('jenis_kelamin') != null ? $this->post('jenis_kelamin') : '-',
            'status_pernikahan' => $this->post('status_pernikahan') != null ? $this->post('status_pernikahan') : '-',
            'gol_darah' => $this->post('gol_darah') != null ? $this->post('gol_darah') : '-',
            'agama' => $this->post('agama') != null ? $this->post('agama') : '-',
            'suku' => $this->post('suku') != null ? $this->post('suku') : '-',
            'tinggi_badan' => $this->post('tinggi_badan') != null ? $this->post('tinggi_badan') : '-',
            'berat_badan' => $this->post('berat_badan') != null ? $this->post('berat_badan') : '-',
            'kewarganegaraan' => $this->post('kewarganegaraan') != null ? $this->post('kewarganegaraan') : '-',
            'alamat_ktp' => $this->post('alamat_ktp') != null ? $this->post('alamat_ktp') : '-',
            'no_telp' => $this->post('no_telp') != null ? $this->post('no_telp') : '-',
            'no_hp' => $this->post('no_hp') != null ? $this->post('no_hp') : '-',
            'email' => $this->post('email') != null ? $this->post('email') : '-',
            'alamat_domisili' => $this->post('alamat_domisili') != null ? $this->post('alamat_domisili') : '-',
        ];

        if ($this->M_Karyawan->createDataDetail($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_keluarga_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'nama_keluarga' => $this->post('nama_keluarga') != null ? $this->post('nama_keluarga') : '-',
            'no_ktp_keluarga' => $this->post('no_ktp_keluarga') != null ? $this->post('no_ktp_keluarga') : '-',
            'tanggal_lahir_keluarga' => $this->post('tanggal_lahir_keluarga') != null ? $this->post('tanggal_lahir_keluarga') : '-',
            'tempat_lahir_keluarga' => $this->post('tempat_lahir_keluarga') != null ? $this->post('tempat_lahir_keluarga') : '-',
            'gol_darah_keluarga' => $this->post('gol_darah_keluarga') != null ? $this->post('gol_darah_keluarga') : '-',
            'agama_keluarga' => $this->post('agama_keluarga') != null ? $this->post('agama_keluarga') : '-',
            'suku_keluarga' => $this->post('suku_keluarga') != null ? $this->post('suku_keluarga') : '-',
            'kewarganegaraan_keluarga' => $this->post('kewarganegaraan_keluarga') != null ? $this->post('kewarganegaraan_keluarga') : '-',
            'pendidikan_keluarga' => $this->post('pendidikan_keluarga') != null ? $this->post('pendidikan_keluarga') : '-',
        ];

        if ($this->M_Karyawan->createDataKeluarga($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_keluarga_susunan_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'nama_ayah' => $this->post('nama_ayah') != null ? $this->post('nama_ayah') : '-',
            'tanggal_lahir_ayah' => $this->post('tanggal_lahir_ayah') != null ? $this->post('tanggal_lahir_ayah') : '-',
            'jenis_kelamin_ayah' => $this->post('jenis_kelamin_ayah') != null ? $this->post('jenis_kelamin_ayah') : '-',
            'pekerjaan_ayah' => $this->post('pekerjaan_ayah') != null ? $this->post('pekerjaan_ayah') : '-',
            'pendidikan_ayah' => $this->post('pendidikan_ayah') != null ? $this->post('pendidikan_ayah') : '-',
            'nama_ibu' => $this->post('nama_ibu') != null ? $this->post('nama_ibu') : '-',
            'tanggal_lahir_ibu' => $this->post('tanggal_lahir_ibu') != null ? $this->post('tanggal_lahir_ibu') : '-',
            'jenis_kelamin_ibu' => $this->post('jenis_kelamin_ibu') != null ? $this->post('jenis_kelamin_ibu') : '-',
            'pekerjaan_ibu' => $this->post('pekerjaan_ibu') != null ? $this->post('pekerjaan_ibu') : '-',
            'pendidikan_ibu' => $this->post('pendidikan_ibu') != null ? $this->post('pendidikan_ibu') : '-',
        ];

        if ($this->M_Karyawan->createDataSusunanKeluarga($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_anak_post()
    {
        $getNik = $this->M_Karyawan->get_NoUrut($this->post('nik_baru'));
        foreach ($getNik as $row) {
            $no_urut = $row['no_urut'];
        }

        $data = [
            'no_urut' => $no_urut,
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'urutan_anak' => $this->post('urutan_anak') != null ? $this->post('urutan_anak') : '-',
            'nama_anak' => $this->post('nama_anak') != null ? $this->post('nama_anak') : '-',
            'no_ktp_anak' => $this->post('no_ktp_anak') != null ? $this->post('no_ktp_anak') : '-',
            'tanggal_lahir_anak' => $this->post('tanggal_lahir_anak') != null ? $this->post('tanggal_lahir_anak') : '-',
            'tempat_lahir_anak' => $this->post('tempat_lahir_anak') != null ? $this->post('tempat_lahir_anak') : '-',
            'gol_darah_anak' => $this->post('gol_darah_anak') != null ? $this->post('gol_darah_anak') : '-',
            'agama_anak' => $this->post('agama_anak') != null ? $this->post('agama_anak') : '-',
            'suku_anak' => $this->post('suku_anak') != null ? $this->post('suku_anak') : '-',
            'kewarganegaraan_anak' => $this->post('kewarganegaraan_anak') != null ? $this->post('kewarganegaraan_anak') : '-',
            'pendidikan_anak' => $this->post('pendidikan_anak') != null ? $this->post('pendidikan_anak') : '-',
        ];

        if ($this->M_Karyawan->createDataAnak($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_darurat_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'nama_darurat' => $this->post('nama_darurat') != null ? $this->post('nama_darurat') : '-',
            'no_hp_darurat' => $this->post('no_hp_darurat') != null ? $this->post('no_hp_darurat') : '-',
            'alamat_darurat' => $this->post('alamat_darurat') != null ? $this->post('alamat_darurat') : '-',
        ];

        if ($this->M_Karyawan->createDarurat($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_saudara_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'urutan_saudara' => $this->post('urutan_saudara') != null ? $this->post('urutan_saudara') : '-',
            'nama_saudara' => $this->post('nama_saudara') != null ? $this->post('nama_saudara') : '-',
            'tanggal_lahir_saudara' => $this->post('tanggal_lahir_saudara') != null ? $this->post('tanggal_lahir_saudara') : '-',
            'jenis_kelamin_saudara' => $this->post('jenis_kelamin_saudara') != null ? $this->post('jenis_kelamin_saudara') : '-',
            'pekerjaan_saudara' => $this->post('pekerjaan_saudara') != null ? $this->post('pekerjaan_saudara') : '-',
            'pendidikan_saudara' => $this->post('pendidikan_saudara') != null ? $this->post('pendidikan_saudara') : '-',
        ];

        if ($this->M_Karyawan->createSaudara($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',

            'status_sd' => $this->post('status_sd') != null ? $this->post('status_sd') : '-',
            'nama_sd' => $this->post('nama_sd') != null ? $this->post('nama_sd') : '-',
            'tahun_sd' => $this->post('tahun_sd') != null ? $this->post('tahun_sd') : '-',
            'ket_sd' => $this->post('ket_sd') != null ? $this->post('ket_sd') : '-',
            'nilai_sd' => $this->post('nilai_sd') != null ? $this->post('nilai_sd') : '-',

            'status_smp' => $this->post('status_smp') != null ? $this->post('status_smp') : '-',
            'nama_smp' => $this->post('nama_smp') != null ? $this->post('nama_smp') : '-',
            'tahun_smp' => $this->post('tahun_smp') != null ? $this->post('tahun_smp') : '-',
            'ket_smp' => $this->post('ket_smp') != null ? $this->post('ket_smp') : '-',
            'nilai_smp' => $this->post('nilai_smp') != null ? $this->post('nilai_smp') : '-',

            'status_smk' => $this->post('status_smk') != null ? $this->post('status_smk') : '-',
            'nama_smk' => $this->post('nama_smk') != null ? $this->post('nama_smk') : '-',
            'jurusan_smk' => $this->post('jurusan_smk') != null ? $this->post('jurusan_smk') : '-',
            'tahun_smk' => $this->post('tahun_smk') != null ? $this->post('tahun_smk') : '-',
            'ket_smk' => $this->post('ket_smk') != null ? $this->post('ket_smk') : '-',
            'nilai_smk' => $this->post('nilai_smk') != null ? $this->post('nilai_smk') : '-',

            'nama_st' => $this->post('nama_st')  != null ? $this->post('nama_st') : '-',
            'jurusan_st' => $this->post('jurusan_st') != null ? $this->post('jurusan_st') : '-',
            'tahun_st' => $this->post('tahun_st') != null ? $this->post('tahun_st') : '-',
            'ket_st' => $this->post('ket_st') != null ? $this->post('ket_st') : '-',
            'ipk_st' => $this->post('ipk_st') != null ? $this->post('ipk_st') : '-',
            'tingkat_st' => $this->post('tingkat_st') != null ? $this->post('tingkat_st') : '-',

            'nama_s1' => $this->post('nama_s1') != null ? $this->post('nama_s1') : '-',
            'jurusan_s1' => $this->post('jurusan_s1') != null ? $this->post('jurusan_s1') : '-',
            'tahun_s1' => $this->post('tahun_s1') != null ? $this->post('tahun_s1') : '-',
            'ket_s1' => $this->post('ket_s1') != null ? $this->post('ket_s1') : '-',
            'ipk_s1' => $this->post('ipk_s1') != null ? $this->post('ipk_s1') : '-',
            'tingkat_s1' => $this->post('tingkat_s1') != null ? $this->post('tingkat_s1') : '-',

            'nama_s2' => $this->post('nama_s2') != null ? $this->post('nama_s2') : '-',
            'jurusan_s2' => $this->post('jurusan_s2') != null ? $this->post('jurusan_s2') : '-',
            'tahun_s2' => $this->post('tahun_s2') != null ? $this->post('tahun_s2') : '-',
            'ket_s2' => $this->post('ket_s2') != null ? $this->post('ket_s2') : '-',
            'ipk_s2' => $this->post('ipk_s2') != null ? $this->post('ipk_s2') : '-',
            'tingkat_s2' => $this->post('tingkat_s2') != null ? $this->post('tingkat_s2') : '-',

            'nama_s3' => $this->post('nama_s3') != null ? $this->post('nama_s3') : '-',
            'jurusan_s3' => $this->post('jurusan_s3') != null ? $this->post('jurusan_s3') : '-',
            'tahun_s3' => $this->post('tahun_s3') != null ? $this->post('tahun_s3') : '-',
            'ket_s3' => $this->post('ket_s3') != null ? $this->post('ket_s3') : '-',
            'ipk_s3' => $this->post('ipk_s3') != null ? $this->post('ipk_s3') : '-',
            'tingkat_s3' => $this->post('tingkat_s3')  != null ? $this->post('tingkat_s3') : '-',
        ];

        if ($this->M_Karyawan->createPendidikan($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pengalaman_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru')  != null ? $this->post('nik_baru') : '-',

            'nama_perusahaan' => $this->post('nama_perusahaan') != null ? $this->post('nama_perusahaan') : '-',
            'jabatan_awal' => $this->post('jabatan_awal') != null ? $this->post('jabatan_awal') : '-',
            'jabatan_awal_start' => $this->post('jabatan_awal_start') != null ? $this->post('jabatan_awal_start') : '-',
            'jabatan_awal_end' => $this->post('jabatan_awal_end') != null ? $this->post('jabatan_awal_end') : '-',
            'jabatan_akhir' => $this->post('jabatan_akhir') != null ? $this->post('jabatan_akhir') : '-',

            'jabatan_akhir_start' => $this->post('jabatan_akhir_start') != null ? $this->post('jabatan_akhir_start') : '-',
            'jabatan_akhir_end' => $this->post('jabatan_akhir_end') != null ? $this->post('jabatan_akhir_end') : '-',
            'tahun_keluar' => $this->post('tahun_keluar') != null ? $this->post('tahun_keluar') : '-',
            'alasan_keluar' => $this->post('alasan_keluar') != null ? $this->post('alasan_keluar') : '-',
            'gaji_terakhir' => $this->post('gaji_terakhir') != null ? $this->post('gaji_terakhir') : '-',

            'no_telp_perusahaan' => $this->post('no_telp_perusahaan') != null ? $this->post('no_telp_perusahaan') : '-',
            'nama_atasan' => $this->post('nama_atasan') != null ? $this->post('nama_atasan') : '-',
            'nama_referensi' => $this->post('nama_referensi') != null ? $this->post('nama_referensi') : '-',
            'no_kontak_referensi' => $this->post('no_kontak_referensi') != null ? $this->post('no_kontak_referensi') : '-',
            'upload_paklaring' => $this->post('upload_paklaring') != null ? $this->post('upload_paklaring') : '-',
        ];

        if ($this->M_Karyawan->createPengalaman($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pelatihan_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'nama_pelatihan_lembaga' => $this->post('nama_pelatihan_lembaga') != null ? $this->post('nama_pelatihan_lembaga') : '-',
            'judul_pelatihan' => $this->post('judul_pelatihan') != null ? $this->post('judul_pelatihan') : '-',
            'tahun_pelatihan' => $this->post('tahun_pelatihan') != null ? $this->post('tahun_pelatihan') : '-',
            'tempat_pelatihan' => $this->post('tempat_pelatihan') != null ? $this->post('tempat_pelatihan') : '-',
            'ket_pelatihan' => $this->post('ket_pelatihan') != null ? $this->post('ket_pelatihan') : '-',
            'tanggal_pelatihan' => $this->post('tanggal_pelatihan') != null ? $this->post('tanggal_pelatihan') : '-',
        ];

        if ($this->M_Karyawan->createPelatihan($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_bahasa_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'nama_bahasa' => $this->post('nama_bahasa') != null ? $this->post('nama_bahasa') : '-',
            'lisan' => $this->post('lisan') != null ? $this->post('lisan') : '-',
            'tulisan' => $this->post('tulisan') != null ? $this->post('tulisan') : '-',
            'baca' => $this->post('baca') != null ? $this->post('baca') : '-',
        ];

        if ($this->M_Karyawan->createBahasa($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_hobi_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'nama_hobi' => $this->post('nama_hobi') != null ? $this->post('nama_hobi') : '-',
            'ket_hobi' => $this->post('ket_hobi') != null ? $this->post('ket_hobi') : '-',
            'nama_hobi_2' => $this->post('nama_hobi_2') != null ? $this->post('nama_hobi_2') : '-',
            'ket_hobi_2' => $this->post('ket_hobi_2') != null ? $this->post('ket_hobi_2') : '-',
            'nama_hobi_3' => $this->post('nama_hobi_3') != null ? $this->post('nama_hobi_3') : '-',
            'ket_hobi_3' => $this->post('ket_hobi_3') != null ? $this->post('ket_hobi_3') : '-',
        ];

        if ($this->M_Karyawan->createHobi($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_organisasi_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'nama_organisasi' => $this->post('nama_organisasi') != null ? $this->post('nama_organisasi') : '-',
            'jabatan_awal_organisasi' => $this->post('jabatan_awal_organisasi') != null ? $this->post('jabatan_awal_organisasi') : '-',
            'jabatan_akhir_organisasi' => $this->post('jabatan_akhir_organisasi') != null ? $this->post('jabatan_akhir_organisasi') : '-',
            'tahun_masuk_organisasi' => $this->post('tahun_masuk_organisasi') != null ? $this->post('tahun_masuk_organisasi') : '-',
            'tahun_keluar_organisasi' => $this->post('tahun_keluar_organisasi') != null ? $this->post('tahun_keluar_organisasi') : '-',
            'deskripsi_organisasi' => $this->post('deskripsi_organisasi') != null ? $this->post('deskripsi_organisasi') : '-',
        ];

        if ($this->M_Karyawan->createOrganisasi($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_minat_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'minat_1' => $this->post('minat_1') != null ? $this->post('minat_1') : '-',
            'minat_2' => $this->post('minat_2') != null ? $this->post('minat_2') : '-',
            'minat_3' => $this->post('minat_3') != null ? $this->post('minat_3') : '-',
        ];

        if ($this->M_Karyawan->createMinat($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_struktur_post()
    {
        $data = [
            'nik_baru' => $this->post('nik_baru') != null ? $this->post('nik_baru') : '-',
            'password' => $this->post('password') != null ? $this->post('password') : '-',
            'nik_lama' => $this->post('nik_lama') != null ? $this->post('nik_lama') : '-',
            'nama_karyawan_struktur' => $this->post('nama_karyawan_struktur') != null ? $this->post('nama_karyawan_struktur') : '-',
            'jabatan_struktur' => $this->post('jabatan_struktur') != null ? $this->post('jabatan_struktur') : '-',
            'lokasi_struktur' => $this->post('lokasi_struktur') != null ? $this->post('lokasi_struktur') : '-',
            'perusahaan_struktur' => $this->post('perusahaan_struktur') != null ? $this->post('perusahaan_struktur') : '-',
            'level_struktur' => $this->post('level_struktur') != null ? $this->post('level_struktur') : '-',
            'dept_struktur' => $this->post('dept_struktur') != null ? $this->post('dept_struktur') : '-',
            'join_date_struktur' => $this->post('join_date_struktur') != null ? $this->post('join_date_struktur') : '-',
            'jam_kerja' => $this->post('jam_kerja') != null ? $this->post('jam_kerja') : '-',
            'start_date_struktur' => $this->post('start_date_struktur') != null ? $this->post('start_date_struktur') : '-',
            'masa_kerja_struktur' => $this->post('masa_kerja_struktur') != null ? $this->post('masa_kerja_struktur') : '-',
            'status_karyawan_struktur' => $this->post('status_karyawan_struktur') != null ? $this->post('status_karyawan_struktur') : '-',
            'start_pkwt_struktur' => $this->post('start_pkwt_struktur') != null ? $this->post('start_pkwt_struktur') : '-',
            'end_pkwt_struktur' => $this->post('end_pkwt_struktur') != null ? $this->post('end_pkwt_struktur') : '-',
            'nama_atasan_struktur' => $this->post('nama_atasan_struktur') != null ? $this->post('nama_atasan_struktur') : '-',
            'status_karyawan' => $this->post('status_karyawan') != null ? $this->post('status_karyawan') : '-',
            'status_ptkp' => $this->post('status_ptkp') != null ? $this->post('status_ptkp') : '-',
            'status_npwp' => $this->post('status_npwp') != null ? $this->post('status_npwp') : '-',
            'digit_npwp' => $this->post('digit_npwp') != null ? $this->post('digit_npwp') : '-',
            'status_bpjs' => $this->post('status_bpjs') != null ? $this->post('status_bpjs') : '-',
            'kpp' => $this->post('kpp') != null ? $this->post('kpp') : '-',
            'email' => $this->post('email') != null ? $this->post('email') : '-',
            'lokasi_hrd' => $this->post('lokasi_struktur') != null ? $this->post('lokasi_struktur') : '-',
            'jabatan_hrd' => $this->post('jabatan_struktur') != null ? $this->post('jabatan_struktur') : '-',
        ];

        if ($this->M_Karyawan->createStruktur($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_kontrak_post()
    {
        $data = [
            'no_urut' => $this->post('no_urut'),
            'nik_baru' => $this->post('nik_baru'),
            'kontrak' => $this->post('kontrak'),
            'tanggal_kontrak' => $this->post('tanggal_kontrak'),
            'start_date' => $this->post('start_date'),
            'end_date' => $this->post('end_date'),
        ];

        if ($this->M_Karyawan->createKontrak($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_seragam_post()
    {
        $get = $this->M_Karyawan->getIdSeragam();
        foreach ($get as $row) {
            $id = $row['id'];
        }

        $data = [


            'nik_pengajuan' => $this->post('nik_pengajuan'),
            'no_pengajuan' => $id,
            'ket_pengajuan' => $this->post('ket_pengajuan'),
            'nik_baru' => $this->post('nik_baru'),
            'nama_karyawan_seragam' => $this->post('nama_karyawan_seragam'),
            'jabatan_karyawan_seragam' => $this->post('jabatan_karyawan_seragam'),

            'dept_karyawan_seragam' => $this->post('dept_karyawan_seragam'),
            'lokasi_karyawan_seragam' => $this->post('lokasi_karyawan_seragam'),
            'kode_seragam' => $this->post('kode_seragam'),
            'nama_seragam' => $this->post('nama_seragam'),
            'qty_seragam' => $this->post('qty_seragam'),
            'harga_satuan' => $this->post('harga_satuan'),

            'total_harga' => $this->post('total_harga'),
            'tanggal_distribusi' => $this->post('tanggal_distribusi'),
            'ket_tambahan' => $this->post('ket_tambahan'),
            'status_realisasi' => $this->post('status_realisasi'),
            'status_distribusi' => $this->post('status_distribusi'),

        ];

        if ($this->M_Karyawan->createSeragam($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_noUrut_get()
    {

        $get = $this->M_Karyawan->getNoUrut();

        if ($get) {
            $this->response([
                'status' => true,
                'data' => $get
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_noUrutPerId_get()
    {
        $szId = $this->get('szId');

        $get = $this->M_Karyawan->getNoUrutPerId($szId);

        if ($get) {
            $this->response([
                'status' => true,
                'data' => $get
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_UpdateNoUrut_put()
    {
        $szName = 'NO URUT KARYAWAN';


        $data = [
            'intLastCounter' => $this->put('intLastCounter'),

        ];

        if ($this->M_Karyawan->updateNoUrut($data, $szName) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_UpdateNoUrutPerId_put()
    {
        $szId = $this->put('szId');


        $data = [
            'intLastCounter' => $this->put('intLastCounter'),

        ];

        if ($this->M_Karyawan->updateNoUrutPerId($data, $szId) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    // ===== baru ===== //

    public function index_induk_get()
    {
        $nik_baru = $this->get('nik_baru');

        $karyawan = $this->M_Karyawan->getDataInduk($nik_baru);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_detail_get()
    {
        $nik_baru = $this->get('nik_baru');

        $karyawan = $this->M_Karyawan->getDataDetail($nik_baru);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_suamiistri_get()
    {
        $nik_baru = $this->get('nik_baru');

        $karyawan = $this->M_Karyawan->getSuamiIstri($nik_baru);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_anak_get()
    {
        $nik_baru = $this->get('nik_baru');

        $karyawan = $this->M_Karyawan->getAnak($nik_baru);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_susunanKeluarga_get()
    {
        $nik_baru = $this->get('nik_baru');

        $karyawan = $this->M_Karyawan->getSusunanKeluarga($nik_baru);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_darurat_get()
    {
        $nik_baru = $this->get('nik_baru');

        $karyawan = $this->M_Karyawan->getDarurat($nik_baru);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_idSeragam_get()
    {

        $karyawan = $this->M_Karyawan->getIdSeragam();

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_pendidikan_get()
    {
        $nik_baru = $this->get('nik_baru');

        $karyawan = $this->M_Karyawan->getPendidikan($nik_baru);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_induk_put()
    {
        $nik_baru = $this->put('nik_baru');


        $data = [
            'digit_ktp' => $this->put('digit_ktp'),
            'no_ktp' => $this->put('no_ktp'),
            'digit_npwp' => $this->put('digit_npwp'),
            'digit_kk' => $this->put('digit_kk'),
        ];

        if ($this->M_Karyawan->updateInduk($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_detail_put()
    {
        $nik_baru = $this->put('nik_baru');

        $data = [
            'tanggal_lahir' => $this->put('tanggal_lahir'),
            'tempat_lahir' => $this->put('tempat_lahir'),
            'jenis_kelamin' => $this->put('jenis_kelamin'),
            'status_pernikahan' => $this->put('status_pernikahan'),

            'alamat_ktp' => $this->put('alamat_ktp'),
            'no_telp' => $this->put('no_telp'),
            'no_hp' => $this->put('no_hp'),
            'email' => $this->put('email'),

            'alamat_domisili' => $this->put('alamat_domisili'),
        ];

        if ($this->M_Karyawan->updateDetail($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($this->put('nik_baru'));
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }

            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'tanggal_lahir' => $this->put('tanggal_lahir') != null ? $this->put('tanggal_lahir') : '-',
                'tempat_lahir' => $this->put('tempat_lahir') != null ? $this->put('tempat_lahir') : '-',
                'jenis_kelamin' => $this->put('jenis_kelamin') != null ? $this->put('jenis_kelamin') : '-',
                'status_pernikahan' => $this->put('status_pernikahan') != null ? $this->put('status_pernikahan') : '-',

                'alamat_ktp' => $this->put('alamat_ktp') != null ? $this->put('alamat_ktp') : '-',
                'no_telp' => $this->put('urutan_anak') != null ? $this->put('no_telp') : '-',
                'no_hp' => $this->put('no_hp') != null ? $this->put('no_hp') : '-',
                'email' => $this->put('email') != null ? $this->put('email') : '-',
                'alamat_domisili' => $this->put('alamat_domisili') != null ? $this->put('alamat_domisili') : '-',


            ];

            if ($this->M_Karyawan->createDataDetail($data) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'new pengajuan has been updated',
                ], REST_Controller::HTTP_OK);
            } else {
                // Gagal
                $this->response([
                    'status' => false,
                    'message' => 'Failed to update data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }



    public function index_suamiistri_put()
    {
        $nik_baru = $this->put('nik_baru');

        $data = [
            'nama_keluarga' => $this->put('nama_keluarga'),
            'no_ktp_keluarga' => $this->put('no_ktp_keluarga'),
            'tanggal_lahir_keluarga' => $this->put('tanggal_lahir_keluarga'),
            'tempat_lahir_keluarga' => $this->put('tempat_lahir_keluarga'),
            'gol_darah_keluarga' => $this->put('gol_darah_keluarga'),

            'agama_keluarga' => $this->put('agama_keluarga'),
            'suku_keluarga' => $this->put('suku_keluarga'),
            'kewarganegaraan_keluarga' => $this->put('kewarganegaraan_keluarga'),
            'pendidikan_keluarga' => $this->put('pendidikan_keluarga'),

        ];

        if ($this->M_Karyawan->updateKeluarga($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $karyawan = $this->M_Karyawan->getSuamiIstri($nik_baru);

            if ($karyawan) {
            } else {
                $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
                foreach ($getNik as $row) {
                    $no_urut = $row['no_urut'];
                }
                $data = [
                    'no_urut' => $no_urut,
                    'nik_baru' => $nik_baru,
                    'nama_keluarga' => $this->put('nama_keluarga'),
                    'no_ktp_keluarga' => $this->put('no_ktp_keluarga'),
                    'tanggal_lahir_keluarga' => $this->put('tanggal_lahir_keluarga'),
                    'tempat_lahir_keluarga' => $this->put('tempat_lahir_keluarga'),
                    'gol_darah_keluarga' => $this->put('gol_darah_keluarga'),
                    'agama_keluarga' => $this->put('agama_keluarga'),
                    'suku_keluarga' => $this->put('suku_keluarga'),
                    'kewarganegaraan_keluarga' => $this->put('kewarganegaraan_keluarga'),
                    'pendidikan_keluarga' => $this->put('pendidikan_keluarga'),
                ];

                $this->M_Karyawan->createDataKeluarga($data);
            }
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_susunan_keluarga_put()
    {
        $nik_baru = $this->put('nik_baru');

        $data = [
            'nama_ayah' => $this->put('nama_ayah'),
            'tanggal_lahir_ayah' => $this->put('tanggal_lahir_ayah'),
            'jenis_kelamin_ayah' => $this->put('jenis_kelamin_ayah'),
            'pekerjaan_ayah' => $this->put('pekerjaan_ayah'),
            'pendidikan_ayah' => $this->put('pendidikan_ayah'),

            'nama_ibu' => $this->put('nama_ibu'),
            'tanggal_lahir_ibu' => $this->put('tanggal_lahir_ibu'),
            'jenis_kelamin_ibu' => $this->put('jenis_kelamin_ibu'),
            'pekerjaan_ibu' => $this->put('pekerjaan_ibu'),
            'pendidikan_ibu' => $this->put('pendidikan_ibu'),

        ];

        if ($this->M_Karyawan->updateSusunanKeluarga($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $karyawan = $this->M_Karyawan->getSusunanKeluarga($nik_baru);

            if ($karyawan) {
            } else {
                $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
                foreach ($getNik as $row) {
                    $no_urut = $row['no_urut'];
                }
                $data = [
                    'no_urut' => $no_urut,
                    'nik_baru' => $nik_baru,
                    'nama_ayah' => $this->put('nama_ayah'),
                    'tanggal_lahir_ayah' => $this->put('tanggal_lahir_ayah'),
                    'jenis_kelamin_ayah' => $this->put('jenis_kelamin_ayah'),
                    'pekerjaan_ayah' => $this->put('pekerjaan_ayah'),
                    'pendidikan_ayah' => $this->put('pendidikan_ayah'),

                    'nama_ibu' => $this->put('nama_ibu'),
                    'tanggal_lahir_ibu' => $this->put('tanggal_lahir_ibu'),
                    'jenis_kelamin_ibu' => $this->put('jenis_kelamin_ibu'),
                    'pekerjaan_ibu' => $this->put('pekerjaan_ibu'),
                    'pendidikan_ibu' => $this->put('pendidikan_ibu'),
                ];

                $this->M_Karyawan->createDataSusunanKeluarga($data);
            }

            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_hapusAnak_put()
    {
        $id_anak = $this->put('id_anak');


        $data = [
            'nik_baru' => $this->put('nik_baru'),
            'no_urut' => '',

        ];

        if ($this->M_Karyawan->updateHapusAnak($data, $id_anak) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_darurat_put()
    {
        $nik_baru = $this->put('nik_baru');


        $data = [
            'nama_darurat' => $this->put('nama_darurat'),
            'no_hp_darurat' => $this->put('no_hp_darurat'),
            'alamat_darurat' => $this->put('alamat_darurat'),


        ];

        if ($this->M_Karyawan->updateDarurat($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $karyawan = $this->M_Karyawan->getDarurat($nik_baru);
            if ($karyawan) {
            } else {
                $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
                foreach ($getNik as $row) {
                    $no_urut = $row['no_urut'];
                }
                $data = [
                    'no_urut' =>  $no_urut,
                    'nik_baru' =>  $nik_baru,
                    'nama_darurat' => $this->put('nama_darurat'),
                    'no_hp_darurat' => $this->put('no_hp_darurat'),
                    'alamat_darurat' => $this->put('alamat_darurat'),
                ];

                $this->M_Karyawan->createDarurat($data);
            }


            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_awal_put()
    {
        $nik_baru = $this->put('nik_baru');
        $data2 = [
            'status_update' => '1',
        ];
        $this->M_Karyawan->updateStatus($data2, $nik_baru);

        $data = [
            'status_sd' => $this->put('status_sd'),
            'nama_sd' => $this->put('nama_sd'),
            'tahun_sd' => $this->put('tahun_sd'),
            'ket_sd' => $this->put('ket_sd'),
            'nilai_sd' => $this->put('nilai_sd'),

            'status_smp' => $this->put('status_smp'),
            'nama_smp' => $this->put('nama_smp'),
            'tahun_smp' => $this->put('tahun_smp'),
            'ket_smp' => $this->put('ket_smp'),
            'nilai_smp' => $this->put('nilai_smp'),

            'status_smk' => $this->put('status_smk'),
            'nama_smk' => $this->put('nama_smk'),
            'jurusan_smk' => $this->put('jurusan_smk'),
            'tahun_smk' => $this->put('tahun_smk'),
            'ket_smk' => $this->put('ket_smk'),
            'nilai_smk' => $this->put('nilai_smk'),
        ];

        if ($this->M_Karyawan->updatePendidikan($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'status_sd' => $this->put('status_sd'),
                'nama_sd' => $this->put('nama_sd'),
                'tahun_sd' => $this->put('tahun_sd'),
                'ket_sd' => $this->put('ket_sd'),
                'nilai_sd' => $this->put('nilai_sd'),

                'status_smp' => $this->put('status_smp'),
                'nama_smp' => $this->put('nama_smp'),
                'tahun_smp' => $this->put('tahun_smp'),
                'ket_smp' => $this->put('ket_smp'),
                'nilai_smp' => $this->put('nilai_smp'),

                'status_smk' => $this->put('status_smk'),
                'nama_smk' => $this->put('nama_smk'),
                'jurusan_smk' => $this->put('jurusan_smk'),
                'tahun_smk' => $this->put('tahun_smk'),
                'ket_smk' => $this->put('ket_smk'),
                'nilai_smk' => $this->put('nilai_smk'),
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }

            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_diploma_put()
    {
        $nik_baru = $this->put('nik_baru');


        $data = [
            'nama_st' => $this->put('nama_st'),
            'jurusan_st' => $this->put('jurusan_st'),
            'tahun_st' => $this->put('tahun_st'),
            'ket_st' => $this->put('ket_st'),
            'ipk_st' => $this->put('ipk_st'),
            'tingkat_st' => $this->put('tingkat_st'),
        ];

        if ($this->M_Karyawan->updatePendidikan($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'nama_st' => $this->put('nama_st'),
                'jurusan_st' => $this->put('jurusan_st'),
                'tahun_st' => $this->put('tahun_st'),
                'ket_st' => $this->put('ket_st'),
                'ipk_st' => $this->put('ipk_st'),
                'tingkat_st' => $this->put('tingkat_st'),
                'status_sd' => '',
                'ket_sd' => '',
                'status_smp' => '',
                'ket_smp' => '',
                'status_smk' => '',
                'ket_smk' => '',
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_s1_put()
    {
        $nik_baru = $this->put('nik_baru');


        $data = [
            'nama_s1' => $this->put('nama_s1'),
            'jurusan_s1' => $this->put('jurusan_s1'),
            'tahun_s1' => $this->put('tahun_s1'),
            'ket_s1' => $this->put('ket_s1'),
            'ipk_s1' => $this->put('ipk_s1'),
            'tingkat_s1' => $this->put('tingkat_s1'),
        ];

        if ($this->M_Karyawan->updatePendidikan($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'nama_s1' => $this->put('nama_s1'),
                'jurusan_s1' => $this->put('jurusan_s1'),
                'tahun_s1' => $this->put('tahun_s1'),
                'ket_s1' => $this->put('ket_s1'),
                'ipk_s1' => $this->put('ipk_s1'),
                'tingkat_s1' => $this->put('tingkat_s1'),
                'status_sd' => '',
                'ket_sd' => '',
                'status_smp' => '',
                'ket_smp' => '',
                'status_smk' => '',
                'ket_smk' => '',
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_s2_put()
    {
        $nik_baru = $this->put('nik_baru');


        $data = [
            'nama_s2' => $this->put('nama_s2'),
            'jurusan_s2' => $this->put('jurusan_s2'),
            'tahun_s2' => $this->put('tahun_s2'),
            'ket_s2' => $this->put('ket_s2'),
            'ipk_s2' => $this->put('ipk_s2'),
            'tingkat_s2' => $this->put('tingkat_s2'),
        ];

        if ($this->M_Karyawan->updatePendidikan($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'nama_s2' => $this->put('nama_s2'),
                'jurusan_s2' => $this->put('jurusan_s2'),
                'tahun_s2' => $this->put('tahun_s2'),
                'ket_s2' => $this->put('ket_s2'),
                'ipk_s2' => $this->put('ipk_s2'),
                'tingkat_s2' => $this->put('tingkat_s2'),
                'status_sd' => '',
                'ket_sd' => '',
                'status_smp' => '',
                'ket_smp' => '',
                'status_smk' => '',
                'ket_smk' => '',
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_s3_put()
    {
        $nik_baru = $this->put('nik_baru');


        $data = [
            'nama_s3' => $this->put('nama_s3'),
            'jurusan_s3' => $this->put('jurusan_s3'),
            'tahun_s3' => $this->put('tahun_s3'),
            'ket_s3' => $this->put('ket_s3'),
            'ipk_s3' => $this->put('ipk_s3'),
            'tingkat_s3' => $this->put('tingkat_s3'),
        ];

        if ($this->M_Karyawan->updatePendidikan($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'nama_s3' => $this->put('nama_s3'),
                'jurusan_s3' => $this->put('jurusan_s3'),
                'tahun_s3' => $this->put('tahun_s3'),
                'ket_s3' => $this->put('ket_s3'),
                'ipk_s3' => $this->put('ipk_s3'),
                'tingkat_s3' => $this->put('tingkat_s3'),
                'status_sd' => '',
                'ket_sd' => '',
                'status_smp' => '',
                'ket_smp' => '',
                'status_smk' => '',
                'ket_smk' => '',
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_anak_put()
    {
        $id_anak = $this->put('id_anak');

        $data = [
            'nik_baru' => $this->put('nik_baru') != null ? $this->put('nik_baru') : '-',
            'urutan_anak' => $this->put('urutan_anak') != null ? $this->put('urutan_anak') : '-',
            'nama_anak' => $this->put('nama_anak') != null ? $this->put('nama_anak') : '-',
            'no_ktp_anak' => $this->put('no_ktp_anak') != null ? $this->put('no_ktp_anak') : '-',
            'tanggal_lahir_anak' => $this->put('tanggal_lahir_anak') != null ? $this->put('tanggal_lahir_anak') : '-',
            'tempat_lahir_anak' => $this->put('tempat_lahir_anak') != null ? $this->put('tempat_lahir_anak') : '-',
            'gol_darah_anak' => $this->put('gol_darah_anak') != null ? $this->put('gol_darah_anak') : '-',
            'agama_anak' => $this->put('agama_anak') != null ? $this->put('agama_anak') : '-',
            'suku_anak' => $this->put('suku_anak') != null ? $this->put('suku_anak') : '-',
            'kewarganegaraan_anak' => $this->put('kewarganegaraan_anak') != null ? $this->put('kewarganegaraan_anak') : '-',
            'pendidikan_anak' => $this->put('pendidikan_anak') != null ? $this->put('pendidikan_anak') : '-',
        ];

        if ($this->M_Karyawan->updateHapusAnak($data, $id_anak) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been created',
            ], REST_Controller::HTTP_CREATED);
        } else {
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to create new data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }


    public function index_kontak_get()
    {

        $karyawan = $this->M_Karyawan->getContact();

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    // ================ //

    // no urut //

    public function index_nik_NoUrut_get()
    {
        $nik_baru = $this->get('nik_baru');

        $karyawan = $this->M_Karyawan->getNikNoUrut($nik_baru);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_induk_NoUrut_get()
    {
        $no_urut = $this->get('no_urut');

        $karyawan = $this->M_Karyawan->getDataIndukNoUrut($no_urut);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_detail_NoUrut_get()
    {
        $no_urut = $this->get('no_urut');

        $karyawan = $this->M_Karyawan->getDataDetailNoUrut($no_urut);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_suamiistri_NoUrut_get()
    {
        $no_urut = $this->get('no_urut');

        $karyawan = $this->M_Karyawan->getSuamiIstriNoUrut($no_urut);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_anak_NoUrut_get()
    {
        $no_urut = $this->get('no_urut');

        $karyawan = $this->M_Karyawan->getAnakNoUrut($no_urut);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_susunanKeluarga_NoUrut_get()
    {
        $no_urut = $this->get('no_urut');

        $karyawan = $this->M_Karyawan->getSusunanKeluargaNoUrut($no_urut);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_darurat_NoUrut_get()
    {
        $no_urut = $this->get('no_urut');

        $karyawan = $this->M_Karyawan->getDaruratNoUrut($no_urut);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_pendidikan_NoUrut_get()
    {
        $no_urut = $this->get('no_urut');

        $karyawan = $this->M_Karyawan->getPendidikanNoUrut($no_urut);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }


    public function index_detail_NoUrut_put()
    {
        $noUrut = $this->put('no_urut');
        $nik_baru = $this->put('nik_baru');

        $data = [
            'tanggal_lahir' => $this->put('tanggal_lahir'),
            'tempat_lahir' => $this->put('tempat_lahir'),
            'jenis_kelamin' => $this->put('jenis_kelamin'),
            'status_pernikahan' => $this->put('status_pernikahan'),

            'alamat_ktp' => $this->put('alamat_ktp'),
            'no_telp' => $this->put('no_telp'),
            'no_hp' => $this->put('no_hp'),
            'email' => $this->put('email'),

            'alamat_domisili' => $this->put('alamat_domisili'),
        ];

        if ($this->M_Karyawan->updateDetailNoUrut($data, $noUrut) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($this->put('nik_baru'));
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }

            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'tanggal_lahir' => $this->put('tanggal_lahir') != null ? $this->put('tanggal_lahir') : '-',
                'tempat_lahir' => $this->put('tempat_lahir') != null ? $this->put('tempat_lahir') : '-',
                'jenis_kelamin' => $this->put('jenis_kelamin') != null ? $this->put('jenis_kelamin') : '-',
                'status_pernikahan' => $this->put('status_pernikahan') != null ? $this->put('status_pernikahan') : '-',

                'alamat_ktp' => $this->put('alamat_ktp') != null ? $this->put('alamat_ktp') : '-',
                'no_telp' => $this->put('urutan_anak') != null ? $this->put('no_telp') : '-',
                'no_hp' => $this->put('no_hp') != null ? $this->put('no_hp') : '-',
                'email' => $this->put('email') != null ? $this->put('email') : '-',
                'alamat_domisili' => $this->put('alamat_domisili') != null ? $this->put('alamat_domisili') : '-',


            ];

            if ($this->M_Karyawan->createDataDetail($data) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'new pengajuan has been updated',
                ], REST_Controller::HTTP_OK);
            } else {
                // Gagal
                $this->response([
                    'status' => false,
                    'message' => 'Failed to update data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }


    public function index_suamiistri_NoUrut_put()
    {
        $noUrut = $this->put('no_urut');
        $nik_baru = $this->put('nik_baru');

        $data = [
            'nama_keluarga' => $this->put('nama_keluarga'),
            'no_ktp_keluarga' => $this->put('no_ktp_keluarga'),
            'tanggal_lahir_keluarga' => $this->put('tanggal_lahir_keluarga'),
            'tempat_lahir_keluarga' => $this->put('tempat_lahir_keluarga'),
            'gol_darah_keluarga' => $this->put('gol_darah_keluarga'),

            'agama_keluarga' => $this->put('agama_keluarga'),
            'suku_keluarga' => $this->put('suku_keluarga'),
            'kewarganegaraan_keluarga' => $this->put('kewarganegaraan_keluarga'),
            'pendidikan_keluarga' => $this->put('pendidikan_keluarga'),

        ];

        if ($this->M_Karyawan->updateKeluargaNoUrut($data, $noUrut) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $karyawan = $this->M_Karyawan->getSuamiIstri($nik_baru);

            if ($karyawan) {
            } else {
                $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
                foreach ($getNik as $row) {
                    $no_urut = $row['no_urut'];
                }
                $data = [
                    'no_urut' => $no_urut,
                    'nik_baru' => $nik_baru,
                    'nama_keluarga' => $this->put('nama_keluarga'),
                    'no_ktp_keluarga' => $this->put('no_ktp_keluarga'),
                    'tanggal_lahir_keluarga' => $this->put('tanggal_lahir_keluarga'),
                    'tempat_lahir_keluarga' => $this->put('tempat_lahir_keluarga'),
                    'gol_darah_keluarga' => $this->put('gol_darah_keluarga'),
                    'agama_keluarga' => $this->put('agama_keluarga'),
                    'suku_keluarga' => $this->put('suku_keluarga'),
                    'kewarganegaraan_keluarga' => $this->put('kewarganegaraan_keluarga'),
                    'pendidikan_keluarga' => $this->put('pendidikan_keluarga'),
                ];

                $this->M_Karyawan->createDataKeluarga($data);
            }
            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_susunan_keluarga_NoUrut_put()
    {
        $noUrut = $this->put('no_urut');
        $nik_baru = $this->put('nik_baru');

        $data = [
            'nama_ayah' => $this->put('nama_ayah'),
            'tanggal_lahir_ayah' => $this->put('tanggal_lahir_ayah'),
            'jenis_kelamin_ayah' => $this->put('jenis_kelamin_ayah'),
            'pekerjaan_ayah' => $this->put('pekerjaan_ayah'),
            'pendidikan_ayah' => $this->put('pendidikan_ayah'),

            'nama_ibu' => $this->put('nama_ibu'),
            'tanggal_lahir_ibu' => $this->put('tanggal_lahir_ibu'),
            'jenis_kelamin_ibu' => $this->put('jenis_kelamin_ibu'),
            'pekerjaan_ibu' => $this->put('pekerjaan_ibu'),
            'pendidikan_ibu' => $this->put('pendidikan_ibu'),

        ];

        if ($this->M_Karyawan->updateSusunanKeluargaNoUrut($data, $noUrut) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $karyawan = $this->M_Karyawan->getSusunanKeluarga($nik_baru);

            if ($karyawan) {
            } else {
                $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
                foreach ($getNik as $row) {
                    $no_urut = $row['no_urut'];
                }
                $data = [
                    'no_urut' => $no_urut,
                    'nik_baru' => $nik_baru,
                    'nama_ayah' => $this->put('nama_ayah'),
                    'tanggal_lahir_ayah' => $this->put('tanggal_lahir_ayah'),
                    'jenis_kelamin_ayah' => $this->put('jenis_kelamin_ayah'),
                    'pekerjaan_ayah' => $this->put('pekerjaan_ayah'),
                    'pendidikan_ayah' => $this->put('pendidikan_ayah'),

                    'nama_ibu' => $this->put('nama_ibu'),
                    'tanggal_lahir_ibu' => $this->put('tanggal_lahir_ibu'),
                    'jenis_kelamin_ibu' => $this->put('jenis_kelamin_ibu'),
                    'pekerjaan_ibu' => $this->put('pekerjaan_ibu'),
                    'pendidikan_ibu' => $this->put('pendidikan_ibu'),
                ];

                $this->M_Karyawan->createDataSusunanKeluarga($data);
            }

            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }



    public function index_pendidikan_awal_NoUrut_put()
    {
        $nik_baru = $this->put('nik_baru');
        $noUrut = $this->put('no_urut');
        $data2 = [
            'status_update' => '1',
        ];
        $this->M_Karyawan->updateStatus($data2, $nik_baru);

        $data = [
            'status_sd' => $this->put('status_sd'),
            'nama_sd' => $this->put('nama_sd'),
            'tahun_sd' => $this->put('tahun_sd'),
            'ket_sd' => $this->put('ket_sd'),
            'nilai_sd' => $this->put('nilai_sd'),

            'status_smp' => $this->put('status_smp'),
            'nama_smp' => $this->put('nama_smp'),
            'tahun_smp' => $this->put('tahun_smp'),
            'ket_smp' => $this->put('ket_smp'),
            'nilai_smp' => $this->put('nilai_smp'),

            'status_smk' => $this->put('status_smk'),
            'nama_smk' => $this->put('nama_smk'),
            'jurusan_smk' => $this->put('jurusan_smk'),
            'tahun_smk' => $this->put('tahun_smk'),
            'ket_smk' => $this->put('ket_smk'),
            'nilai_smk' => $this->put('nilai_smk'),
        ];

        if ($this->M_Karyawan->updatePendidikanNoUrut($data, $noUrut) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'status_sd' => $this->put('status_sd'),
                'nama_sd' => $this->put('nama_sd'),
                'tahun_sd' => $this->put('tahun_sd'),
                'ket_sd' => $this->put('ket_sd'),
                'nilai_sd' => $this->put('nilai_sd'),

                'status_smp' => $this->put('status_smp'),
                'nama_smp' => $this->put('nama_smp'),
                'tahun_smp' => $this->put('tahun_smp'),
                'ket_smp' => $this->put('ket_smp'),
                'nilai_smp' => $this->put('nilai_smp'),

                'status_smk' => $this->put('status_smk'),
                'nama_smk' => $this->put('nama_smk'),
                'jurusan_smk' => $this->put('jurusan_smk'),
                'tahun_smk' => $this->put('tahun_smk'),
                'ket_smk' => $this->put('ket_smk'),
                'nilai_smk' => $this->put('nilai_smk'),
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }

            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_diploma_NoUrut_put()
    {
        $nik_baru = $this->put('nik_baru');
        $noUrut = $this->put('no_urut');

        $data = [
            'nama_st' => $this->put('nama_st'),
            'jurusan_st' => $this->put('jurusan_st'),
            'tahun_st' => $this->put('tahun_st'),
            'ket_st' => $this->put('ket_st'),
            'ipk_st' => $this->put('ipk_st'),
            'tingkat_st' => $this->put('tingkat_st'),
        ];

        if ($this->M_Karyawan->updatePendidikanNoUrut($data, $noUrut) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'nama_st' => $this->put('nama_st'),
                'jurusan_st' => $this->put('jurusan_st'),
                'tahun_st' => $this->put('tahun_st'),
                'ket_st' => $this->put('ket_st'),
                'ipk_st' => $this->put('ipk_st'),
                'tingkat_st' => $this->put('tingkat_st'),
                'status_sd' => '',
                'ket_sd' => '',
                'status_smp' => '',
                'ket_smp' => '',
                'status_smk' => '',
                'ket_smk' => '',
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_s1_NoUrut_put()
    {
        $nik_baru = $this->put('nik_baru');
        $noUrut = $this->put('no_urut');


        $data = [
            'nama_s1' => $this->put('nama_s1'),
            'jurusan_s1' => $this->put('jurusan_s1'),
            'tahun_s1' => $this->put('tahun_s1'),
            'ket_s1' => $this->put('ket_s1'),
            'ipk_s1' => $this->put('ipk_s1'),
            'tingkat_s1' => $this->put('tingkat_s1'),
        ];

        if ($this->M_Karyawan->updatePendidikanNoUrut($data, $noUrut) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'nama_s1' => $this->put('nama_s1'),
                'jurusan_s1' => $this->put('jurusan_s1'),
                'tahun_s1' => $this->put('tahun_s1'),
                'ket_s1' => $this->put('ket_s1'),
                'ipk_s1' => $this->put('ipk_s1'),
                'tingkat_s1' => $this->put('tingkat_s1'),
                'status_sd' => '',
                'ket_sd' => '',
                'status_smp' => '',
                'ket_smp' => '',
                'status_smk' => '',
                'ket_smk' => '',
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_s2_NoUrut_put()
    {
        $nik_baru = $this->put('nik_baru');
        $noUrut = $this->put('no_urut');


        $data = [
            'nama_s2' => $this->put('nama_s2'),
            'jurusan_s2' => $this->put('jurusan_s2'),
            'tahun_s2' => $this->put('tahun_s2'),
            'ket_s2' => $this->put('ket_s2'),
            'ipk_s2' => $this->put('ipk_s2'),
            'tingkat_s2' => $this->put('tingkat_s2'),
        ];

        if ($this->M_Karyawan->updatePendidikanNoUrut($data, $no_urut) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'nama_s2' => $this->put('nama_s2'),
                'jurusan_s2' => $this->put('jurusan_s2'),
                'tahun_s2' => $this->put('tahun_s2'),
                'ket_s2' => $this->put('ket_s2'),
                'ipk_s2' => $this->put('ipk_s2'),
                'tingkat_s2' => $this->put('tingkat_s2'),
                'status_sd' => '',
                'ket_sd' => '',
                'status_smp' => '',
                'ket_smp' => '',
                'status_smk' => '',
                'ket_smk' => '',
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_pendidikan_s3_NoUrut_put()
    {
        $nik_baru = $this->put('nik_baru');
        $noUrut = $this->put('no_urut');


        $data = [
            'nama_s3' => $this->put('nama_s3'),
            'jurusan_s3' => $this->put('jurusan_s3'),
            'tahun_s3' => $this->put('tahun_s3'),
            'ket_s3' => $this->put('ket_s3'),
            'ipk_s3' => $this->put('ipk_s3'),
            'tingkat_s3' => $this->put('tingkat_s3'),
        ];

        if ($this->M_Karyawan->updatePendidikanNoUrut($data, $noUrut) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
            foreach ($getNik as $row) {
                $no_urut = $row['no_urut'];
            }
            $data = [
                'no_urut' => $no_urut,
                'nik_baru' => $nik_baru,
                'nama_s3' => $this->put('nama_s3'),
                'jurusan_s3' => $this->put('jurusan_s3'),
                'tahun_s3' => $this->put('tahun_s3'),
                'ket_s3' => $this->put('ket_s3'),
                'ipk_s3' => $this->put('ipk_s3'),
                'tingkat_s3' => $this->put('tingkat_s3'),
                'status_sd' => '',
                'ket_sd' => '',
                'status_smp' => '',
                'ket_smp' => '',
                'status_smk' => '',
                'ket_smk' => '',
            ];

            if ($this->M_Karyawan->getPendidikan($nik_baru)) {
            } else {
                $this->M_Karyawan->createPendidikan($data);
            }
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_darurat_NoUrut_put()
    {
        $nik_baru = $this->put('nik_baru');


        $data = [
            'nama_darurat' => $this->put('nama_darurat'),
            'no_hp_darurat' => $this->put('no_hp_darurat'),
            'alamat_darurat' => $this->put('alamat_darurat'),


        ];

        if ($this->M_Karyawan->updateDarurat($data, $nik_baru) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new pengajuan has been updated',
            ], REST_Controller::HTTP_OK);
        } else {
            $karyawan = $this->M_Karyawan->getDarurat($nik_baru);
            if ($karyawan) {
            } else {
                $getNik = $this->M_Karyawan->get_NoUrut($nik_baru);
                foreach ($getNik as $row) {
                    $no_urut = $row['no_urut'];
                }
                $data = [
                    'no_urut' =>  $no_urut,
                    'nik_baru' =>  $nik_baru,
                    'nama_darurat' => $this->put('nama_darurat'),
                    'no_hp_darurat' => $this->put('no_hp_darurat'),
                    'alamat_darurat' => $this->put('alamat_darurat'),
                ];

                $this->M_Karyawan->createDarurat($data);
            }


            // Gagal
            $this->response([
                'status' => false,
                'message' => 'Failed to update data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //-------------------------------------------------------

    public function index_get_kontak_hrd_get()
    {

        $karyawan = $this->M_Karyawan->getContact_hrd();

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_get_all_karyawan_get()
    {
        $nik = $this->get('nik_baru');
        $lokasi_struktur = $this->get('lokasi_struktur');
        $keyword = $this->get('keyword');

        $karyawan = $this->M_Karyawan->get_master_karyawan($lokasi_struktur, $nik, $keyword);

        if ($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Kode Nomor Not Found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
