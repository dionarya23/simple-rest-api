<?php

include "koneksi.php";
header('Content-Type: application/json');
$request = $_SERVER['REQUEST_METHOD'];

switch ($request) {
  case 'GET':

  if(isset($_GET['nim'])){
    $nim = $_GET['nim'];
    $sql = "SELECT * FROM mahasiswa WHERE NIM=$nim";
  }else if(isset($_GET['nama'])){
    $nama = $_GET['nama'];
    $sql  = "SELECT * FROM mahasiswa WHERE Nama='$nama'";
  }else{
    $sql = "SELECT * FROM mahasiswa";
  }

  $result = $conn->query($sql);

  $items = array();

  while($data = $result->fetch_array()){
    $items[] = array(
      "NIM" => $data['NIM'],
      "Nama" => $data['Nama']
    );
  }

  $json = array(
    "statusCode" => 200,
    "items"      => $items
  );

  echo json_encode($json, JSON_PRETTY_PRINT);
    break;

    case "POST":

    if(isset($_POST['nim']) && isset($_POST['nama'])){
      $nim  = $_POST['nim'];
      $nama = $_POST['nama'];

      $sql    = "INSERT INTO mahasiswa(nim, nama) VALUES($nim, '$nama')";
          if($conn->query($sql) == TRUE){
            $sql = "SELECT * FROM mahasiswa WHERE nim=$nim";

            $hasil = $conn->query($sql);
            $item = array();
            while($data = $hasil->fetch_array()) {
                $item[] = array(
                    'nim' => $data['NIM'],
                    'nama' => $data['Nama']
                );
            }
            $json = array(
                'statusCode' => 200,
                'message' => "Berhasil Tambah Data",
                'items' => $item
            );
          }else{
            $json = array(
                'statusCode' => 400,
                'message' => "Gagal Tambah Data"
            );
          }
    }

    echo json_encode($json, JSON_PRETTY_PRINT);
    break;

    case 'PUT':
    $_PUT = array();
    parse_str(file_get_contents('php://input'), $_PUT);

    if(isset($_PUT['nim']) && isset($_PUT['nama'])){
        $nim   = $_PUT['nim'];
        $nama  = $_PUT['nama'];

        $sql   = "UPDATE mahasiswa SET Nama='$nama' WHERE Nim='$nim'";
        $query = $conn->query($sql);

        if($query->num_rows > 0){
            $sql = "SELECT * FROM mahasiswa WHERE nim = $nim";
            $query = $conn->query($sql);

            $item = array();
            while($data = $query->fetch_array()) {
                $item[] = array(
                    'nim' => $data['NIM'],
                    'nama' => $data['Nama']
                );
            }
            $json = array(
                'statusCode' => 200,
                'message' => "Berhasil Update Data",
                'items' => $item
            );
        } else{
            $json = array(
                'statusCode' => 400,
                'message' => "Gagal Update Data"
            );
        }
    }

    echo json_encode($json, JSON_PRETTY_PRINT);

    break;

    case "DELETE":
    $_DELETE = array();
    parse_str(file_get_contents('php://input'), $_DELETE);
      if(isset($_DELETE['nim'])){
          $nim = $_DELETE['nim'];

          $sql = "DELETE FROM mahasiswa WHERE Nim='$nim'";
          $query = $conn->query($sql);

          if($query->num_rows > 0){

              $item = array(
                  'nim' => $nim,
              );
              $json = array(
                  'statusCode' => 200,
                  'message' => "Berhasil Hapus Data",
                  'items' => $item
              );
          } else{
              $json = array(
                  'statusCode' => 400,
                  'message' => "Gagal Hapus Data"
              );
          }
      }

      echo json_encode($json, JSON_PRETTY_PRINT);
    break;

}
