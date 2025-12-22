<!DOCTYPE html>
<html lang="id">
<head>
	<title>Formulir Pendaftaran Siswa Baru | SMK Coding</title>
</head>

<body>
	<header>
		<h3>Formulir Pendaftaran Siswa Baru</h3>
	</header>
	
	<form action="proses-pendaftaran-2.php" method="POST">
		
		<fieldset>
		
		<p>
			<label for="nama">Nama: </label>
			<input type="text" id="nama" name="nama" placeholder="nama lengkap" required />
		</p>
		<p>
			<label for="alamat">Alamat: </label>
			<textarea id="alamat" name="alamat" required></textarea>
		</p>
		<p>
			<span>Jenis Kelamin: </span>
			<label for="jk-laki"><input type="radio" id="jk-laki" name="jenis_kelamin" value="laki-laki" required> Laki-laki</label>
			<label for="jk-perempuan"><input type="radio" id="jk-perempuan" name="jenis_kelamin" value="perempuan"> Perempuan</label>
		</p>
		<p>
			<label for="agama">Agama: </label>
			<select id="agama" name="agama" required>
				<option value="" disabled selected>Pilih agama</option>
				<option value="Islam">Islam</option>
				<option value="Kristen">Kristen</option>
				<option value="Hindu">Hindu</option>
				<option value="Budha">Budha</option>
				<option value="Atheis">Atheis</option>
			</select>
		</p>
		<p>
			<label for="sekolah_asal">Sekolah Asal: </label>
			<input type="text" id="sekolah_asal" name="sekolah_asal" placeholder="nama sekolah" required />
		</p>
		<p>
			<input type="submit" value="Daftar" name="daftar" />
		</p>
		
		</fieldset>
	
	</form>
	
	</body>
</html>
