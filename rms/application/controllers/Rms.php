<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rms extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('rms_model');
        $this->sess = $this->session->userdata('admin');
        if (!$this->sess) {
            redirect(base_url() . 'auth/login/', 'refresh');
            exit();
        }
    }

    public function index()
    {
        if (!$this->sess) {
            header('Location: ' . base_url() . 'rms/login/');
            exit();
        } else {
            header('Location: ' . base_url() . 'rms/dashboard/');
            exit();
        }
    }

    function login()
    {
        $this->load->view('rms/auth/index');
    }

    function login_process()
    {
        $username = $this->input->post('uname');
        $password = $this->input->post('pwd');
        $pass = md5($password);
        if ($username != null and $password != null) {

            $src = $this->admin_model->Get_Auth($username, $pass);
            if ($src->num_rows() == 0) {
                $this->session->set_flashdata('status', 'failed');
                echo "users not exist wherever OR wrong password!";
            } else {
                $users = $src->row();
                $this->session->set_userdata('admin', $users);
                /*
                  $last_log = array(
                  'last_login' => date("Y-m-d H:i:s"),
                  );
                  $lastlog = $this->m_model->update('tbl_users', $last_log, $users->id_user);
                 */
                echo "1";
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'rms/login');
    }

    function dashboard()
    {
        if ($this->sess->role == '1') {
            $data['content'] = 'rms/dashboard/dashboard1';
        } elseif ($this->sess->role == '2') {
            $data['content'] = 'rms/dashboard/dashboard2';
        } elseif ($this->sess->role == '3') {
            $data['content'] = 'rms/dashboard/dashboard3';
        } elseif ($this->sess->role == '4') {
            $data['content'] = 'rms/dashboard/dashboard4';
        }
        $this->load->view('rms/includes/template', $data);
    }

    function project()
    {
        $data['project'] = $this->rms_model->get("v_project")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['content'] = 'rms/project/index';
        $this->load->view('rms/includes/template', $data);
    }

    function rekapitulasi()
    {
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_vendor = '1'")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['content'] = 'rms/rekap/index';
        $this->load->view('rms/includes/template', $data);
    }

    function view_project($id_project)
    {
        $data['project'] = $this->rms_model->get("v_project", "WHERE id_project = $id_project")->row();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_project = $id_project")->result();
        $data['pembayaran_replas'] = $this->rms_model->get("v_rekap", "WHERE id_project = $id_project AND status ='1'")->result();
        $data['pembayaran_bongkar_muat'] = $this->rms_model->get("tbl_pembayaran_bongkar_muat", "WHERE id_project = $id_project")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['content'] = 'rms/project/view';
        $this->load->view('rms/includes/template', $data);
    }

    public function edit()
    {
        $id = $this->input->POST('id');
        $tbl = $this->input->POST('tbl');
        $data = $this->rms_model->get($tbl, "WHERE id = $id");
        $detail = $data->result();
        echo json_encode($detail);
    }

    public function get_rekap()
    {
        $id = $this->input->POST('id');
        $data = $this->rms_model->get("v_rekap", "WHERE id_rekap = $id");
        $detail = $data->result();
        echo json_encode($detail);
    }

    public function save_replas()
    {
        $id = $this->input->POST('id');
        $id_project = $this->input->POST('id_project');
        $no_replas = $this->input->POST('no_replas');
        $tanggal_muat = $this->input->POST('tanggal_muat');
        if ($tanggal_muat) {
            $tanggal_muat = $this->input->POST('tanggal_muat');
        } else {
            $tanggal_muat = NULL;
        }
        if ($tanggal_bongkar) {
            $tanggal_bongkar = $this->input->POST('tanggal_bongkar');
        } else {
            $tanggal_bongkar = NULL;
        }
        if ($id_project) {
            $id_project = $this->input->POST('id_project');
        } else {
            $id_project = NULL;
        }
        $supir = $this->input->POST('supir');
        $truck = $this->input->POST('truck');
        $tujuan = $this->input->POST('tujuan');
        $qty_kirim_bag = $this->input->POST('qty_kirim_bag');
        $qty_kirim_kg = $this->input->POST('qty_kirim_kg');
        $timbang_kebun_bag = $this->input->POST('timbang_kebun_bag');
        $timbang_kebun_kg = $this->input->POST('timbang_kebun_kg');
        $uang_sangu = $this->input->POST('uang_sangu');
        if ($no_replas) {
            $status = "1";
        } else {
            $status = "0";
        }
        $data = array(
            'no_replas' => $no_replas,
            'id_project' => $id_project,
            'tanggal_muat' => $tanggal_muat,
            'tanggal_bongkar' => $tanggal_bongkar,
            'id_supir' => $supir,
            'id_truck' => $truck,
            'id_tujuan' => $tujuan,
            'qty_kirim_bag' => $qty_kirim_bag,
            'qty_kirim_kg' => $qty_kirim_kg,
            'timbang_kebun_bag' => $timbang_kebun_bag,
            'timbang_kebun_kg' => $timbang_kebun_kg,
            'uang_sangu' => $uang_sangu,
            'status' => $status,
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_rekap", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_rekap", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function delete()
    {
        $id = $this->input->POST('id');
        $tbl = $this->input->POST('tbl');
        $delete = $this->rms_model->delete_data($tbl, $id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    public function delete_project()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_project($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    public function save_project()
    {
        $id = $this->input->POST('id');
        $no_kontrak = $this->input->POST('no_kontrak');
        $no_sto = $this->input->POST('no_sto');
        $no_do = $this->input->POST('no_do');
        $klien = $this->input->POST('klien');
        $tanggal_angkut = $this->input->POST('tanggal_angkut');
        $tanggal_selesai = $this->input->POST('tanggal_selesai');
        $komoditas = $this->input->POST('komoditas');
        $qty = $this->input->POST('qty');
        $toleransi_susut = $this->input->POST('toleransi_susut');
        $harga_unit = $this->input->POST('harga_unit');
        $claim = $this->input->POST('claim');

        $file_spk = $_FILES['file_spk']['name'];
        $file_do = $_FILES['file_do']['name'];

        $data_array = array(
            'no_kontrak' => $no_kontrak,
            'no_sto' => $no_sto,
            'no_do' => $no_do,
            'id_klien' => $klien,
            'tanggal_angkut' => $tanggal_angkut,
            'tanggal_selesai' => $tanggal_selesai,
            'id_komoditas' => $komoditas,
            'qty' => str_replace('.', '', $qty),
            'toleransi_susut' => $toleransi_susut,
            'harga_unit' => str_replace('.', '', $harga_unit),
            'claim' => str_replace('.', '', $claim),
            'status' => '0',
        );

        if (!empty($file_spk)) {
            $this->load->library('upload');
            $file_spk = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_spk);
            $filename_spk = str_replace(' ', '_', time() . $file_spk);
            $config['upload_path'] = 'assets/rms/documents/spk/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_spk;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_spk')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'file_spk' => $filename_spk
            );
        }
        if (!empty($file_do)) {
            $this->load->library('upload');
            $file_do = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_do);
            $filename_do = str_replace(' ', '_', time() . $file_do);
            $config['upload_path'] = 'assets/rms/documents/do/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_do;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_do')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'file_do' => $filename_do
            );
        }

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_project", $data_array);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_project", $data_array, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_pilih_truck()
    {
        $post = $this->input->post();
        for ($i = 0; $i < count($post['truck']); $i++) {
            $data = array(
                'id_project' => $post['id_project'],
                'id_truck' => $post['truck'][$i],
                'id_supir' => $post['supir'][$i],
                'id_tujuan' => $post['tujuan'][$i],
                'tanggal_muat' => $post['tanggal_muat'][$i],
                'uang_sangu' => $post['uang_sangu'][$i],
                'status' => '1',
            );
            $save = $this->db->insert('tbl_rekap', $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    function truck()
    {
        $data['truck_rws'] = $this->rms_model->get("v_truck", "WHERE kategori = '1'")->result();
        $data['truck_vendor'] = $this->rms_model->get("v_truck", "WHERE kategori = '2'")->result();
        $data['vendor'] = $this->rms_model->get("tbl_vendor_truck")->result();
        $data['content'] = 'rms/truck/index';
        $this->load->view('rms/includes/template', $data);
    }

    function view_truck($id_truck)
    {
        $data['truck'] = $this->rms_model->get("v_truck", "WHERE id_truck = $id_truck")->row();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_truck = $id_truck")->result();
        $data['perbaikan'] = $this->rms_model->get("v_perbaikan", "WHERE id_truck = $id_truck")->result();
        $data['bbm'] = $this->rms_model->get("v_bbm", "WHERE id_truck = $id_truck ORDER BY tanggal DESC")->result();
        $data['content'] = 'rms/truck/view';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_truk()
    {
        $id = $this->input->POST('id');
        $nopol = $this->input->POST('nopol');
        $kategori = $this->input->POST('kategori');

        if (isset($_POST['vendor'])) {
            $vendor = $this->input->POST('vendor');
        } else {
            $vendor = "";
        }
        if (isset($_POST['nomor_rangka'])) {
            $nomor_rangka = $this->input->POST('nomor_rangka');
        } else {
            $nomor_rangka = "";
        }
        if (isset($_POST['nomor_mesin'])) {
            $nomor_mesin = $this->input->POST('nomor_mesin');
        } else {
            $nomor_mesin = "";
        }
        if (isset($_POST['pajak_tahunan'])) {
            $pajak_tahunan = $this->input->POST('pajak_tahunan');
        } else {
            $pajak_tahunan = "";
        }
        if (isset($_POST['pajak_5_tahunan'])) {
            $pajak_5_tahunan = $this->input->POST('pajak_5_tahunan');
        } else {
            $pajak_5_tahunan = "";
        }
        if (isset($_POST['kir_terakhir'])) {
            $kir_terakhir = $this->input->POST('kir_terakhir');
        } else {
            $kir_terakhir = "";
        }
        if (isset($_POST['oddo_terakhir'])) {
            $oddo_terakhir = $this->input->POST('oddo_terakhir');
        } else {
            $oddo_terakhir = "";
        }
        if (isset($_POST['oddo_terakhir_oli_mesin'])) {
            $oddo_terakhir_oli_mesin = $this->input->POST('oddo_terakhir_oli_mesin');
        } else {
            $oddo_terakhir_oli_mesin = "";
        }
        if (isset($_POST['oddo_terakhir_oli_gardan'])) {
            $oddo_terakhir_oli_gardan = $this->input->POST('oddo_terakhir_oli_gardan');
        } else {
            $oddo_terakhir_oli_gardan = "";
        }
        if (isset($_POST['oddo_terakhir_oli_transmisi'])) {
            $oddo_terakhir_oli_transmisi = $this->input->POST('oddo_terakhir_oli_transmisi');
        } else {
            $oddo_terakhir_oli_transmisi = "";
        }
        if (isset($_POST['cicilan'])) {
            $cicilan = $this->input->POST('cicilan');
        } else {
            $cicilan = "";
        }

        $data = array(
            'nopol' => $nopol,
            'kategori' => $kategori,
            'id_vendor' => $vendor,
            'cicilan' => str_replace('.', '', $cicilan),
            'nomor_rangka' => $nomor_rangka,
            'nomor_mesin' => $nomor_mesin,
            'kir_terakhir' => $kir_terakhir,
            'pajak_tahunan' => $pajak_tahunan,
            'pajak_5_tahunan' => $pajak_5_tahunan,
            'oddo_terakhir' => str_replace('.', '', $oddo_terakhir),
            'oddo_terakhir_oli_mesin' => str_replace('.', '', $oddo_terakhir_oli_mesin),
            'oddo_terakhir_oli_gardan' => str_replace('.', '', $oddo_terakhir_oli_gardan),
            'oddo_terakhir_oli_transmisi' => str_replace('.', '', $oddo_terakhir_oli_transmisi)
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_truck", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_truck", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function delete_truck()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_truck($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }

    function perbaikan()
    {
        $data['perbaikan'] = $this->rms_model->get("v_perbaikan")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['sparepart'] = $this->rms_model->get("tbl_sparepart")->result();
        $data['content'] = 'rms/perbaikan/index';
        $this->load->view('rms/includes/template', $data);
    }

    function insert_sparepart_perbaikan()
    {
        $data = array(
            'id_perbaikan'  => $this->input->post('id_perbaikan'),
            'id_sparepart' => $this->input->post('id_sparepart'),
            'jumlah'   => $this->input->post('jumlah')
        );

        $this->rms_model->insert("tbl_perbaikan_sparepart", $data);
    }

    public function save_perbaikan()
    {
        $id = $this->input->POST('id');
        $truck = $this->input->POST('truck');
        $supir = $this->input->POST('supir');
        $tanggal = $this->input->POST('tanggal');
        $jenis = $this->input->POST('jenis');
        $jumlah = $this->input->POST('jumlah');
        $status = $this->input->POST('status');
        $data = array(
            'id_truck' => $truck,
            'id_supir' => $supir,
            'tanggal' => $tanggal,
            'jumlah' => str_replace('.', '', $jumlah),
            'jenis' => $jenis,
            'status' => $status,
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_perbaikan", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_perbaikan", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    function vendor()
    {
        $data['vendor'] = $this->rms_model->get("v_vendor")->result();
        $data['content'] = 'rms/vendor/index';
        $this->load->view('rms/includes/template', $data);
    }

    function klien()
    {
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['content'] = 'rms/klien/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_klien()
    {
        $id = $this->input->POST('id');
        $nama_perusahaan = $this->input->POST('nama');
        $alamat = $this->input->POST('nomor_rekening');
        $email = $this->input->POST('nama_rekening');
        $no_tlp = $this->input->POST('bank');
        $data = array(
            'nama_perusahaan' => $nama_perusahaan,
            'alamat' => $alamat,
            'email' => $email,
            'no_tlp' => $no_tlp,
            'status' => '1',
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_klien", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_klien", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_vendor()
    {
        $id = $this->input->POST('id');
        $nama = $this->input->POST('nama');
        $no_rekening = $this->input->POST('nomor_rekening');
        $nama_rekening = $this->input->POST('nama_rekening');
        $bank = $this->input->POST('bank');
        $jenis_pajak = $this->input->POST('jenis_pajak');
        $no_pajak = $this->input->POST('no_pajak');
        $nama_pajak = $this->input->POST('nama_pajak');
        $data = array(
            'nama' => $nama,
            'no_rekening' => $no_rekening,
            'nama_rekening' => $nama_rekening,
            'bank' => $bank,
            'jenis_pajak' => $jenis_pajak,
            'no_pajak' => $no_pajak,
            'nama_pajak' => $nama_pajak,
            'status' => '1',
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_vendor_truck", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_vendor_truck", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    function view_vendor($id)
    {
        $data['vendor'] = $this->rms_model->get("v_vendor", "WHERE id = $id")->row();
        $data['truck'] = $this->rms_model->get("tbl_truck", "WHERE id_vendor = $id")->result();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_vendor = $id")->result();
        $data['content'] = 'rms/vendor/view';
        $this->load->view('rms/includes/template', $data);
    }

    function load_data_sparepart_perbaikan($id)
    {
        $data = $this->rms_model->get("v_perbaikan_sparepart", "WHERE id_perbaikan = $id")->result();
        echo json_encode($data);
    }

    function sparepart()
    {
        $data['sparepart'] = $this->rms_model->get("tbl_sparepart")->result();
        $data['content'] = 'rms/sparepart/index';
        $this->load->view('rms/includes/template', $data);
    }

    function view_sparepart($id)
    {
        $data['sparepart'] = $this->rms_model->get("tbl_sparepart", "WHERE id = $id")->row();
        $data['riwayat_sparepart'] = $this->rms_model->get("v_perbaikan_sparepart", "WHERE id_sparepart = $id")->result();
        $data['content'] = 'rms/sparepart/view';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_sparepart()
    {
        $id = $this->input->POST('id');
        $nama = $this->input->POST('nama');
        $qty = $this->input->POST('qty');
        $harga = $this->input->POST('harga');
        $data = array(
            'nama' => $nama,
            'qty' => str_replace('.', '', $qty),
            'harga' => str_replace('.', '', $harga),
        );

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_sparepart", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_sparepart", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    function supir()
    {
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['content'] = 'rms/supir/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_supir()
    {
        $id = $this->input->POST('id');
        $nama = $this->input->POST('nama');
        $no_wa = $this->input->POST('no_wa');
        $no_ktp = $this->input->POST('no_ktp');
        $no_sim = $this->input->POST('no_sim');
        $kategori = $this->input->POST('kategori');

        $file_ktp = $_FILES['file_ktp']['name'];
        $file_sim = $_FILES['file_sim']['name'];

        $data_array = array(
            'nama' => $nama,
            'no_wa' => $no_wa,
            'no_ktp' => $no_ktp,
            'no_sim' => $no_sim,
            'kategori' => $kategori,
            'status' => '1',
        );

        if (!empty($file_ktp)) {
            $this->load->library('upload');
            $file_ktp = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_ktp);
            $filename_ktp = str_replace(' ', '_', time() . $file_ktp);
            $config['upload_path'] = 'assets/rms/documents/supir/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_ktp;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_ktp')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'file_ktp' => $filename_ktp
            );
        }
        if (!empty($file_sim)) {
            $this->load->library('upload');
            $file_sim = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_sim);
            $filename_sim = str_replace(' ', '_', time() . $file_sim);
            $config['upload_path'] = 'assets/rms/documents/supir/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_sim;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_sim')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'file_sim' => $filename_sim
            );
        }

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_supir", $data_array);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_supir", $data_array, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }


    function view_supir($id)
    {
        $data['supir'] = $this->rms_model->get("tbl_supir", "WHERE id = $id")->row();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_supir = $id")->result();
        $data['content'] = 'rms/supir/view';
        $this->load->view('rms/includes/template', $data);
    }


    function tujuan()
    {
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['content'] = 'rms/tujuan/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_tujuan()
    {
        $id = $this->input->POST('id');
        $kode_tujuan = $this->input->POST('kode_tujuan');
        $nama_tujuan = $this->input->POST('nama_tujuan');
        $harga = $this->input->POST('harga');
        $data = array(
            'kode_tujuan' => $kode_tujuan,
            'nama_tujuan' => $nama_tujuan,
            'harga' => str_replace('.', '', $harga),
        );

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_tujuan", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_tujuan", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_pembayaran_bongkar_muat()
    {
        $id_project = $this->input->POST('id_project');
        $id = $this->input->POST('id');
        $jenis = $this->input->POST('jenis');
        $jumlah = $this->input->POST('jumlah');
        $tanggal_pembayaran = $this->input->POST('tanggal_pembayaran');

        $data = array(
            'id_project' => $id_project,
            'jenis' => $jenis,
            'jumlah_pembayaran' => str_replace('.', '', $jumlah),
            'tanggal_pembayaran' => $tanggal_pembayaran
        );



        if ($id == "") {
            $save = $this->rms_model->insert("tbl_pembayaran_bongkar_muat", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_pembayaran_bongkar_muat", $data, $id_project);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_pembayaran_replas()
    {
        $id = $this->input->POST('id');
        $tanggal_bayar = $this->input->POST('tanggal_pembayaran');

        $data = array(
            'tanggal_pembayaran_replas' => $tanggal_bayar,
            'status' => '1',
        );

        $save = $this->rms_model->update("tbl_rekap", $data, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }
























    public function menu()
    {
        $data['product'] = $this->admin_model->get("tbl_menu", "ORDER BY position ASC")->result();
        $tree = $this->prepareList($data['product']);

        $data['li'] = $this->nav($tree);
        $data['content'] = 'rms/menu/index';
        $this->load->view('rms/includes/template', $data);
    }

    function prepareList(array $items, $pid = 0)
    {
        $output = array();
        foreach ($items as $item) {
            if ((int) $item->parent == $pid) {
                if ($children = $this->prepareList($items, $item->id)) {
                    $item->children = $children;
                }
                $output[] = $item;
            }
        }

        return $output;
    }

    function nav($menu_items, $child = false)
    {
        $output = '';
        if (count($menu_items) > 0) {
            $output .= ($child === false) ? '<ol class="dd-list">' : '<ol>';

            foreach ($menu_items as $item) {
                $output .= '<li class="dd-item" id="' . $item->id . '"  data-id="' . $item->id . '">';
                $output .= '<div class="dd-handle  box menu-box">' . $item->menu . '</div>';

                if (isset($item->children) && count($item->children)) {
                    $output .= '<div class="action-btn-box"><a href="javascript:void(0)" onclick="edit_data(this)" data-title="menu" data-id="' . $item->id . '"  data-tbl="tbl_menu" class="btn-sortable mr-1"><i class="fa fa-edit"></i></a></div>';
                } else {
                    $output .= '<div class="action-btn-box"><a href="javascript:void(0)" onclick="edit_data(this)" data-title="menu" data-id="' . $item->id . '"  data-tbl="tbl_menu" class="btn-sortable mr-1"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" onclick="delete_data(this)" data-title="menu" data-id="' . $item->id . '"  data-tbl="tbl_menu" class="btn-sortable"><i class="fa fa-trash-o"></i></a></div>';
                }
                //check if there are any children
                if (isset($item->children) && count($item->children)) {
                    $output .= $this->nav($item->children, true);
                }
                $output .= '</li>';
            }
            $output .= '</ol>';
        }
        return $output;
    }

    public function update_menu_priority()
    {
        $data = $this->input->post("product_data");

        if (count($data)) {
            $update = $this->admin_model->update_priority_data($data);

            if ($update) {
                $result['status'] = "success";
            } else {
                $result['status'] = "error";
            }
        } else {
            $result['status'] = "error";
        }
        echo json_encode($result);
    }





    public function approve_petugas()
    {
        $id = $this->input->POST('id');
        $tbl = $this->input->POST('tbl');
        $data = array(
            'status' => '1'
        );
        $get_petugas = $this->admin_model->get("tbl_petugas", "WHERE id = '$id'")->row();
        $email = $get_petugas->email;
        $delete = $this->admin_model->update($tbl, $data, $id);
        if ($delete) {
            $send = $this->email_approve_petugas($email);
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }

    function email_approve_petugas($email)
    {
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'system.ditjalsus@gmail.com',  // Email gmail
            'smtp_pass'   => 'andinovid',  // Password gmail
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            'crlf'    => "\r\n",
            'newline' => "\r\n",
        ];
        $message = '
                        <html><body>
						<p>Permohonan anda sebagai petugas daerah telah diapprove, silahkan login melalui link berikut <a href="' . base_url() . 'login/">' . base_url() . 'login/</a></p>
                        ';
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('system.ditjalsus@gmail.com', 'Ditjalsus');
        $this->email->to($email, 'Petugas');
        $this->email->cc('andi.novid@gmail.com');
        $this->email->subject('Approval Petugas');
        $this->email->message($message);
        $this->email->send();
        echo $this->email->print_debugger();
    }


    public function pages()
    {
        $data['pages'] = $this->admin_model->get("tbl_content", "WHERE category = '1'")->result();
        $data['content'] = 'rms/pages/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function petugas()
    {
        $data['petugas'] = $this->admin_model->get_by_query("SELECT a.*, b.nama as kabupaten, c.nama as provinsi FROM tbl_petugas a LEFT JOIN wilayah_kabupaten b ON a.id_kabupaten = b.id LEFT JOIN wilayah_provinsi c ON a.id_provinsi = c.id ORDER BY a.status DESC")->result();
        $data['content'] = 'rms/petugas/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function survey1()
    {
        $data['petugas'] = $this->admin_model->get_by_query("SELECT a.*, b.id as id_petugas, b.nama FROM tbl_survey a LEFT JOIN tbl_petugas b ON a.id_petugas = b.id")->result();
        $data['content'] = 'rms/survey/survey1';
        $this->load->view('rms/includes/template', $data);
    }
    public function survey2()
    {
        $data['petugas'] = $this->admin_model->get_by_query("SELECT a.*, b.id as id_petugas, b.nama FROM tbl_survey2 a LEFT JOIN tbl_petugas b ON a.id_petugas = b.id")->result();
        $data['content'] = 'rms/survey/survey2';
        $this->load->view('rms/includes/template', $data);
    }
    public function survey3()
    {
        $data['petugas'] = $this->admin_model->get_by_query("SELECT a.*, b.id as id_petugas, b.nama FROM tbl_survey3 a LEFT JOIN tbl_petugas b ON a.id_petugas = b.id")->result();
        $data['content'] = 'rms/survey/survey3';
        $this->load->view('rms/includes/template', $data);
    }

    public function news()
    {
        $data['news'] = $this->admin_model->get_by_query("SELECT * FROM tbl_content WHERE category = '2'")->result();
        $data['content'] = 'rms/news/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function gallery()
    {
        $data['gallery'] = $this->admin_model->get_by_query("SELECT * FROM tbl_gallery")->result();
        $data['content'] = 'rms/gallery/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function users()
    {
        $data['users'] = $this->admin_model->get_by_query("SELECT * FROM tbl_users")->result();
        $data['content'] = 'rms/user/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_news()
    {
        $id = $_POST["id"];
        $category = $_POST["category"];
        $title = $_POST["title"];
        $slug = $_POST["slug"];
        $content = $_POST["content"];
        $image = $_FILES['image']['name'];
        $status = $_POST["status"];
        $time = date("Y-m-d H:i:s");

        if (empty($image)) {
            $data = array(
                'title' => $title,
                'content' => $content,
                'image' => '',
                'slug' => $slug,
                'created_date' => $time,
                'category' => $category,
                'status' => $status,
            );
            $data2 = array(
                'title' => $title,
                'content' => $content,
                'slug' => $slug,
                'last_update' => $time,
                'category' => $category,
                'status' => $status,
            );
        } else {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $image);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'title' => $title,
                'content' => $content,
                'image' => $filename,
                'slug' => $slug,
                'created_date' => $time,
                'category' => $category,
                'status' => $status,
            );
            $data2 = array(
                'title' => $title,
                'content' => $content,
                'image' => $filename,
                'slug' => $slug,
                'last_update' => $time,
                'category' => $category,
                'status' => $status,
            );
        }
        if ($id == "") {
            $save = $this->admin_model->insert("tbl_content", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->admin_model->update("tbl_content", $data2, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_gallery()
    {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $image = $_FILES['image']['name'];
        $status = $_POST["status"];

        if (empty($image)) {
            $data = array(
                'title' => $title,
                'image' => '',
                'status' => $status,
            );
            $data2 = array(
                'title' => $title,
                'status' => $status,
            );
        } else {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $image);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'title' => $title,
                'image' => $filename,
                'status' => $status,
            );
            $data2 = array(
                'title' => $title,
                'image' => $filename,
                'status' => $status,
            );
        }
        if ($id == "") {
            $save = $this->admin_model->insert("tbl_gallery", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->admin_model->update("tbl_gallery", $data2, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_user()
    {
        $id = $_POST["id"];
        $title = $_POST["name"];
        $username = $_POST["username"];
        $password = md5($_POST["password_user"]);
        $status = $_POST["status"];

        $data = array(
            'name' => $title,
            'username' => $username,
            'password' => $password,
            'status' => $status,
        );

        if (empty($password)) {
            $data2 = array(
                'name' => $title,
                'username' => $username,
                'status' => $status,
            );
        } else {
            $data2 = array(
                'name' => $title,
                'username' => $username,
                'password' => $password,
                'status' => $status,
            );
        }
        if ($id == "") {
            $save = $this->admin_model->insert("tbl_users", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->admin_model->update("tbl_users", $data2, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function setting()
    {
        $data['content'] = 'rms/web_setting/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function banner()
    {
        $data['content'] = 'rms/banner/index';
        $this->load->view('rms/includes/template', $data);
    }
    public function get_banner()
    {
        $data = $this->admin_model->get("tbl_banner", "WHERE id = 1");
        $detail = $data->result();
        echo json_encode($detail);
    }

    public function get_web_setting()
    {
        $data = $this->admin_model->get("tbl_web_setting", "");
        $detail = $data->result();
        echo json_encode($detail);
    }

    public function update_web_setting()
    {
        $id = '1';
        $judul_web = $_POST["judul_web"];
        $alamat = $_POST["alamat"];
        $tlp = $_POST["tlp"];
        $email = $_POST["email"];
        $file_pedoman = $_FILES['file_pedoman']['name'];
        $file_petunjuk = $_FILES['file_petunjuk']['name'];

        if (empty($file_pedoman) && empty($file_petunjuk)) {
            $data = array(
                'judul_web' => $judul_web,
                'alamat' => $alamat,
                'tlp' => $tlp,
                'email' => $email,
            );
        } elseif (!empty($file_pedoman) && empty($file_petunjuk)) {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_pedoman);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|png';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_pedoman')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'judul_web' => $judul_web,
                'alamat' => $alamat,
                'tlp' => $tlp,
                'email' => $email,
                'file_pedoman' => $filename,
            );
        } elseif (empty($file_pedoman) && !empty($file_petunjuk)) {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_petunjuk);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|png';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_petunjuk')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'judul_web' => $judul_web,
                'alamat' => $alamat,
                'tlp' => $tlp,
                'email' => $email,
                'file_petunjuk' => $filename,
            );
        } elseif (!empty($file_pedoman) && !empty($file_petunjuk)) {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_pedoman);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|png';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_pedoman')) {
                $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }

            $image2 = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_petunjuk);
            $filename2 = str_replace(' ', '_', time() . $image2);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|jpg|png';
            $config['file_name'] = $filename2;
            $config['max_size'] = '1000000';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_petunjuk')) {
                $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'judul_web' => $judul_web,
                'alamat' => $alamat,
                'tlp' => $tlp,
                'email' => $email,
                'file_pedoman' => $filename,
                'file_petunjuk' => $filename2,
            );
        }

        $save = $this->admin_model->update("tbl_web_setting", $data, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }

    public function update_banner()
    {
        $id = '1';
        $title = $_POST["judul"];
        $description = $_POST["deskripsi"];
        $label_button = $_POST["label_button"];
        $file_pedoman = $_FILES['file_video']['name'];

        if (empty($file_pedoman)) {
            $data = array(
                'title' => $title,
                'description' => $description,
            );
        } else {
            $image = preg_replace("/[^a-zA-Z0-9.]/", "_", $file_pedoman);
            $filename = str_replace(' ', '_', time() . $image);
            $this->load->library('upload');
            $config['upload_path'] = 'assets/main/uploads/';
            $config['file_name'] = $filename;
            $config['max_size'] = '1000000';
            $config['allowed_types'] = 'mp4';
            $this->upload->initialize($config);
            if ($this->upload->do_upload('file_video')) {
                $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data = array(
                'title' => $title,
                'description' => $description,
                'image' => $filename,
                'btn_text' => $label_button,
                'url' => base_url() . "assets/main/uploads/" . $filename,
            );
        }

        $save = $this->admin_model->update("tbl_banner", $data, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }
}
