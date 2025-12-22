<?php
namespace App\Models;

use mysqli;

class PesananModel
{
    public function __construct(private mysqli $db)
    {
    }

    public function all(): array
    {
        $pesanan = [];
        $sql = 'SELECT pesanan.*, paket_wisata.nama_paket FROM pesanan JOIN paket_wisata ON pesanan.paket_id = paket_wisata.id ORDER BY pesanan.id DESC';
        $result = $this->db->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $pesanan[] = $row;
            }
            $result->free();
        }
        return $pesanan;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT pesanan.*, paket_wisata.nama_paket FROM pesanan JOIN paket_wisata ON pesanan.paket_id = paket_wisata.id WHERE pesanan.id = ?');
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

    public function create(array $data): ?int
    {
        $stmt = $this->db->prepare('INSERT INTO pesanan (paket_id, nama_pemesan, no_hp, tanggal_pesan, lama_perjalanan, jumlah_peserta, harga_paket, jumlah_tagihan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        if (!$stmt) {
            return null;
        }
        $stmt->bind_param(
            'isssiiii',
            $data['paket_id'],
            $data['nama_pemesan'],
            $data['no_hp'],
            $data['tanggal_pesan'],
            $data['lama_perjalanan'],
            $data['jumlah_peserta'],
            $data['harga_paket'],
            $data['jumlah_tagihan']
        );
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $insertId = $stmt->insert_id;
            $stmt->close();
            return $insertId;
        }
        $stmt->close();
        return null;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE pesanan SET nama_pemesan = ?, no_hp = ?, tanggal_pesan = ?, lama_perjalanan = ?, jumlah_peserta = ?, harga_paket = ?, jumlah_tagihan = ? WHERE id = ?');
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param(
            'sssiiiii',
            $data['nama_pemesan'],
            $data['no_hp'],
            $data['tanggal_pesan'],
            $data['lama_perjalanan'],
            $data['jumlah_peserta'],
            $data['harga_paket'],
            $data['jumlah_tagihan'],
            $id
        );
        $stmt->execute();
        $success = $stmt->affected_rows >= 0;
        $stmt->close();
        return $success;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM pesanan WHERE id = ?');
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        return $success;
    }
}
