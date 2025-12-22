<?php
namespace App\Models;

use mysqli;

class PaketModel
{
    public function __construct(private mysqli $db)
    {
    }

    public function all(): array
    {
        $paket = [];
        $result = $this->db->query('SELECT id, nama_paket, deskripsi, gambar_url, video_url, harga_per_hari FROM paket_wisata ORDER BY id ASC');
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $paket[] = $row;
            }
            $result->free();
        }
        return $paket;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, nama_paket, deskripsi, gambar_url, video_url, harga_per_hari FROM paket_wisata WHERE id = ?');
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        return $data ?: null;
    }
}
