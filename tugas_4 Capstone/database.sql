CREATE TABLE IF NOT EXISTS paket_wisata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_paket VARCHAR(150) NOT NULL,
    deskripsi TEXT NOT NULL,
    gambar_url VARCHAR(255) NOT NULL,
    video_url VARCHAR(255) NOT NULL,
    harga_per_hari INT NOT NULL
);

CREATE TABLE IF NOT EXISTS pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paket_id INT NOT NULL,
    nama_pemesan VARCHAR(150) NOT NULL,
    no_hp VARCHAR(30) NOT NULL,
    tanggal_pesan DATE NOT NULL,
    lama_perjalanan INT NOT NULL,
    jumlah_peserta INT NOT NULL,
    harga_paket INT NOT NULL,
    jumlah_tagihan INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pesanan_paket FOREIGN KEY (paket_id) REFERENCES paket_wisata(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

INSERT INTO paket_wisata (nama_paket, deskripsi, gambar_url, video_url, harga_per_hari) VALUES
('Curug Cipeuteuy',
 'Di bawah Gunung Ceremai, air terjun ini mengaliri kolam yang terletak di taman yang dikelilingi hutan pinus.',
 'public/assets/cipeuteuy.jpg',
 'https://youtu.be/53t7OQ3KM4s?si=bbdSCztgSG4c3ell',
 1500000),
('Jembar Waterpark Majalengka',
 'Taman air unik dengan seluncur berkelok, kolam renang luas, dan patung dinosaurus besar yang berwarna-warni.',
 'public/assets/jembar.jpg',
 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
 1650000),
('Terasering Panyaweuyan',
 'Pos pengamatan puncak bukit yang menghadap sawah terasering, bukit berhutan, dan Gunung Berapi Ceremai.',
 'public/assets/panyaweuyan.jpg',
 'https://www.youtube.com/watch?v=jfKfPfyJRdk',
 1400000);
