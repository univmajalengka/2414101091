<?php
namespace App\Controllers;

use App\Models\PaketModel;
use mysqli;

class HomeController extends BaseController
{
    private PaketModel $paketModel;

    public function __construct(mysqli $db)
    {
        parent::__construct($db);
        $this->paketModel = new PaketModel($db);
    }

    public function index(): void
    {
        $this->render('paket/index', [
            'paket_list' => $this->paketModel->all(),
            'pageTitle' => 'Beranda - Wisata MJLK',
            'activeNav' => 'home',
        ]);
    }
}
