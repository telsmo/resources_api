<?php

$urlListar = 'index.php?controller='.$this->_controller.'&action=listar&paginar='.$this->_pager_page.'&';
$urlListarEntities = htmlentities($urlListar);
$the_key = $this->_key;
$sin = array('error');

switch($action){
  
  case 'index':
    $sin = array(htmlentities('Controlador: ').$this->_controller);
    $data = array(
      'error' => true,
      'controller' => $this->_controller,
      'action' => $this->_action,
      'data' => $sin
    );
    $retorno = json_encode($data);
    $tpl_main = $retorno;
  break;

  // case 'listar':
  //   if( is_array($resultSelect) ){
  //     $cantidadRecords = count($resultSelect);

  //     $data = array(
  //       'error' => false,
  //       'controller' => $this->_controller,
  //       'action' => $this->_action,
  //       //'pRecords' => $paginadorRecords,
  //       'pCantidad' => $pagerQuantity,
  //       'pPaginar' => $pagerPage,
  //       //'pLink' => $paginadorLink,
  //       //'pPropagate' => $pagerPropagate,
  //       'data' => $resultSelect
  //     );
  //     $retorno = json_encode($data);
  //   }else{
  //     $data = array(
  //       'error' => true,
  //       'controller' => $this->_controller,
  //       'action' => $this->_action,
  //       'data' => $sin
  //     );
  //     $retorno = json_encode($data);
  //   }

  //   $tpl_main = $retorno;
  // break;
  
  case 'listed':
  if( is_array($resultSelect) ){
    $data = array(
      'error' => false,
      'controller' => $this->_controller,
      'action' => $this->_action,
      'data' => $resultSelect
    );
    $retorno = json_encode($data);
  }else{
    $data = array(
      'error' => true,
      'controller' => $this->_controller,
      'action' => $this->_action,
      'data' => $sin
    );
    $retorno = json_encode($data);
  }

  $tpl_main = $retorno;
  break;

  case 'filter':
    if( is_array($resultFilter) ){
      $data = array(
        'error' => false,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $resultFilter
      );
      $retorno = json_encode($data);
    }else{
      $sin = array('No hay registros');
      $data = array(
        'error' => true,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;
  break;

  case 'filtrar':
    if( is_array($resultFilter) ){
      $data = array(
        'error' => false,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $resultFilter
      );
      $retorno = json_encode($data);
    }else{
      $data = array(
        'error' => true,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;
  break;

  case 'posicion':
    if( !empty($result) ){
      $data = array(
        'error' => false,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $result
      );
      $retorno = json_encode($data);
    }else{
      $data = array(
        'error' => true,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;
  break;

  case 'search':
    if( is_array($result) ){
      $data = array(
        'error' => false,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $result
      );
      $retorno = json_encode($data);
    }else{
      $data = array(
        'error' => true,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;
  break;

  case 'detail':
    if( is_object($resultSingle['0']) ){
      $data = array(
        'error' => false,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $resultSingle['0']
      );
      $retorno = json_encode($data);
    }else{
      $data = array(
        'error' => true,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;
  break;

  case 'talos01':
    if( is_int($resultInsertar) ){
      $data = array(
        'error' => false,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $resultInsertar
      );
      $retorno = json_encode($data);
    }else{
      $data = array(
        'error' => true,
        'controller' => $this->_controller,
        'action' => $this->_action,
        'data' => $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;
  break;

  case 'talos02':
    if( !empty($resultUpdate) )
    {
      $data = array(
        'error'			=> false,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $resultUpdate
      );
      $retorno = json_encode($data);
    }
    else
    {
      $data = array(
        'error'			=> true,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;
  break;

  case 'talos03':
    if( !empty($resultDelete) )
    {
      $data = array(
        'error'			=> false,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $resultDelete
      );
      $retorno = json_encode($data);
    }
    else
    {
      $data = array(
        'error'			=> true,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;

  break;

  case 'give':

    if( is_array($result) )
    {
      $data = array(
        'error'			=> false,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $result
      );
      $retorno = json_encode($data);
    }
    else
    {
      $sin = array('No hay registros');
      $data = array(
        'error'			=> true,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;

  break;

  case 'filterPaged':

    if( is_array($resultFilter) )
    {
      $cantidadRecords = count($resultFilter);

      /*if($this->_pager==true)
      {*/
        $paginadorLink = !empty($pagerUrl) ? $pagerUrl : $this->_table.'.php';

        // echo array_key_exists("pager_page",$this->_pager_propagate);
        // exit();
        $pagerPropagateTemp = array_key_exists("pager_page",$pagerPropagate) ? $pagerPropagate : array('controller','action');

        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setFields($this->_fields);

        $paginadorRecords = $this->_model->getTotalRecords();

        require_once( dirname(__FILE__) . '/../../framework/_lib/pager/Class.Pager.php' );
        $pager = new Pager;
        $pager->setPagerUrl($paginadorLink);
        $pager->setRecords($paginadorRecords);
        $pager->setPagerQuantity($pagerQuantity);
        $pager->setPagerPage($pagerPage);
        // print_r($pagerPropagateTemp);
        // exit();
        $pager->setPagerPropagate($pagerPropagateTemp);
        // $pager->setLink($paginadorLink);
        // $pager->setPropaga($pagerPropagate);
        $paginador = $pager->paged();
      //}

      $data = array(
        'error'			=> false,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,

        'pageTotalRecords'		=> $paginadorRecords,
        'pageCantidad'			=> $pagerQuantity,
        'pagePaginar'			=> $pagerPage,
        'pageLink'				=> $paginadorLink,
        'pagePropagate'			=> $pagerPropagate,
        'paginador'				=> $paginador,

        'data' 			=> $resultFilter
      );
      $retorno = json_encode($data);
    }
    else
    {
      $data = array(
        'error'			=> true,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;

  break;

  case 'delete01':

    if( !empty($resultDelete) )
    {
      $data = array(
        'error'			=> false,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $resultDelete
      );
      $retorno = json_encode($data);
    }
    else
    {
      $data = array(
        'error'			=> true,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;

  break;

  case 'injectionPaged':

    if( is_array($resultFilter) )
    {
      $cantidadRecords = count($resultFilter);

      /*if($this->_pager==true)
      {*/
      // $paginadorLink = $this->_table.'.php';
      $paginadorLink = !empty($pagerUrl) ? $pagerUrl : $this->_table.'.php';
      $pagerPropagate = array('controller','action');

      $this->_model->setTable($this->_prefix.$this->_table);
      $this->_model->setFields($this->_fields);

      $paginadorRecords = $this->_model->getTotalRecords();

      require_once( dirname(__FILE__) . '/../../framework/_lib/pager/Class.Pager.php' );
      $pager = new Pager;
      $pager->setPagerUrl($paginadorLink);
      $pager->setRecords($paginadorRecords);
      $pager->setPagerQuantity($pagerQuantity);
      $pager->setPagerPage($pagerPage);
      // $pager->setLink($paginadorLink);
      // $pager->setPropaga($pagerPropagate);
      $paginador = $pager->paged();
      //}

      $data = array(
        'error'			=> false,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,

        'pageTotalRecords'		=> $paginadorRecords,
        'pageCantidad'			=> $pagerQuantity,
        'pagePaginar'			=> $pagerPage,
        'pageLink'				=> $paginadorLink,
        'pagePropagate'			=> $pagerPropagate,
        'paginador'				=> $paginador,

        'data' 			=> $resultFilter
      );
      $retorno = json_encode($data);
    }
    else
    {
      $data = array(
        'error'			=> true,
        'controller'	=> $this->_controller,
        'action'		=> $this->_action,
        'data' 			=> $sin
      );
      $retorno = json_encode($data);
    }

    $tpl_main = $retorno;

  break;

  default:

    $data = array(
      'error'			=> true,
      'controller'	=> $this->_controller,
      'action'		=> $this->_action,
      'data' 			=> $sin
    );
    $retorno = json_encode($data);

    $tpl_main = $retorno;

  break;
  }

header("Access-Control-Allow-Origin: *");
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json; charset=utf-8');

echo $tpl_main;

?>