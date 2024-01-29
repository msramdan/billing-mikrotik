<?php
$koneksi = mysqli_connect("103.127.132.33","mikrotik","mikrotik","mikrotik");

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
