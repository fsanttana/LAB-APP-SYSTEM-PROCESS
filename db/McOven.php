<?php

$user = current_user();

// Procesamiento del formulario
if(isset($_POST['mcoven'])){
  $req_fields = array('sampleid','samplenumber','structure', 'area', 'source', 'depthfrom', 'depthto', 'materialtype', 
  'sampletype', 'north', 'east', 'elev' ,'sampledate', 'standard', 'technician','testdate');
  validate_fields($req_fields);
  if(empty($errors)){
    $sampleid  = $db->escape($_POST['sampleid']);
    $samplenumber  = $db->escape($_POST['samplenumber']);
    $structure   = $db->escape($_POST['structure']);
    $area   = $db->escape($_POST['area']);
    $source   = $db->escape($_POST['source']);
    $depthfrom  = $db->escape($_POST['depthfrom']);
    $depthto  = $db->escape($_POST['depthto']);
    $materialtype  = $db->escape($_POST['materialtype']);
    $sampletype  = $db->escape($_POST['sampletype']);
    $north  = $db->escape($_POST['north']);
    $east  = $db->escape($_POST['east']);
    $elev  = $db->escape($_POST['elev']);
    $sampledate = $db->escape($_POST['sampledate']);
    $tarename   = $db->escape($_POST['tarename']);
    $temperature   = $db->escape($_POST['temperature']);
    $tarewet   = $db->escape($_POST['tarewet']);
    $taredry   = $db->escape($_POST['taredry']);
    $water = $db->escape($_POST['water']);
    $weigthtare  = $db->escape($_POST['weigthtare']);
    $drysoil  = $db->escape($_POST['drysoil']);
    $mc = $db->escape($_POST['mc']);
    $standard  = $db->escape($_POST['standard']);
    $technician  = $db->escape($_POST['technician']);
    $testdate  = $db->escape($_POST['testdate']);
    $reportdate  = make_date();
    $testtype = "MC-Oven";
    $RegisterBy = $user['name'];

    $sql = "INSERT INTO moisture_content (";
    $sql .= "Sample_ID, Sample_Number, Structure, Area, Source, Depth_From, Depth_To, Material_Type, Sample_Type, North, East, ";
    $sql .= "Elev, Sample_Date, Tare_Name, Temperature, Tare_Plus_Wet_Soil, Tare_Plus_Dry_Soil, Water, Weigth_Tare, Dry_Soil, Mc, ";
    $sql .= "Standard, Technician, Test_Start_Date, Report_Date, test_type, Registered_By ";
    $sql .= ") VALUES (";
    $sql .= "'{$sampleid}', '{$samplenumber}', '{$structure}', '{$area}', '{$source}', '{$depthfrom}', '{$depthto}', '{$materialtype}', '{$sampletype}', ";
    $sql .= "'{$north}', '{$east}', '{$elev}', '{$sampledate}', '{$tarename}', '{$temperature}', '{$tarewet}', '{$taredry}', '{$water}', ";
    $sql .= "'{$weigthtare}', '{$drysoil}', '{$mc}', '{$standard}', '{$technician}', '{$testdate}', '{$reportdate}' , '{$testtype}', '{$RegisterBy}'";
    $sql .= ")";
    
    if($db->query($sql)){
      $session->msg('s', "Ensayo agregado exitosamente.");
      redirect('./mcoven.php', false);
    } else {
      $session->msg('d', 'Lo siento, no se pudo agregar el ensayo.');
      redirect('./mcoven.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('./mcoven.php', false);
  }
}
?>

<?php
$search_table = find_by_id('moisture_content', (int)$_GET['id']);
  // Verifica si se ha enviado el formulario
  if (isset($_POST['update_muestra'])) {
    $req_fields = array(
      'standard'
    );
    
    // Valida los campos requeridos
    validate_fields($req_fields);

    if (empty($errors)) {
      // Obtiene los valores de los campos del formulario
      $standard = remove_junk($db->escape($_POST['standard']));
      $temperature = remove_junk($db->escape($_POST['temperature']));
      $comments = remove_junk($db->escape($_POST['comments']));
      $technician = remove_junk($db->escape($_POST['technician']));
      $testdate = remove_junk($db->escape($_POST['testdate']));
  
      $tarename = remove_junk($db->escape($_POST['tarename']));
      $tarewet = remove_junk($db->escape($_POST['tarewet']));
      $taredry = remove_junk($db->escape($_POST['taredry']));
      $water = remove_junk($db->escape($_POST['water']));
      $weigthtare = remove_junk($db->escape($_POST['weigthtare']));
      $drysoil = remove_junk($db->escape($_POST['drysoil']));
      $mc = remove_junk($db->escape($_POST['mc']));
      $RegisterBy = $user['name'];

      $query = "UPDATE moisture_content SET ";
      $query .= "Standard = '{$standard}', ";
      $query .= "Temperature = '{$temperature}', ";
      $query .= "Comments = '{$comments}', ";
      $query .= "Technician = '{$technician}', ";
      $query .= "Test_Start_Date = '{$testdate}', ";

      $query .= "Tare_Name = '{$tarename}', ";
      $query .= "Tare_Plus_Wet_Soil = '{$tarewet}', ";
      $query .= "Tare_Plus_Dry_Soil = '{$taredry}', ";
      $query .= "Water = '{$water}', ";
      $query .= "Weigth_Tare = '{$weigthtare}', ";
      $query .= "Dry_Soil = '{$drysoil}', ";
      $query .= "Mc = '{$mc}', ";

      $query .= "Registered_By = '{$RegisterBy}', ";

      $query .= "WHERE id = '{$search_table['id']}'";      

      $result = $db->query($query);

      if ($result && $db->affected_rows() === 1) {
        $session->msg('s', 'Muestra ha sido actualizada.');
        redirect('Revision-MC-Oven.php?id=' . $search_table['id'], false);
      } else {
        $session->msg('d', 'Lo siento, la actualización falló.');
        redirect('Revision-MC-Oven.php?id=' . $search_table['id'], false);
      }
    } else {
      $session->msg("d", $errors);
      redirect('Revision-MC-Oven.php?id=' . $search_table['id'], false);
    }
  }
?>