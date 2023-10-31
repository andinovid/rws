<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rms_model extends CI_Model
{

    function Get_Auth($username, $pass)
    {
        $data = $this->db->query("SELECT a.*, b.role as role_name, b.role_desc FROM tbl_users a LEFT JOIN tbl_role b ON a.role = b.id WHERE a.username = '$username' AND a.password ='$pass' AND status = '1'");
        return $data;
    }

    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function update($table, $data, $param)
    {
        $return = FALSE;
        if ($this->db->update($table, $data, "id = $param")) {
            $return = TRUE;
        }
        return $return;
    }

    function delete($tbl, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($tbl);
        return TRUE;
    }

    public function get($table, $where = NULL, $limit = NULL)
    {

        if ($where != "") {
            $where = "$where";
        } else {
            $status = "";
        }

        if ($limit != "") {
            $limit = "LIMIT $limit";
        } else {
            $limit = "";
        }
        $data = $this->db->query("SELECT * FROM $table $where $limit");
        return $data;
    }

    public function get_by_query($query)
    {
        $data = $this->db->query($query);
        return $data;
    }

    function update_priority_data($data, $parent = NULL)
    {
        $i = 1;
        foreach ($data as $d) {
            if (array_key_exists("children", $d)) {
                $this->update_priority_data($d['children'], $d['id']);
            }
            $update_array = array("position" => $i, "parent" => $parent);
            $update = $this->db->where("id", $d['id'])->update("tbl_menu", $update_array);
            $i++;
        }
        return $update;
    }

    public function insert_data($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function update_data($table, $data, $param)
    {
        $return = FALSE;
        if ($this->db->update($table, $data, "id = $param")) {
            $return = TRUE;
        }
        return $return;
    }

    function delete_data($tbl, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($tbl);
        return TRUE;
    }
    function delete_project($id)
    {
        $this->db->delete('tbl_project', array('id' => $id));
        $this->db->delete('tbl_rekap', array('id_project' => $id));
        return TRUE;
    }
    function delete_truck($id)
    {
        $this->db->delete('tbl_truck', array('id' => $id));
        $this->db->delete('tbl_pengisian_bbm', array('tbl_truck' => $id));
        return TRUE;
    }
}
