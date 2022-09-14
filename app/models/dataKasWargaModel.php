<?php

use App\Core\Database;
use App\Core\Flash;
use App\Core\Controller;

class dataKasWargaModel extends Database
{
    public function getInfo()
    {
        $query = $this->connect->query("SELECT `warga`.`nama`,`kas`.`tanggal`,`kas`.`jumlah`,`kas`.`status` FROM kas,warga,users WHERE kas.users_id=users.id AND users.NIK=warga.NIK ");
        return $query;
    }
    public function tambah($post)
    {
        $username = htmlspecialchars($post['username']);
        $tanggal = date('Y-m-d');
        $status = htmlspecialchars($post['status']);
        if (empty($username) || empty($tanggal) || empty($status)) {
            Flash::setFlash('Data wajin diisi lengkap', 'danger');
        } else {
            $username = $this->connect->query("SELECT * FROM `users` WHERE `username` = '$username'");
            if ($username->num_rows > 0) {
                $username = $username->fetch_assoc();
                $username = $username['username'];
                $query = $this->connect->query("INSERT INTO `kas` (`users_id`, `tanggal`, `jumlah`, `status`) VALUES ('$username', '$tanggal', '5000', '$status');");
                if ($query) {
                    Flash::setFlash('Data kas berhasil ditambahkan', 'success');
                } else {
                    Flash::setFlash('Data kas gagal ditambahkan', 'danger');
                }
            } else {
                Flash::setFlash('Username tidak ditemukan', 'danger');
            }
        }
        Controller::redirect(BASE_URL . 'dataKasWarga/tambah');
    }
}