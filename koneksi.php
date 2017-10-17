<?php
 $host = "localhost";
 $user = "root";
 $pass = "";
 $db_name = "cl_mahasiswa";

 $conn = new mysqli($host, $user, $pass, $db_name);

 if($conn->connect_error){
   die("Tidak Bisa Konek Ke database ". $conn->connect_error);
 }
