<?php
// $koneksi = mysqli_connect("localhost","root","root","billing-internet");
$koneksi = mysqli_connect("localhost","mikrotik","mikrotik","mikrotik");

// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
