<?php
namespace App\Controllers;

use App\Models\PaketModel;
use App\Models\PesananModel;
use mysqli;

class PesananController extends BaseController
{
    private PaketModel $paketModel;
    private PesananModel $pesananModel;

    public function __construct(mysqli $db)
    {
        parent::__construct($db);
        $this->paketModel = new PaketModel($db);
        $this->pesananModel = new PesananModel($db);
    }

    public function create(): void
    {
        $paketId = (int) ($_GET['paket_id'] ?? 0);
        $paket = $paketId > 0 ? $this->paketModel->find($paketId) : null;

        $errors = $_SESSION['form_errors'] ?? [];
        $old = $_SESSION['form_old'] ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_old']);

        $this->render('pesanan/create', [
            'paket' => $paket,
            'paket_id' => $paketId,
            'errors' => $errors,
            'old' => $old,
            'harga_per_hari' => (int) ($paket['harga_per_hari'] ?? 0),
            'pageTitle' => 'Pemesanan Paket Wisata',
            'activeNav' => 'pemesanan',
        ]);
    }

    public function store(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('pesanan/create');
        }

        $input = $_POST;
        $validation = $this->validateInput($input, true);
        if (!empty($validation['errors'])) {
            $_SESSION['form_errors'] = $validation['errors'];
            $_SESSION['form_old'] = $input;
            $this->redirect('pesanan/create', ['paket_id' => $validation['paket_id']]);
        }

        $insertId = $this->pesananModel->create($validation['payload']);
        if ($insertId) {
            $_SESSION['flash_success'] = 'Pesanan berhasil disimpan.';
            $this->redirect('pesanan/success', ['id' => $insertId]);
        }

        $_SESSION['form_errors'] = ['Gagal menyimpan pesanan. Silakan coba lagi.'];
        $_SESSION['form_old'] = $input;
        $this->redirect('pesanan/create', ['paket_id' => $validation['paket_id']]);
    }

    public function manage(): void
    {
        $flash = $_SESSION['flash_success'] ?? null;
        unset($_SESSION['flash_success']);

        $this->render('pesanan/manage', [
            'pesanan_list' => $this->pesananModel->all(),
            'flash_success' => $flash,
            'pageTitle' => 'Kelola Pesanan',
            'activeNav' => 'kelola',
        ]);
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_success'] = 'Data pesanan tidak ditemukan.';
            $this->redirect('pesanan/manage');
        }

        $pesanan = $this->pesananModel->find($id);
        if (!$pesanan) {
            $_SESSION['flash_success'] = 'Data pesanan tidak ditemukan.';
            $this->redirect('pesanan/manage');
        }

        $errors = $_SESSION['form_errors'] ?? [];
        $old = $_SESSION['form_old'] ?? [];
        unset($_SESSION['form_errors'], $_SESSION['form_old']);

        $this->render('pesanan/edit', [
            'pesanan' => $pesanan,
            'errors' => $errors,
            'old' => $old,
            'harga_per_hari' => (int) ($pesanan['harga_paket'] ?? 0),
            'pageTitle' => 'Edit Pesanan',
            'activeNav' => 'kelola',
        ]);
    }

    public function update(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            $this->redirect('pesanan/manage');
        }

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_success'] = 'ID pesanan tidak valid.';
            $this->redirect('pesanan/manage');
        }

        $existing = $this->pesananModel->find($id);
        if (!$existing) {
            $_SESSION['flash_success'] = 'Data pesanan tidak ditemukan.';
            $this->redirect('pesanan/manage');
        }

        $validation = $this->validateInput($_POST, false, $existing);
        if (!empty($validation['errors'])) {
            $_SESSION['form_errors'] = $validation['errors'];
            $_SESSION['form_old'] = $_POST;
            $this->redirect('pesanan/edit', ['id' => $id]);
        }

        if ($this->pesananModel->update($id, $validation['payload'])) {
            $_SESSION['flash_success'] = 'Pesanan berhasil diperbarui.';
            $this->redirect('pesanan/manage');
        }

        $_SESSION['form_errors'] = ['Gagal memperbarui pesanan. Silakan coba lagi.'];
        $_SESSION['form_old'] = $_POST;
        $this->redirect('pesanan/edit', ['id' => $id]);
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->pesananModel->delete($id);
            $_SESSION['flash_success'] = 'Pesanan berhasil dihapus.';
        }
        $this->redirect('pesanan/manage');
    }

    public function success(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $pesanan = $id > 0 ? $this->pesananModel->find($id) : null;
        $flash = $_SESSION['flash_success'] ?? null;
        unset($_SESSION['flash_success']);

        $this->render('pesanan/sukses', [
            'pesanan' => $pesanan,
            'flash_success' => $flash,
            'pageTitle' => 'Pemesanan Berhasil',
            'activeNav' => 'pemesanan',
        ]);
    }

    private function validateInput(array $input, bool $isCreate, ?array $existing = null): array
    {
        $errors = [];
        $paketId = $isCreate ? (int) ($input['paket_id'] ?? 0) : (int) ($existing['paket_id'] ?? 0);

        $paket = $paketId > 0 ? $this->paketModel->find($paketId) : null;
        if ($paketId <= 0 || !$paket) {
            $errors[] = 'Paket wisata tidak valid.';
        }
        $hargaPerHari = (int) ($paket['harga_per_hari'] ?? 0);
        if ($hargaPerHari <= 0) {
            $errors[] = 'Harga paket tidak valid.';
        }

        $nama = trim($input['nama_pemesan'] ?? '');
        $noHp = trim($input['no_hp'] ?? '');
        $tanggal = trim($input['tanggal_pesan'] ?? '');
        $lama = isset($input['lama_perjalanan']) ? (int) $input['lama_perjalanan'] : 0;
        $peserta = isset($input['jumlah_peserta']) ? (int) $input['jumlah_peserta'] : 0;
        if ($nama === '') {
            $errors[] = 'Nama pemesan wajib diisi.';
        }
        if ($noHp === '') {
            $errors[] = 'Nomor HP/Telp wajib diisi.';
        }
        if ($tanggal === '') {
            $errors[] = 'Tanggal pesan wajib diisi.';
        }
        if ($lama <= 0) {
            $errors[] = 'Waktu pelaksanaan harus lebih dari 0 hari.';
        }
        if ($peserta <= 0) {
            $errors[] = 'Jumlah peserta harus lebih dari 0.';
        }

        $jumlahTagihan = $hargaPerHari * $lama * $peserta;

        $payload = [
            'paket_id' => $paketId,
            'nama_pemesan' => $nama,
            'no_hp' => $noHp,
            'tanggal_pesan' => $tanggal,
            'lama_perjalanan' => $lama,
            'jumlah_peserta' => $peserta,
            'harga_paket' => $hargaPerHari,
            'jumlah_tagihan' => $jumlahTagihan,
        ];

        return [
            'errors' => $errors,
            'payload' => $payload,
            'paket_id' => $paketId,
        ];
    }
}
