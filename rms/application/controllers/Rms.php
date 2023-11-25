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
        if ($this->sess->role == '5') {
            $id_supir = $this->sess->id_supir;
            $data['truck'] = $this->rms_model->get("v_truck", "WHERE id_supir = '$id_supir'")->row();
        } else {
            $data['all_project'] = $this->rms_model->get("v_project")->num_rows();
            $data['project_on_progress'] = $this->rms_model->get("v_project", "WHERE status = '0' OR status = '1'")->num_rows();
            $data['project_complete'] = $this->rms_model->get("v_project", "WHERE status = '2'")->num_rows();
            $data['saldo'] = $this->rms_model->get_by_query("SELECT SUM(CASE WHEN jenis = '1' THEN jumlah ELSE 0 END) -  SUM(CASE WHEN jenis = '2' THEN jumlah ELSE 0 END) as total FROM tbl_keuangan")->row();
            $data['project_on_progress_list'] = $this->rms_model->get("v_project", "WHERE (status = '0' OR status = '1') AND total_terkirim > 0 LIMIT 8")->result();
            $data['truck'] = $this->rms_model->get("v_truck", "WHERE kategori = '1' LIMIT 8")->result();
        }

        $data['content'] = 'rms/dashboard/dashboard';
        $this->load->view('rms/includes/template', $data);
    }

    function project()
    {
        $data['project'] = $this->rms_model->get("v_project", "ORDER BY tanggal_input DESC")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['penagih'] = $this->rms_model->get("tbl_penagih")->result();
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

    function replas()
    {
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_vendor !='1'")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['content'] = 'rms/project/replas';
        $this->load->view('rms/includes/template', $data);
    }

    function non_do()
    {
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE non_do = '1'")->result();
        $data['klien'] = $this->rms_model->get("tbl_klien")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['vendor'] = $this->rms_model->get("tbl_vendor_truck")->result();
        $data['komoditas'] = $this->rms_model->get("tbl_komoditas")->result();
        $data['content'] = 'rms/project/non_do';
        $this->load->view('rms/includes/template', $data);
    }

    function view_project($id_project)
    {
        $data['project'] = $this->rms_model->get("v_project", "WHERE id_project = $id_project")->row();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_project = $id_project ORDER BY tanggal_input DESC")->result();
        $data['total'] = $this->rms_model->get_by_query("SELECT SUM(bruto_awal) as total_bruto_awal, SUM(bruto_akhir) as total_bruto_akhir, SUM(tarra_awal) as total_tarra_awal, SUM(tarra_akhir) as total_tarra_akhir, SUM(timbang_kebun_bag) as total_qty_awal_bag, SUM(timbang_kebun_kg) as total_qty_awal_kg, SUM(qty_kirim_bag) as total_qty_akhir_bag, SUM(qty_kirim_kg) as total_qty_akhir_kg, SUM(m_susut) as total_susut  FROM v_rekap WHERE id_project = $id_project")->row();
        $data['pembayaran_replas'] = $this->rms_model->get("v_rekap", "WHERE id_project = $id_project AND status ='1'")->result();
        $data['pembayaran_bongkar_muat'] = $this->rms_model->get("tbl_pembayaran_bongkar_muat", "WHERE id_project = $id_project")->result();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck")->result();
        $data['tujuan'] = $this->rms_model->get("tbl_tujuan")->result();
        $data['vendor'] = $this->rms_model->get("tbl_vendor_truck")->result();
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

    public function get_kwitansi()
    {
        $id = $this->input->POST('id');
        $data = $this->rms_model->get("v_kwitansi", "WHERE id_kwitansi = $id");
        $detail = $data->result();
        echo json_encode($detail);
    }



    public function save_replas()
    {
        $id = $this->input->POST('id');
        $id_project = $this->input->POST('id_project');
        $no_replas = $this->input->POST('no_replas');
        $tanggal_muat = $this->input->POST('tanggal_muat');
        $tanggal_bongkar = $this->input->POST('tanggal_bongkar');
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

        if ($this->input->POST('bruto_awal')) {
            $bruto_awal = $this->input->POST('bruto_awal');
        } else {
            $bruto_awal = NULL;
        }
        if ($this->input->POST('tarra_awal')) {
            $tarra_awal = $this->input->POST('tarra_awal');
        } else {
            $tarra_awal = NULL;
        }
        if ($this->input->POST('bruto_akhir')) {
            $bruto_akhir = $this->input->POST('bruto_akhir');
        } else {
            $bruto_akhir = NULL;
        }
        if ($this->input->POST('tarra_akhir')) {
            $tarra_akhir = $this->input->POST('tarra_akhir');
        } else {
            $tarra_akhir = NULL;
        }
        if ($this->input->POST('no_tiket')) {
            $no_tiket = $this->input->POST('no_tiket');
        } else {
            $no_tiket = NULL;
        }

        $tanggal_bongkar = $this->input->POST('tanggal_bongkar');
        $supir = $this->input->POST('supir');
        $truck = $this->input->POST('truck');
        $vendor_pajak = $this->input->POST('vendor_pajak');
        $vendor_pencairan = $this->input->POST('vendor_pencairan');
        $tujuan = $this->input->POST('tujuan');
        $qty_kirim_bag = $this->input->POST('qty_kirim_bag');
        $qty_kirim_kg = $this->input->POST('qty_kirim_kg');
        $timbang_kebun_bag = $this->input->POST('timbang_kebun_bag');
        $timbang_kebun_kg = $this->input->POST('timbang_kebun_kg');
        $uang_sangu = $this->input->POST('uang_sangu');
        $toleransi_susut = $this->input->POST('toleransi_susut');
        $tanggal_input = date('Y-m-d H:i:s');

        $data = array(
            'no_replas' => $no_replas,
            'no_tiket' => $no_tiket,
            'id_project' => $id_project,
            'tanggal_muat' => $tanggal_muat,
            'tanggal_bongkar' => $tanggal_bongkar,
            'id_supir' => $supir,
            'id_truck' => $truck,
            'id_vendor_pencairan' => $vendor_pencairan,
            'id_vendor_pajak' => $vendor_pajak,
            'id_tujuan' => $tujuan,
            'bruto_awal' => str_replace('.', '', $bruto_awal),
            'tarra_awal' => str_replace('.', '', $tarra_awal),
            'bruto_akhir' => str_replace('.', '', $bruto_akhir),
            'tarra_akhir' => str_replace('.', '', $tarra_akhir),
            'qty_kirim_bag' => $qty_kirim_bag,
            'qty_kirim_kg' => str_replace('.', '', $qty_kirim_kg),
            'timbang_kebun_bag' => $timbang_kebun_bag,
            'timbang_kebun_kg' => str_replace('.', '', $timbang_kebun_kg),
            'toleransi_susut' => $toleransi_susut,
            'uang_sangu' => str_replace('.', '', $uang_sangu),
            'non_do' => '0',
            'status' => '0',
        );

        $data2 = array(
            'status' => '1',
        );

        if ($id == "") {
            $data += array(
                'tanggal_input' => $tanggal_input
            );
            $save = $this->rms_model->insert("tbl_rekap", $data);
            $this->rms_model->update("tbl_project", $data2, $id_project);
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

    public function save_replas_non_do()
    {
        $id = $this->input->POST('id');
        $supir = $this->input->POST('supir');
        $truck = $this->input->POST('truck');
        $komoditas = $this->input->POST('komoditas');
        $tujuan = $this->input->POST('tujuan');
        $timbang_kebun = $this->input->POST('timbang_kebun_kg');
        $qty_kirim_kg = $this->input->POST('qty_kirim_kg');
        $harga = $this->input->POST('harga');
        $harga_supir = $this->input->POST('harga_supir');
        $uang_sangu = $this->input->POST('uang_sangu');
        $tanggal_input = date('Y-m-d H:i:s');
        $vendor_pencairan = $this->input->POST('vendor_pencairan');
        $data = array(
            'id_supir' => $supir,
            'id_truck' => $truck,
            'non_do_id_komoditas' => $komoditas,
            'id_tujuan' => $tujuan,
            'id_vendor_pencairan' => $vendor_pencairan,
            'timbang_kebun_kg' => $timbang_kebun,
            'qty_kirim_kg' => $qty_kirim_kg,
            'non_do_harga' => $harga,
            'non_do_harga_vendor' => $harga_supir,
            'uang_sangu' => str_replace('.', '', $uang_sangu),
            'non_do' => '1',
            'status' => '0',
            'tanggal_input' => $tanggal_input,
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

    public function delete_invoice()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_invoice($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }
    public function delete_kwitansi()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_kwitansi($id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
    }


    public function delete_perbaikan()
    {
        $id = $this->input->POST('id');
        $delete = $this->rms_model->delete_perbaikan($id);
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
        $claim_replas = $this->input->POST('claim_replas');
        $deskripsi = $this->input->POST('deskripsi');
        $penagih = $this->input->POST('penagih');
        $tanggal_input = date('Y-m-d H:i:s');

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
            'claim_replas' => str_replace('.', '', $claim_replas),
            'deskripsi' => $deskripsi,
            'id_penagih' => $penagih,
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
            $data_array += array(
                'tanggal_input' => $tanggal_input
            );
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
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['content'] = 'rms/truck/index';
        $this->load->view('rms/includes/template', $data);
    }

    function view_truck($id_truck)
    {
        $data['truck'] = $this->rms_model->get("v_truck", "WHERE id_truck = $id_truck")->row();
        $data['supir'] = $this->rms_model->get("tbl_supir")->result();
        $data['rekap'] = $this->rms_model->get("v_rekap", "WHERE id_truck = $id_truck")->result();
        $data['perbaikan'] = $this->rms_model->get("v_perbaikan", "WHERE id_truck = $id_truck")->result();
        $data['bbm'] = $this->rms_model->get("v_bbm", "WHERE id_truck = $id_truck ORDER BY tanggal DESC")->result();
        $data['content'] = 'rms/truck/view';
        $this->load->view('rms/includes/template', $data);
    }

    public function save_pengisian_bbm()
    {
        $id = $this->input->POST('id');
        $truck = $this->input->POST('id_truck');
        $supir = $this->input->POST('supir');
        $tanggal = $this->input->POST('tanggal');
        $jumlah_liter = $this->input->POST('jumlah_liter');
        $jumlah_harga = $this->input->POST('jumlah_harga');
        $nama_supir = $this->input->POST('nama_supir');
        $data = array(
            'id_truck' => $truck,
            'id_supir' => $supir,
            'tanggal' => $tanggal,
            'jumlah_liter' => $jumlah_liter,
            'jumlah_harga' => str_replace('.', '', $jumlah_harga),
        );

        $data_update_truck = array(
            'bbm_terakhir' => shortdate_indo($tanggal) . ' | ' . $jumlah_liter . 'L ' . ' | ' . $jumlah_harga . ' | ' . $nama_supir,
        );

        $save = $this->rms_model->update("tbl_truck", $data_update_truck, $truck);

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_pengisian_bbm", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_pengisian_bbm", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
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
        if (isset($_POST['jenis_truck'])) {
            $jenis_truck = $this->input->POST('jenis_truck');
        } else {
            $jenis_truck = "";
        }
        if (isset($_POST['supir'])) {
            $supir = $this->input->POST('supir');
        } else {
            $supir = "";
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

        if (isset($_POST['air_radiator'])) {
            $air_radiator = $this->input->POST('air_radiator');
        } else {
            $air_radiator = "";
        }

        $data = array(
            'nopol' => $nopol,
            'kategori' => $kategori,
            'id_vendor' => $vendor,
            'cicilan' => str_replace('.', '', $cicilan),
            'jenis_truck' => $jenis_truck,
            'id_supir' => $supir,
            'nomor_rangka' => $nomor_rangka,
            'nomor_mesin' => $nomor_mesin,
            'kir_terakhir' => $kir_terakhir,
            'pajak_tahunan' => $pajak_tahunan,
            'pajak_5_tahunan' => $pajak_5_tahunan,
            'oddo_terakhir' => str_replace('.', '', $oddo_terakhir),
            'oddo_terakhir_oli_mesin' => str_replace('.', '', $oddo_terakhir_oli_mesin),
            'oddo_terakhir_oli_gardan' => str_replace('.', '', $oddo_terakhir_oli_gardan),
            'oddo_terakhir_oli_transmisi' => str_replace('.', '', $oddo_terakhir_oli_transmisi),
            'air_radiator_terakhir' => $air_radiator
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
        $id_sparepart = $this->input->post('id_sparepart');
        $data = array(
            'id_perbaikan'  => $this->input->post('id_perbaikan'),
            'id_sparepart' => $this->input->post('id_sparepart'),
            'jumlah'   => $this->input->post('jumlah')
        );
        $sparepart = $this->rms_model->get("tbl_sparepart", "WHERE id = $id_sparepart")->row();

        $qty = $sparepart - $this->input->post('jumlah');
        $data_update = array(
            'qty'   => $qty,
        );
        $this->rms_model->update("tbl_sparepart", $data_update, $id_sparepart);
        $this->rms_model->insert("tbl_perbaikan_sparepart", $data);
    }

    function delete_perbaikan_sparepart()
    {
        $id = $this->input->POST('id');
        $id_sparepart = $this->input->POST('id_sparepart');
        $jumlah = $this->input->POST('jumlah');

        $sparepart = $this->rms_model->get("tbl_sparepart", "WHERE id = '$id_sparepart'")->row();
        $qty = $sparepart + $jumlah;

        $data_update = array(
            'qty'   => $qty,
        );
        $this->rms_model->update("tbl_sparepart", $data_update, $id_sparepart);

        $delete = $this->rms_model->delete_data("tbl_perbaikan_sparepart", $id);
        if ($delete) {
            echo json_encode(array("status" => TRUE));
        }
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
        $nopol = $this->input->POST('nopol');
        $nama_supir = $this->input->POST('nama_supir');

        $nota = $_FILES['nota']['name'];

        $data_array = array(
            'id_truck' => $truck,
            'nopol' => $nopol,
            'id_supir' => $supir,
            'nama_supir' => $nama_supir,
            'tanggal' => $tanggal,
            'jumlah' => str_replace('.', '', $jumlah),
            'jenis' => $jenis,
            'status' => $status,
        );

        if (!empty($nota)) {
            $this->load->library('upload');
            $nota = preg_replace("/[^a-zA-Z0-9.]/", "_", $nota);
            $filename_spk = str_replace(' ', '_', time() . $nota);
            $config['upload_path'] = './assets/rms/documents/nota_perbaikan/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_spk;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('nota')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'nota' => $filename_spk,
            );
        }





        if ($id == "") {
            $save = $this->rms_model->insert_id("tbl_perbaikan", $data_array);
            if ($status == '1') {
                $data_keuangan = array(
                    'jenis' => '2',
                    'keterangan' => 'BAYAR NOTA ' . $nama_supir . ' - ' . $nopol,
                    'jumlah' => str_replace('.', '', $jumlah),
                    'tanggal' => date('Y-m-d'),
                    'id_perbaikan' => $save,
                );
                $this->rms_model->insert("tbl_keuangan", $data_keuangan);
            }
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_perbaikan", $data_array, $id);
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
        $nama_perusahaan = $this->input->POST('nama_perusahaan');
        $alamat = $this->input->POST('alamat');
        $email = $this->input->POST('email');
        $no_tlp = $this->input->POST('no_tlp');
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
        $no_hp = $this->input->POST('no_hp');
        $no_rekening = $this->input->POST('nomor_rekening');
        $nama_rekening = $this->input->POST('nama_rekening');
        $bank = $this->input->POST('bank');
        $jenis_pajak = $this->input->POST('jenis_pajak');
        $no_pajak = $this->input->POST('no_pajak');
        $nama_pajak = $this->input->POST('nama_pajak');
        $data = array(
            'nama' => $nama,
            'no_hp' => $no_hp,
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

        $foto = $_FILES['foto']['name'];
        $data_array = array(
            'nama' => $nama,
            'qty' => str_replace('.', '', $qty),
            'harga' => str_replace('.', '', $harga),
        );

        if (!empty($foto)) {
            $this->load->library('upload');
            $foto = preg_replace("/[^a-zA-Z0-9.]/", "_", $foto);
            $filename_spk = str_replace(' ', '_', time() . $foto);
            $config['upload_path'] = 'assets/rms/documents/sparepart/';
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
            $config['file_name'] = $filename_spk;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('foto')) {
                $data = $this->upload->data();
            } else {
                echo $this->upload->display_errors();
            }
            $data_array += array(
                'foto' => $filename_spk
            );
        }

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_sparepart", $data_array);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_sparepart", $data_array, $id);
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
        $data['supir_rws'] = $this->rms_model->get("tbl_supir", "WHERE kategori = '1'")->result();
        $data['supir_vendor'] = $this->rms_model->get("tbl_supir", "WHERE kategori = '2'")->result();
        $data['truck'] = $this->rms_model->get("tbl_truck", "WHERE kategori = '1'")->result();
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
        $nama_kebun = $this->input->POST('nama_kebun');
        $penagih = $this->input->POST('penagih');
        $tonase = $this->input->POST('tonase');
        $tanggal_pembayaran = $this->input->POST('tanggal_pembayaran');

        $data = array(
            'id_project' => $id_project,
            'jenis' => $jenis,
            'nama_kebun' => $nama_kebun,
            'penagih' => $penagih,
            'tonase' => str_replace('.', '', $tonase),
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
            $save = $this->rms_model->update("tbl_pembayaran_bongkar_muat", $data, $id);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        }
    }

    public function save_pembayaran_invoice()
    {
        $id = $this->input->POST('id');
        $tanggal_bayar = $this->input->POST('tanggal_pembayaran');
        $status = $this->input->POST('status');

        $data = array(
            'id_invoice' => $id,
            'tanggal' => $tanggal_bayar,
            'status' => $status,
        );
        $this->rms_model->insert("tbl_pembayaran_invoice", $data);
        $data_update = array(
            'status' => $status,
        );

        $save = $this->rms_model->update("tbl_invoice", $data_update, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
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


    public function save_pembayaran_kwitansi()
    {
        $id = $this->input->POST('id');
        $tanggal_bayar = $this->input->POST('tanggal_pembayaran');

        $data = array(
            'tanggal_pembayaran' => $tanggal_bayar,
            'status' => '1',
        );

        $data_rekap = array(
            'tanggal_pembayaran_replas' => $tanggal_bayar,
            'status' => '1',
        );

        $save = $this->rms_model->update("tbl_kwitansi", $data, $id);
        if ($save) {
            $this->rms_model->update("tbl_rekap", $data_rekap, $id);
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }


    function keuangan()
    {
        $data['keuangan'] = $this->rms_model->get("tbl_keuangan", "ORDER BY tanggal_input DESC")->result();
        $data['saldo'] = $this->rms_model->get_by_query("SELECT SUM(CASE WHEN jenis = '1' THEN jumlah ELSE 0 END) -  SUM(CASE WHEN jenis = '2' THEN jumlah ELSE 0 END) as total FROM tbl_keuangan")->row();
        $data['content'] = 'rms/keuangan/index';
        $this->load->view('rms/includes/template', $data);
    }

    function laporan_komoditas()
    {
        $data['laporan'] = $this->rms_model->get("v_laporan_komoditas", "WHERE (year(tanggal_angkut),month(tanggal_angkut)) = (year(now()),month(now())) ORDER BY tanggal_angkut ASC")->result();
        $data['content'] = 'rms/laporan/kokmoditas';
        $this->load->view('rms/includes/template', $data);
    }


    public function save_keuangan()
    {
        $id = $this->input->POST('id');
        $jenis = $this->input->POST('jenis');
        $jumlah = $this->input->POST('jumlah');
        $keterangan = $this->input->POST('keterangan');
        $tanggal = $this->input->POST('tanggal');


        $data = array(
            'tanggal' => $tanggal,
            'jumlah' => str_replace('.', '', $jumlah),
            'jenis' => $jenis,
            'keterangan' => $keterangan,
        );

        if ($id == "") {
            $save = $this->rms_model->insert("tbl_keuangan", $data);
            if ($save) {
                echo json_encode(array(
                    "status" => TRUE,
                    "target" => TRUE
                ));
            }
        } else {
            $save = $this->rms_model->update("tbl_keuangan", $data, $id);
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
        $data['content'] = 'rms/setting/index';
        $this->load->view('rms/includes/template', $data);
    }

    public function get_setting()
    {
        $data = $this->rms_model->get("tbl_adm_setting", "");
        $detail = $data->result();
        echo json_encode($detail);
    }

    public function update_setting()
    {
        $id = '5';
        $biaya_admin = $_POST["biaya_admin"];
        $pph_skb = $_POST["pph_skb"];
        $pph_npwp = $_POST["pph_npwp"];
        $max_oli_mesin_euro3 = $_POST["max_oli_mesin_euro3"];
        $max_oli_mesin_euro4 = $_POST["max_oli_mesin_euro4"];
        $max_oli_mesin_isuzu = $_POST["max_oli_mesin_isuzu"];
        $max_oli_gardan_euro3 = $_POST["max_oli_gardan_euro3"];
        $max_oli_gardan_euro4 = $_POST["max_oli_gardan_euro4"];
        $max_oli_gardan_isuzu = $_POST["max_oli_gardan_isuzu"];
        $max_oli_transmisi_euro3 = $_POST["max_oli_transmisi_euro3"];
        $max_oli_transmisi_euro4 = $_POST["max_oli_transmisi_euro4"];
        $max_oli_transmisi_isuzu = $_POST["max_oli_transmisi_isuzu"];


        $data = array(
            'biaya_admin' => str_replace('.', '', $biaya_admin),
            'pph_skb' => $pph_skb,
            'pph_npwp' => $pph_npwp,
            'max_oli_mesin_euro3' => str_replace('.', '', $max_oli_mesin_euro3),
            'max_oli_mesin_euro4' => str_replace('.', '', $max_oli_mesin_euro4),
            'max_oli_mesin_isuzu' => str_replace('.', '', $max_oli_mesin_isuzu),
            'max_oli_gardan_euro3' => str_replace('.', '', $max_oli_gardan_euro3),
            'max_oli_gardan_euro4' => str_replace('.', '', $max_oli_gardan_euro4),
            'max_oli_gardan_isuzu' => str_replace('.', '', $max_oli_gardan_isuzu),
            'max_oli_transmisi_euro3' => str_replace('.', '', $max_oli_transmisi_euro3),
            'max_oli_transmisi_euro4' => str_replace('.', '', $max_oli_transmisi_euro4),
            'max_oli_transmisi_isuzu' => str_replace('.', '', $max_oli_transmisi_isuzu),
        );

        $save = $this->rms_model->update("tbl_adm_setting", $data, $id);
        if ($save) {
            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }


    function kwitansi()
    {
        $data['kwitansi'] = $this->rms_model->get("v_kwitansi")->result();
        $data['content'] = 'rms/kwitansi/kwitansi';
        $this->load->view('rms/includes/template', $data);
    }

    function kwitansi_non_do()
    {
        $data['kwitansi'] = $this->rms_model->get_by_query("SELECT *, COUNT(id) AS total_replas FROM v_rekap_non_do WHERE status = '0' GROUP BY id_vendor")->result();
        $data['content'] = 'rms/project/kwitansi_non_do';
        $this->load->view('rms/includes/template', $data);
    }




    public function print_kwitansi($id_kwitansi)
    {

        $detail_kwitansi = $this->rms_model->get_by_query("SELECT * FROM v_kwitansi WHERE id_kwitansi = '$id_kwitansi'")->row();
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('Rajawali System')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Kwitansi")
            ->setSubject("Kwitansi")
            ->setDescription("Kwitansi")
            ->setKeywords("Kwitansi");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DDDDDD')
            )
        );

        $excel->getActiveSheet()->getStyle('O3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ffe100')
                )
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_center = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );
        $style_border = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "KWITANSI");
        $excel->setActiveSheetIndex(0)->setCellValue('A2', "CV RAJA WALI SAMPIT");
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "Untuk Pembayaran");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "GROUP");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', $detail_kwitansi->vendor);
        $excel->setActiveSheetIndex(0)->setCellValue('F5', "NO HP");
        $excel->setActiveSheetIndex(0)->setCellValue('G5', $detail_kwitansi->no_hp);
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "NO REK");
        $excel->setActiveSheetIndex(0)->setCellValue('G6', $detail_kwitansi->bank . ' ' . $detail_kwitansi->no_rekening . ' a/n ' . $detail_kwitansi->nama_rekening);
        $excel->setActiveSheetIndex(0)->setCellValue('O3', "NOMOR KWITANSI : $detail_kwitansi->no_kwitansi");
        $excel->setActiveSheetIndex(0)->setCellValue('Q4', "Lembar 1");

        $excel->getActiveSheet()->mergeCells('A1:Q1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A4:E4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('O3:Q3'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G6:K6'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G5:K5'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G4:K4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A2:Q2'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('Q4')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('O3:Q3')->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('Q4')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('O3')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(true); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('Q4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('O3:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A8', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B8', "TGL");
        $excel->setActiveSheetIndex(0)->setCellValue('C8', "QTY AWAL");
        $excel->setActiveSheetIndex(0)->setCellValue('D8', "QTY AKHIR");
        $excel->setActiveSheetIndex(0)->setCellValue('E8', "SUPIR");
        $excel->setActiveSheetIndex(0)->setCellValue('F8', "NOPOL");
        $excel->setActiveSheetIndex(0)->setCellValue('G8', "ANGKUT");
        $excel->setActiveSheetIndex(0)->setCellValue('H8', "TUJUAN");
        $excel->setActiveSheetIndex(0)->setCellValue('I8', "M");
        $excel->setActiveSheetIndex(0)->setCellValue('J8', "C");
        $excel->setActiveSheetIndex(0)->setCellValue('K8', "HARGA");
        $excel->setActiveSheetIndex(0)->setCellValue('L8', "TOTAL");
        $excel->setActiveSheetIndex(0)->setCellValue('M8', "CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('N8', "TTL CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('O8', "Pph %");
        $excel->setActiveSheetIndex(0)->setCellValue('P8', "ADM");
        $excel->setActiveSheetIndex(0)->setCellValue('Q8', "GRAND TOTAL");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col);

        $kwitansi = $this->rms_model->get("v_generate_kwitansi", "WHERE id_kwitansi = '$id_kwitansi'")->result();


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 9;
        $numrow2 = 10; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($kwitansi as $data) { // Lakukan looping pada variabel siswa

            if ($data->jenis_pajak == 'skb') {
                $pph = '0.5%';
                $jenis_pajak = "SKB";
            } elseif ($data->jenis_pajak == 'ktp') {
                $pph = '4%';
                $jenis_pajak = "KTP";
            } elseif ($data->jenis_pajak == 'npwp') {
                $pph = '2%';
                $jenis_pajak = "NPWP";
            }

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            if ($data->non_do == '1') {
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo(date('Y-m-d')));
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo($data->tanggal_bongkar));
            }
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->timbang_kebun_kg);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->qty_kirim_kg);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nama_supir);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->nopol);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->komoditas);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->kode_tujuan);
            if ($data->non_do == '1') {
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, '0');
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, '0');
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->m_susut);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->c_claim);
            }
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 'Rp ' . number_format($data->harga, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($data->total, 0, "", "."));
            if ($data->non_do == '1') {
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, '0');
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '0');
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '0');
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, 'Rp ' . number_format($data->claim, 0, "", "."));
                $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, 'Rp ' . number_format($data->total_claim, 0, "", "."));
                $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, 'Rp ' . number_format($data->pph, 0, "", "."));
            }
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, 'Rp ' . number_format($data->biaya_admin, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, 'Rp ' . number_format($data->grand_total, 0, "", "."));
            //$excel->setActiveSheetIndex(0)->insertNewRowBefore(2,1); 
            if ($data->non_do != '1') {
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow2, $jenis_pajak . ' ' . $data->no_pajak . ' - ' . $data->nama_pajak);
            $excel->getActiveSheet()->mergeCells('M' . $numrow2 . ':' . 'Q' . $numrow2); // Set Merge Cell pada kolom A1 sampai E1
            $excel->getActiveSheet()->getStyle('A' . $numrow2 . ':' . 'Q' . $numrow2)->applyFromArray($style_row);
            }
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow = $numrow + 2; // Tambah 1 setiap kali looping
            $numrow2 = $numrow2 + 2;
        }

        $total = $numrow + 1;
        $sebesar = $numrow + 3;
        $terbilang = $numrow + 4;
        $ttd = $numrow + 4;
        $ttd_bottom = $ttd + 3;
        $ttd_periksa = $ttd_bottom + 1;


        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'Total Qty');
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $detail_kwitansi->qty_awal);
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $detail_kwitansi->qty_akhir);
        $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_kotor_replas, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_claim, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_pph, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, 'Rp ' . number_format($detail_kwitansi->total_biaya_admin, 0, "", "."));
        $excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'Q' . $numrow)->applyFromArray($style_row);





        $excel->setActiveSheetIndex(0)->setCellValue('P' . $total, 'Total');
        $excel->setActiveSheetIndex(0)->setCellValue('Q' . $total, 'Rp ' . number_format($detail_kwitansi->grand_total, 0, "", "."));
        $excel->getActiveSheet()->getStyle('P' . $total)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('Q' . $total)->applyFromArray($style_row);

        $excel->setActiveSheetIndex(0)->setCellValue('A' . $sebesar, 'Sebesar');
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $sebesar, 'Rp ' . number_format($detail_kwitansi->grand_total, 0, "", "."));
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $terbilang, '(' . ucwords(terbilang($detail_kwitansi->grand_total)) . ' Rupiah)');
        $excel->getActiveSheet()->getStyle('C' . $terbilang)->getFont()->setItalic(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('C' . $terbilang)->getFont()->setSize(10); // Set font size 15 untuk kolom A1


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $sebesar, 'Sampit, ' . shortdate_indo(date('Y-m-d')));
        $excel->getActiveSheet()->mergeCells('G' . $sebesar . ':' . 'O' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $sebesar . ':' . 'H' . $sebesar)->applyFromArray($style_center);

        $excel->getActiveSheet()->mergeCells('A' . $sebesar . ':' . 'B' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('C' . $sebesar . ':' . 'E' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('C' . $terbilang . ':' . 'E' . $terbilang); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setSize(16); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('C' . $sebesar)->getFont()->setItalic(TRUE); // Set bold kolom A1


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd, 'Direkap oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd_periksa, 'SAURINA');
        $excel->getActiveSheet()->mergeCells('G' . $ttd . ':' . 'i' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd . ':' . 'i' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('G' . $ttd_periksa . ':' . 'i' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd, 'Diperiksa oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd_periksa, 'ANISA');
        $excel->getActiveSheet()->mergeCells('J' . $ttd . ':' . 'L' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd . ':' . 'L' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('J' . $ttd_periksa . ':' . 'L' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd, 'Diterima oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd_periksa, $detail_kwitansi->vendor);
        $excel->getActiveSheet()->mergeCells('M' . $ttd . ':' . 'O' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd . ':' . 'O' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('M' . $ttd_periksa . ':' . 'O' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(3); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Siswa");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="kwitansi_' . $detail_kwitansi->vendor . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function print_kwitansi_non_do($id_vendor)
    {

        $detail_kwitansi = $this->rms_model->get_by_query("SELECT *, SUM(total_supir) AS grand_total_supir, SUM(qty) AS total_qty FROM v_rekap_non_do WHERE id_vendor = '$id_vendor' GROUP BY id_vendor")->row();
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('Rajawali System')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Kwitansi")
            ->setSubject("Kwitansi")
            ->setDescription("Kwitansi")
            ->setKeywords("Kwitansi");
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DDDDDD')
            )
        );

        $excel->getActiveSheet()->getStyle('O3')->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ffe100')
                )
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $style_center = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            )
        );
        $style_border = array(
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "KWITANSI");
        $excel->setActiveSheetIndex(0)->setCellValue('A2', "CV RAJA WALI SAMPIT");
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "Untuk Pembayaran");
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "GROUP");
        $excel->setActiveSheetIndex(0)->setCellValue('G4', $detail_kwitansi->vendor);
        $excel->setActiveSheetIndex(0)->setCellValue('F5', "NO HP");
        $excel->setActiveSheetIndex(0)->setCellValue('G5', $detail_kwitansi->no_hp);
        $excel->setActiveSheetIndex(0)->setCellValue('F6', "NO REK");
        $excel->setActiveSheetIndex(0)->setCellValue('G6', $detail_kwitansi->bank . ' ' . $detail_kwitansi->no_rekening . ' a/n ' . $detail_kwitansi->nama_rekening);
        $excel->setActiveSheetIndex(0)->setCellValue('O3', "NOMOR KWITANSI : ");

        $excel->getActiveSheet()->mergeCells('A1:Q1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A4:E4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('O3:Q3'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G6:K6'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G5:K5'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('G4:K4'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('A2:Q2'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(true); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A8', "NO");
        $excel->setActiveSheetIndex(0)->setCellValue('B8', "TGL");
        $excel->setActiveSheetIndex(0)->setCellValue('C8', "QTY AWAL");
        $excel->setActiveSheetIndex(0)->setCellValue('D8', "QTY AKHIR");
        $excel->setActiveSheetIndex(0)->setCellValue('E8', "SUPIR");
        $excel->setActiveSheetIndex(0)->setCellValue('F8', "NOPOL");
        $excel->setActiveSheetIndex(0)->setCellValue('G8', "ANGKUT");
        $excel->setActiveSheetIndex(0)->setCellValue('H8', "TUJUAN");
        $excel->setActiveSheetIndex(0)->setCellValue('I8', "M");
        $excel->setActiveSheetIndex(0)->setCellValue('J8', "C");
        $excel->setActiveSheetIndex(0)->setCellValue('K8', "HARGA");
        $excel->setActiveSheetIndex(0)->setCellValue('L8', "TOTAL");
        $excel->setActiveSheetIndex(0)->setCellValue('M8', "CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('N8', "TTL CLAIM");
        $excel->setActiveSheetIndex(0)->setCellValue('O8', "Pph %");
        $excel->setActiveSheetIndex(0)->setCellValue('P8', "ADM");
        $excel->setActiveSheetIndex(0)->setCellValue('Q8', "SANGO");
        $excel->setActiveSheetIndex(0)->setCellValue('R8', "GRAND TOTAL");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('P8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('Q8')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('R8')->applyFromArray($style_col);

        $kwitansi = $this->rms_model->get("v_rekap_non_do", "WHERE id_vendor = '$id_vendor'")->result();


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 9;
        $numrow2 = 10; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($kwitansi as $data) { // Lakukan looping pada variabel siswa

            if ($data->jenis_pajak == 'skb') {
                $pph = '0.5%';
                $jenis_pajak = "SKB";
            } elseif ($data->jenis_pajak == 'ktp') {
                $pph = '4%';
                $jenis_pajak = "KTP";
            } elseif ($data->jenis_pajak == 'npwp') {
                $pph = '2%';
                $jenis_pajak = "NPWP";
            }

            $old_date = $data->tanggal_input;
            $old_date_timestamp = strtotime($old_date);

            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo(date('Y-m-d', $old_date_timestamp)));
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->qty);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->qty);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nama_supir);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->nopol);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->komoditas);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->kode_tujuan);
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 'Rp ' . number_format($data->harga_supir, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, 'Rp ' . number_format($data->total_harga_supir, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '-');
            $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, 'Rp ' . number_format($data->uang_sangu, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, 'Rp ' . number_format($data->potongan, 0, "", "."));
            $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, 'Rp ' . number_format($data->total_supir, 0, "", "."));
            //$excel->setActiveSheetIndex(0)->insertNewRowBefore(2,1); 

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
            $numrow2 = $numrow2 + 2;
        }

        $sebesar = $numrow + 3;
        $ttd = $numrow + 4;
        $ttd_bottom = $ttd + 3;
        $ttd_periksa = $ttd_bottom + 1;


        $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, 'Total Qty');
        $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $detail_kwitansi->total_qty);
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $detail_kwitansi->total_qty);
        $excel->getActiveSheet()->getStyle('A' . $numrow . ':' . 'Q' . $numrow)->applyFromArray($style_row);





        $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, 'Total');
        $excel->setActiveSheetIndex(0)->setCellValue('R' . $numrow, 'Rp ' . number_format($detail_kwitansi->grand_total_supir, 0, "", "."));
        $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('R' . $numrow)->applyFromArray($style_row);

        $excel->setActiveSheetIndex(0)->setCellValue('A' . $sebesar, 'Sebesar');
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $sebesar, 'Rp ' . number_format($detail_kwitansi->grand_total_supir, 0, "", "."));


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $sebesar, 'Sampit, ' . shortdate_indo(date('Y-m-d')));
        $excel->getActiveSheet()->mergeCells('G' . $sebesar . ':' . 'O' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $sebesar . ':' . 'H' . $sebesar)->applyFromArray($style_center);

        $excel->getActiveSheet()->mergeCells('A' . $sebesar . ':' . 'B' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->mergeCells('D' . $sebesar . ':' . 'E' . $sebesar); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('D' . $sebesar)->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('D' . $sebesar)->getFont()->setSize(16); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('D' . $sebesar)->getFont()->setItalic(TRUE); // Set bold kolom A1


        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd, 'Direkap oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('G' . $ttd_periksa, 'SAURINA');
        $excel->getActiveSheet()->mergeCells('G' . $ttd . ':' . 'i' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd . ':' . 'i' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('G' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('G' . $ttd_periksa . ':' . 'i' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd, 'Diperiksa oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('J' . $ttd_periksa, 'ANISA');
        $excel->getActiveSheet()->mergeCells('J' . $ttd . ':' . 'L' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd . ':' . 'L' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('J' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('J' . $ttd_periksa . ':' . 'L' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd, 'Diterima oleh');
        $excel->setActiveSheetIndex(0)->setCellValue('M' . $ttd_periksa, $detail_kwitansi->vendor);
        $excel->getActiveSheet()->mergeCells('M' . $ttd . ':' . 'O' . $ttd_bottom); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd . ':' . 'O' . $ttd_periksa)->applyFromArray($style_border);
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        $excel->getActiveSheet()->getStyle('M' . $ttd_periksa)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM); // Set text center untuk kolom A1
        $excel->getActiveSheet()->mergeCells('M' . $ttd_periksa . ':' . 'O' . $ttd_periksa); // Set Merge Cell pada kolom A1 sampai E1


        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(3); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(5); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('R')->setWidth(15); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Siswa");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="kwitansi_' . $detail_kwitansi->vendor . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }



    public function get_invoice()
    {
        $id = $this->input->POST('id');
        $data = $this->rms_model->get("v_invoice", "WHERE id_invoice = $id");
        $detail = $data->result();
        echo json_encode($detail);
    }

    function generate_kwitansi()
    {
        $data['kwitansi'] = $this->rms_model->get("v_rekap", "WHERE status = '0'")->result();
        $data['content'] = 'rms/kwitansi/generate';
        $this->load->view('rms/includes/template', $data);
    }

    function save_generate_kwitansi()
    {
        $id_rekap = $this->input->POST('id_rekap_invoice');
        $no_kwitansi = $this->input->POST('no_invoice');


        $projectArray = explode(',', $id_rekap);

        //var_dump($projectArray); exit;
        $data = array(
            'no_kwitansi' => $no_kwitansi,
            'status' => '0',
        );

        $save_invoice = $this->rms_model->insert_id("tbl_kwitansi", $data);
        for ($i = 0; $i < count($projectArray); $i++) {

            $item = array('no_kwitansi' => $no_kwitansi, 'id_rekap' => $projectArray[$i], 'id_kwitansi' => $save_invoice);
            $this->rms_model->insert("tbl_generate_kwitansi", $item);
        }
        if ($save_invoice) {

            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }


    function generate_invoice()
    {
        $data['invoice'] = $this->rms_model->get("v_project", "WHERE total_terkirim >= qty")->result();
        $data['content'] = 'rms/invoice/generate';
        $this->load->view('rms/includes/template', $data);
    }

    function save_generate_invoice()
    {
        $id_project = $this->input->POST('id_project_invoice');
        $no_invoice = $this->input->POST('no_invoice');
        $remark = $this->input->POST('remark');
        $tanggal_invoice = $this->input->POST('tanggal_invoice');
        $pph = $this->input->POST('pph');
        $ppn = $this->input->POST('ppn');

        $projectArray = explode(',', $id_project);
        $data_project = array(
            'status' => '2',
        );

        $data = array(
            'no_invoice' => $no_invoice,
            'remark' => $remark,
            'tanggal_invoice' => $tanggal_invoice,
            'ppn' => $ppn,
            'pph' => $pph,
            'status' => '0',
        );

        $save_invoice = $this->rms_model->insert_id("tbl_invoice", $data);
        for ($i = 0; $i < count($projectArray); $i++) {

            $item = array('no_invoice' => $no_invoice, 'id_project' => $projectArray[$i], 'id_invoice' => $save_invoice);
            $this->rms_model->insert("tbl_generate_invoice", $item);
            $this->rms_model->update("tbl_project", $data_project, $projectArray[$i]);
        }
        if ($save_invoice) {

            echo json_encode(array(
                "status" => TRUE,
                "target" => TRUE
            ));
        }
    }

    function invoice()
    {
        $data['invoice'] = $this->rms_model->get("v_invoice")->result();
        $data['content'] = 'rms/invoice/index';
        $this->load->view('rms/includes/template', $data);
    }


    function cetak_invoice($id)
    {

        $data['invoice'] = $this->rms_model->get("v_invoice", "WHERE id_invoice = '$id'")->row();
        $no_invoice = $data['invoice']->no_invoice;
        $data['project'] = $this->rms_model->get("v_generate_invoice", "WHERE no_invoice = '$no_invoice'")->result();

        $this->load->library('pdf');
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $cetak_no = str_replace('/', '-', $no_invoice);
        $html = $this->load->view('rms/invoice/pdf', $data, true);
        $filename = "INVOICE(" . $cetak_no . ").pdf";
        $this->pdf->createPDF($html, $filename, true);
    }


    function view_invoice($id)
    {
        $data['pembayaran_invoice'] = $this->rms_model->get("tbl_pembayaran_invoice a", "LEFT JOIN tbl_invoice b ON a.id_invoice = b.id WHERE a.id_invoice = '$id'")->result();
        $data['invoice'] = $this->rms_model->get("v_invoice", "WHERE id_invoice = '$id'")->row();
        $data['content'] = 'rms/invoice/view';
        $this->load->view('rms/includes/template', $data);
    }



    public function download_replas($id_project)
    {
        $data_replas = $this->rms_model->get_by_query("SELECT * FROM v_rekap WHERE id_project = '$id_project'")->result();
        $data_project = $this->rms_model->get_by_query("SELECT * FROM v_project WHERE id_project = '$id_project'")->row();
        //var_dump($data_project); exit;
        // Load plugin PHPExcel nya
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('My Notes Code')
            ->setTitle("Data Siswa")
            ->setSubject("Siswa")
            ->setDescription("Laporan Semua Data Siswa")
            ->setKeywords("Data Siswa");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'DDDDDD')
            )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $style_col_yellow = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffe100')
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
            )
        );

        $style_col_center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP $data_project->komoditas $data_project->nama_perusahaan");
        $excel->getActiveSheet()->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(true); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
        $excel->getActiveSheet()->mergeCells('A3:A4');
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);

        $excel->setActiveSheetIndex(0)->setCellValue('B3', "TGL MUAT");
        $excel->getActiveSheet()->mergeCells('B3:B4');
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);

        if ($data_project->id_klien == '8' || $data_project->id_klien == '9' || $data_project->id_klien == '16') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "NO KONTRAK");
            $excel->getActiveSheet()->mergeCells('C3:C4');
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('D3', "NO TIKET");
            $excel->getActiveSheet()->mergeCells('D3:D4');
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        } elseif ($data_project->id_komoditas != '3' and $data_project->id_klien != '6') {
            $excel->setActiveSheetIndex(0)->setCellValue('C3', "NO DO");
            $excel->getActiveSheet()->mergeCells('C3:C4');
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('D3', "NO STO");
            $excel->getActiveSheet()->mergeCells('D3:D4');
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        }

        if ($data_project->id_komoditas == '3' and $data_project->id_klien == '6') {

            $excel->setActiveSheetIndex(0)->setCellValue('C3', "SUPIR");
            $excel->getActiveSheet()->mergeCells('C3:C4');
            $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('D3', "NOPOL");
            $excel->getActiveSheet()->mergeCells('D3:D4');
            $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('E3', "QTY AWAL");
            if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                $excel->setActiveSheetIndex(0)->setCellValue('H3', "QTY AKHIR");
                $excel->getActiveSheet()->mergeCells('E3:G3');
                $excel->getActiveSheet()->mergeCells('H3:J3');
                $excel->setActiveSheetIndex(0)->setCellValue('E4', "BRUTO");
                $excel->setActiveSheetIndex(0)->setCellValue('F4', "TARRA");
                $excel->setActiveSheetIndex(0)->setCellValue('G4', "NETTO");
                $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('H4', "BRUTO");
                $excel->setActiveSheetIndex(0)->setCellValue('I4', "TARRA");
                $excel->setActiveSheetIndex(0)->setCellValue('J4', "NETTO");
                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('K3', "SUSUT");
                $excel->getActiveSheet()->mergeCells('K3:K4');
                $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);

                if ($data_project->id_komoditas == '3') {
                    $excel->setActiveSheetIndex(0)->setCellValue('L3', "NILAI TERENDAH");
                    $excel->getActiveSheet()->mergeCells('L3:L4');
                    $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('M3', "OA/KG");
                    $excel->getActiveSheet()->mergeCells('M3:M4');
                    $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('N3', "BIAYA ANGKUT");
                    $excel->getActiveSheet()->mergeCells('N3:N4');
                    $excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('N4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('O3', "CLAIM");
                    $excel->getActiveSheet()->mergeCells('O3:O4');
                    $excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('O4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('P3', "TOTAL CLAIM");
                    $excel->getActiveSheet()->mergeCells('P3:P4');
                    $excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('P4')->applyFromArray($style_col);

                    $excel->setActiveSheetIndex(0)->setCellValue('Q3', "TOTAL");
                    $excel->getActiveSheet()->mergeCells('Q3:Q4');
                    $excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
                    $excel->getActiveSheet()->getStyle('Q4')->applyFromArray($style_col);
                }
            } else {
                $excel->getActiveSheet()->mergeCells('G3:H3');
                $excel->setActiveSheetIndex(0)->setCellValue('G4', "BAG");
                $excel->setActiveSheetIndex(0)->setCellValue('H4', "KG");
                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
                $excel->setActiveSheetIndex(0)->setCellValue('I3', "QTY AKHIR");
                $excel->getActiveSheet()->mergeCells('I3:J3');
                $excel->setActiveSheetIndex(0)->setCellValue('I4', "BAG");
                $excel->setActiveSheetIndex(0)->setCellValue('J4', "KG");
                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('K3', "SUSUT");
                $excel->getActiveSheet()->mergeCells('K3:K4');
                $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
            }
        } else {
            $excel->setActiveSheetIndex(0)->setCellValue('E3', "SUPIR");
            $excel->getActiveSheet()->mergeCells('E3:E4');
            $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('F3', "NOPOL");
            $excel->getActiveSheet()->mergeCells('F3:F4');
            $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
            $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);

            $excel->setActiveSheetIndex(0)->setCellValue('G3', "QTY AWAL");
            if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                $excel->setActiveSheetIndex(0)->setCellValue('J3', "QTY AKHIR");
                $excel->getActiveSheet()->mergeCells('G3:I3');
                $excel->getActiveSheet()->mergeCells('J3:L3');
                $excel->setActiveSheetIndex(0)->setCellValue('G4', "BRUTO");
                $excel->setActiveSheetIndex(0)->setCellValue('H4', "TARRA");
                $excel->setActiveSheetIndex(0)->setCellValue('I4', "NETTO");
                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('J4', "BRUTO");
                $excel->setActiveSheetIndex(0)->setCellValue('K4', "TARRA");
                $excel->setActiveSheetIndex(0)->setCellValue('L4', "NETTO");
                $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('L4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('M3', "SUSUT");
                $excel->getActiveSheet()->mergeCells('M3:M4');
                $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('M4')->applyFromArray($style_col);
            } else {
                $excel->getActiveSheet()->mergeCells('G3:H3');
                $excel->setActiveSheetIndex(0)->setCellValue('G4', "BAG");
                $excel->setActiveSheetIndex(0)->setCellValue('H4', "KG");
                $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
                $excel->setActiveSheetIndex(0)->setCellValue('I3', "QTY AKHIR");
                $excel->getActiveSheet()->mergeCells('I3:J3');
                $excel->setActiveSheetIndex(0)->setCellValue('I4', "BAG");
                $excel->setActiveSheetIndex(0)->setCellValue('J4', "KG");
                $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('I4')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('J4')->applyFromArray($style_col);

                $excel->setActiveSheetIndex(0)->setCellValue('K3', "SUSUT");
                $excel->getActiveSheet()->mergeCells('K3:K4');
                $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
                $excel->getActiveSheet()->getStyle('K4')->applyFromArray($style_col);
            }
        }


        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data_replas as $data) { // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, mediumdate_indo($data->tanggal_muat));
            if ($data_project->id_klien == '8' || $data_project->id_klien == '9' || $data_project->id_klien == '16') {
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->no_kontrak);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->no_tiket);
            } elseif ($data_project->id_komoditas != '3' and $data_project->id_klien != '6') {
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->no_do);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->no_sto);
            }

            if ($data_project->id_komoditas == '3' and $data_project->id_klien == '6') {
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->nama_supir);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->nopol);
                if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->bruto_awal);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->tarra_awal);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->timbang_kebun_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->bruto_akhir);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->tarra_akhir);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->qty_kirim_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->m_susut);
                    if ($data_project->id_komoditas == '3') {
                        $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->qty_terendah);
                        $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->harga_unit);
                        $excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $data->harga_qty_terendah);
                        if ($data->total_claim_invoice == NULL || $data->total_claim_invoice == "" ||  $data->total_claim_invoice == '0') {
                            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, '0');
                        } else {
                            $excel->setActiveSheetIndex(0)->setCellValue('O' . $numrow, $data->claim_invoice);
                        }
                        $excel->setActiveSheetIndex(0)->setCellValue('P' . $numrow, $data->total_claim_invoice);
                        $excel->setActiveSheetIndex(0)->setCellValue('Q' . $numrow, $data->total_invoice);
                    }
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->timbang_kebun_bag);
                    $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->timbang_kebun_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->qty_kirim_bag);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->qty_kirim_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->m_susut);
                }
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->nama_supir);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data->nopol);
                if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->bruto_awal);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->tarra_awal);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->timbang_kebun_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->bruto_akhir);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->tarra_akhir);
                    $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data->qty_kirim_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data->m_susut);
                } else {
                    $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data->timbang_kebun_bag);
                    $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data->timbang_kebun_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data->qty_kirim_bag);
                    $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data->qty_kirim_kg);
                    $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data->m_susut);
                }
            }

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);

            if ($data_project->id_komoditas == '3' and $data_project->id_klien == '6') {
                $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('N' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('O' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('P' . $numrow)->applyFromArray($style_row);
                $excel->getActiveSheet()->getStyle('Q' . $numrow)->applyFromArray($style_row);
            }

            if ($data_project->id_komoditas != '3' and $data_project->id_klien != '6') {
                if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {
                    $excel->getActiveSheet()->getStyle('L' . $numrow)->applyFromArray($style_row);
                    $excel->getActiveSheet()->getStyle('M' . $numrow)->applyFromArray($style_row);
                }
            }

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }




        if ($data_project->id_komoditas != '3' and $data_project->id_klien != '6') {
            if ($data_project->id_komoditas == '2') {

                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, 'Total');
                $excel->getActiveSheet()->getStyle('A' . $numrow . ':M' . $numrow)->applyFromArray($style_col_yellow);
                $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_bruto_awal);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_tarra_awal);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_awal);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_bruto_akhir);
                $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data_project->total_tarra_akhir);
                $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data_project->total_qty_akhir);
                $excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $data_project->total_susut);
            } else {
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, 'Total');
                $excel->getActiveSheet()->getStyle('A' . $numrow . ':K' . $numrow)->applyFromArray($style_col_yellow);
                $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
                $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_qty_awal_bag);
                $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_qty_awal);
                $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_akhir_bag);
                $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_qty_akhir);
            }
        }

        // if ($data_project->id_komoditas == '3' and $data_project->id_klien == '6') {
        //     $excel->getActiveSheet()->mergeCells('A' . $numrow . ':D' . $numrow);

        //     if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {

        //         $excel->getActiveSheet()->getStyle('A' . $numrow . ':K' . $numrow)->applyFromArray($style_col_yellow);
        //         $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
        //         $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data_project->total_bruto_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $data_project->total_tarra_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_qty_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_bruto_akhir);
        //         $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_tarra_akhir);
        //         $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_qty_akhir);
        //     } else {
        //         $excel->getActiveSheet()->getStyle('A' . $numrow . ':K' . $numrow)->applyFromArray($style_col_yellow);
        //         $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
        //         $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_qty_awal_bag);
        //         $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_qty_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_akhir_bag);
        //         $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_qty_akhir);
        //     }
        // } else {
        //     $excel->getActiveSheet()->mergeCells('A' . $numrow . ':F' . $numrow);

        //     if ($data_project->id_komoditas == '2' || ($data_project->id_komoditas == '3' and $data_project->id_klien == '6')) {

        //         $excel->getActiveSheet()->getStyle('A' . $numrow . ':M' . $numrow)->applyFromArray($style_col_yellow);
        //         $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
        //         $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_bruto_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_tarra_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_bruto_akhir);
        //         $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $data_project->total_tarra_akhir);
        //         $excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $data_project->total_qty_akhir);
        //     } else {
        //         $excel->getActiveSheet()->getStyle('A' . $numrow . ':K' . $numrow)->applyFromArray($style_col_yellow);
        //         $excel->getActiveSheet()->getStyle('A' . $numrow, 'Total')->applyFromArray($style_col_center);
        //         $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $data_project->total_qty_awal_bag);
        //         $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $data_project->total_qty_awal);
        //         $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $data_project->total_qty_akhir_bag);
        //         $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $data_project->total_qty_akhir);
        //     }
        // }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("REKAP $data_project->komoditas");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="REKAP ' . $data_project->komoditas . ' ' . $data_project->nama_perusahaan . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
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
