<?php
session_start();
$utf = header("conntent-Type:text/html; charset=utf-8");
$conn = new mysqli('localhost', 'root', '', 'upload');
$conn->set_charset("utf8");

// Arquivos permitidos
$arquivos_permitidos = ['pdf'];

// Capturar dados do formulário
$arquivos = $_FILES['arquivos'];

// Capturar nomes dos arquivos
$nomes = $arquivos['name'];

for ($i = 0; $i < count($nomes); $i++) :
  $extensao = explode('.', $nomes[$i]);
  $extensao = end($extensao);
  $nomes[$i] = rand() . '-' . $nomes[$i];

  // Verificar extensão dos arquivos
  if (in_array($extensao, $arquivos_permitidos)) :
    $query = $conn->query("INSERT INTO tb_arquivos VALUES (default, '$nomes[$i]')");
    if (mysqli_affected_rows($conn) > 0) :
      $mover = move_uploaded_file($_FILES['arquivos']['tmp_name'][$i], '../' . $nomes[$i]);
      $_SESSION['sucesso'] = 'Arquivos(s) enviados(s) com sucesso!';
      $destino = header("Location:../");
    endif;

  else :
    $_SESSION['erro'] = 'Existem arquivos que não foram enviados, por não obedecerem as normas de upload do sistema!';
    $destino = header("Location:../");
  endif;
endfor;
