<?php
require_once "connection.php";
   if(function_exists($_GET['function'])) {
         $_GET['function']();
      }   
   function get_karyawan()
   {
      global $connect;      
      $query = $connect->query("SELECT * FROM karyawan");            
      while($row=mysqli_fetch_object($query))
      {
         $data[] =$row;
      }
      $response=array(
                     $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }   
   
   function get_id_karyawan()
   {
      global $connect;
      if (!empty($_GET["id_karyawan"])) {
         $id_karyawan = $_GET["id_karyawan"];      
      }            
      $query ="SELECT * FROM karyawan WHERE id_karyawan= $id_karyawan";      
      $result = $connect->query($query);
      while($row = mysqli_fetch_object($result))
      {
         $data[] = $row;
      }            
      if($data)
      {
      $response = array(
                    $data
                  );               
      }else {
         $response=array(
                     'status' => 0,
                     'message' =>'No Data Found'
                  );
      }
      
      header('Content-Type: application/json');
      echo json_encode($response);
       
   }
   function insert_karyawan()
      {
         global $connect;   
         $check = array('id_karyawan' => '', 'nama' => '', 'alamat' => '', 'no_telp' => '', 'foto' => '');
         $check_match = count(array_intersect_key($_POST, $check));
         if($check_match == count($check)){
         
               $result = mysqli_query($connect, "INSERT INTO karyawan SET
               id_karyawan = '$_POST[id_karyawan]',
               nama = '$_POST[nama]',
               alamat = '$_POST[alamat]',
               no_telp = '$_POST[no_telp]',
               foto = '$_POST[foto]'");
               
               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Insert Success'
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'Insert Failed.'
                  );
               }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Wrong Parameter'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
   function update_karyawan()
      {
         global $connect;
         if (!empty($_GET["id_karyawan"])) {
         $id_karyawan = $_GET["id_karyawan"];      
      }   
         $check = array('nama' => '', 'alamat' => '', 'no_telp' => '', 'foto' => '');
         $check_match = count(array_intersect_key($_POST, $check));         
         if($check_match == count($check)){
         
              $result = mysqli_query($connect, "UPDATE karyawan SET               
               nama = '$_POST[nama]',
               alamat = '$_POST[alamat]',
               no_telp = '$_POST[no_telp]',
               foto = '$_POST[foto]' WHERE id_karyawan = $id_karyawan");
         
            if($result)
            {
               $response=array(
                  'status' => 1,
                  'message' =>'Update Success'                  
               );
            }
            else
            {
               $response=array(
                  'status' => 0,
                  'message' =>'Update Failed'                  
               );
            }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Wrong Parameter',
                     'data'=> $id_karyawan
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
   function delete_karyawan()
   {
      global $connect;
      $id_karyawan = $_GET['id_karyawan'];
      $query = "DELETE FROM karyawan WHERE id_karyawan=".$id_karyawan;
      if(mysqli_query($connect, $query))
      {
         $response=array(
            'status' => 1,
            'message' =>'Delete Success'
         );
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'Delete Fail.'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }
   function login(){
      global $connect;
      if(isset($_GET['no_telp']) && $_GET['no_telp'] != "" && isset($_GET['password']) && $_GET['password'] != "" ){
         $no_telp = $_GET['no_telp'];
         $password = $_GET['password'];

         $query = "SELECT * FROM karyawan WHERE no_telp ='".$no_telp."' and `password` = '".$password."'";
         
         $result = mysqli_query($connect, $query);
         
         $userId = "";

         while($hasilRow = mysqli_fetch_row($result)){
            $userId = $hasilRow[0];
         }
         if($result->num_rows > 0){
            $response["status"]= "true";
            $response["userId"]= $userId;
            $response["pesan"]= "Login Berhasil";
         } else{
            $response["status"] = "false";
            $response["pesan"] = "No Hp atau Password Tidak Ditemukan";

         } 
         }else{
            $response["status"] = "false";
            $response["pesan"] = "Masukan No Hp atau password";
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

   function get_gaji()
   {
      global $connect;
      if (!empty($_GET["id_karyawan"])) {
         $id_karyawan = $_GET["id_karyawan"]; 
    
      }            
      $query ="SELECT * FROM gaji WHERE id_karyawan= '$id_karyawan' ";      
      $result = $connect->query($query);
      while($row = mysqli_fetch_object($result))
      {
         $data[] = $row;
      }            
      if($data)
      {
         $response = array (
                     'status' => true,
                     'message' =>'Data Found',
                     'data'=> $data
         );             
      }else {
         $response=array(
                     'status' => false,
                     'message' =>'No Data Found'
         );
      }
      
      header('Content-Type: application/json');
      echo json_encode($response);
       
   }

   function post_login(){
      global $connect;
      $no_telp = $_POST['no_telp'];
      $password = $_POST['password'];

      $query = "SELECT * FROM karyawan WHERE no_telp ='$no_telp' and password = '$password'";

      $result = mysqli_query($connect, $query);

      if ($result->num_rows>0) {
         $row = $result->fetch_assoc();
         $response = array (
                     'status' => true,
                     'message' =>'Data Found',
                     'data'=> $row
         );             
      }else {
         $response=array(
                     'status' => false,
                     'message' =>'No Data Found'
         );
      }
   header('Content-Type: application/json');
   echo json_encode($response);
   }
 ?>