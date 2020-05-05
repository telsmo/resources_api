<?php
/**
 * AppController, Principal Controller
 * 
 * AppController It is the controller, also the MODEL and the VISTA instance.
 * @author David Fernandez <fernandezdg@gmail.com>
 * @version 1.01 (10/05/2010 - 02/03/2011)
 * @package {SP MVC} Scaffolding Project - Model View Controller
 */
/**
 * AppController class,
 * @subpackage AppController
 * 
 * @example:
 * $start = new AppController();
 * $start->appStart();
 */
class AppController{

  private $_controller;
  private $_action;
  private $_pager_url;
  private $_pager_page = 0;
  private $_pager_quantity = 10;
  private $_pager_propagate = array();
  private $_params_filter = array();
  private $_sort = 'ASC';

  public function apiStart(){
  	require_once( dirname(__FILE__) . '/../../framework/_lib/messages/Class.Messages.php');
    $m = new Messages();

    require_once( dirname(__FILE__) . '/../../framework/_common/Class.Config.php');
    $c = new Configuration();
            
    require_once( dirname(__FILE__) . '/../../framework/_lib/propagate/Class.Propagate.php');
    $p = new Propagate();
    $p->setFilter(true);
    
    require_once( dirname(__FILE__) . '/../../framework/_lib/handler/Class.Error.Handler.php');
    require_once( dirname(__FILE__) . '/../../framework/_lib/database/Class.Abstract.Connect.php');
    require_once( dirname(__FILE__) . '/../../framework/_lib/database/'.CONFIG_DATABASE_VERSION.'/Class.Connect.php');
    require_once( dirname(__FILE__) . '/../../framework/_lib/database/Class.Abstract.Query.php');
    require_once( dirname(__FILE__) . '/../../framework/_lib/database/'.CONFIG_DATABASE_VERSION.'/Class.Query.php');
    require_once( dirname(__FILE__) . '/../../framework/_lib/database/Class.Query.Methods.php');
    require_once( dirname(__FILE__) . '/../../framework/_model/APP.Abstract.Connect.Instance.php');
    require_once( dirname(__FILE__) . '/../../framework/_lib/messages/Class.Messages.php');
  	require_once( dirname(__FILE__) . '/../../framework/_lib/functions/Class.Functions.php');

    $e = new ErrorHandler();
  	$f = new Functions();

    # ADMINISTRATORS CREDENTIALS {
    $path_oauth = dirname(__FILE__) . '/../../material/_data/'.CONFIG_DB_PREFIX.'oauth.inc';
    
    if(function_exists('file_get_contents') && file_exists($path_oauth)) {
      $oauth_data = unserialize(file_get_contents($path_oauth));
    }
    else
    {
      $oauth_data = array(
        '0' => array(
          'ia'  => '0',
          'at'  => '0',
          'aa'  => '0',
        )
      );
    }
    #} ADMINISTRATORS
    // print_r($oauth_data);
    // exit();
          
    $this->_controller      = $p->spread('request','controller','index') . 'Controller';
    $this->_action          = $p->spread('request','action','index');
    $this->_pager_url       = $p->spread('request','pager_url','');
    $this->_pager_page      = $p->spread('request','pager_page',0);
    $this->_pager_quantity  = $p->spread('request','pager_quantity',10);
    
    if(!empty($_REQUEST['pager_propagate'])){
      require_once( dirname(__FILE__) . '/../../framework/_lib/crypt/Class.Crypt.php');
      $this->_crypter = new Crypt();
      $this->_crypter->setKey(CRYPT_VAR_TXT);
      $temp_pager_propagate = $this->_crypter->getDecrypt($p->spread('request','pager_propagate',''));
      $temp_pager_propagate_decode = unserialize(base64_decode($temp_pager_propagate));
      $this->_pager_propagate = is_array($temp_pager_propagate_decode) ? $temp_pager_propagate_decode : array();
      // print_r($this->_pager_propagate);
      // exit();
    }

    if(!empty($_REQUEST['params_filter'])){
      $this->_params_filter = $p->spread('request',"params_filter",'array');
    }
    $this->_sort = $p->spread('request','sort','ASC');
    $_key_cross_site = $p->spread('request','kcs',''); # Key application API
    $_key_cross_site_key = $p->spread('request','kcs_key',''); # Key to be able to modify data of the administrator entity
    $_key_cross_site_api_token = $p->spread('request','kcsp',''); # Key personal

    if( !empty($_key_cross_site_api_token) ){
      $data_oauth = $f->getSegmentOffArrayByIndice($oauth_data,'at', base64_decode($_key_cross_site_api_token));
    }else{
      $data_oauth = '';
    }

    // echo '_key_cross_site: '.$_key_cross_site.'  '.base64_decode($_key_cross_site).'<br>';
    // echo '_key_cross_site_key: '.$_key_cross_site_key.'<br>';
    // echo '_key_cross_site_api_token: '.$_key_cross_site_api_token.'  '.base64_decode($_key_cross_site_api_token).'<br><br>';

    // echo 'id_administrator: '.$data_oauth['ia'].'<br>';
    // echo 'api_token: '.$data_oauth['at'].'<br>';
    // echo 'access_api: '.$data_oauth['aa'].'<br>';
    // exit();

    if( in_array($this->_controller, $c->setExceptionsApi()) ){
      $controllerPath = FOLDER_CONTROLLER . $this->_controller . '.php';
    }else{
      $controllerPath = FOLDER_CONTROLLER . 'APP.Base.Controller.php';
    }

    if( empty($_key_cross_site) || 
      base64_decode($_key_cross_site)!=CRYPT_VAR_WEB_SERVICE || 
      empty($_key_cross_site_api_token) || 
      base64_decode($_key_cross_site_api_token)!=$data_oauth['at']){
      die(utf8_decode($m->getPageMessage($this->_controller . '->>' . $this->_action, 'controller','405')));
    }

    if(!empty($_key_cross_site) && base64_decode($_key_cross_site)==CRYPT_VAR_WEB_SERVICE && $this->_controller=='usersController'){
      //
    }elseif(!empty($_key_cross_site) && base64_decode($_key_cross_site)==CRYPT_VAR_WEB_SERVICE && !empty($_key_cross_site_key) && base64_decode($_key_cross_site_key)==CRYPT_VAR_WEB_SERVICE_KEY && $this->_controller=='administratorsController'){
    //
    }else{
      if( in_array($this->_controller, $c->setRestrictControllersApi()) ){
        die(utf8_decode($m->getPageMessage($this->_controller . '->' . $this->_action, 'controlador','404')));
      }
    }

    if(is_file($controllerPath)){
      require_once($controllerPath);
    }else{
      die(utf8_decode($m->getPageMessage($this->_controller . '->' . $this->_action, 'controlador','404')));
    }

    if( in_array($this->_controller, $c->setExceptionsApi()) ){
      $control = new $this->_controller(); 
    }else{
      $control = new AppBaseController();
    }

    $control->setPrefix(CONFIG_DB_PREFIX);
    $control->setDatabase(CONFIG_DB_NAME);
    $control->setMessages($m);
    $control->setPropagate($p);
    $control->setFunctions($f);

    if (is_callable(array($control, $this->_action)) == false){
      die($m->getPageMessage($this->_controller . '->' . $this->_action, 'controlador','400'));
      return false;
    }

    $control->setController(str_replace('Controller','',$this->_controller));
    $control->setAction($this->_action);
    $control->setPagerUrl($this->_pager_url);
    $control->setPagerPage($this->_pager_page);
    $control->setPagerQuantity($this->_pager_quantity);
    $control->setPagerPropagate($this->_pager_propagate);
    $control->setParamFilter($this->_params_filter);
    $control->setSort($this->_sort);
    $control->{$this->_action}();
  }
  public function __destruct(){}
}
?>