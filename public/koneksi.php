<?php
$koneksi = mysqli_connect("103.176.79.206","mikrotik","mikrotik","mikrotik");

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
