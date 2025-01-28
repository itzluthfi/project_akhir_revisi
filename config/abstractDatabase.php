<?php

abstract class AbstractDatabase {
    protected $db;

    public function __construct() {
        // Inisialisasi database di abstract class
        $this->db = $this->initializeDatabase();
    }

    // Fungsi untuk menginisialisasi koneksi database
    private function initializeDatabase() {
        require_once __DIR__ . '../../config/dbConnectNew.php';
        return Databases::getInstance();
    }
}
?>