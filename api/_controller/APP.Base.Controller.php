<?php
/**
 * AppBaseController, Controller "base"
 * 
 * The Class AppBaseController is the "base" controller responsible for processing the requests.
 * Instance the model and the view.
 * @author David Fernandez <fernandezdg@gmail.com>
 * @version 1.01 (10/05/2010 - 02/03/2011)
 * @package {SP MVC} Scaffolding Project - Model View Controller
 * @subpackage Controller
 */
class AppBaseController{
# THIS ALWAYS GOES {
    /**
     * $_m, instance of Messages
     * @access private
     * @var string
     */
    private $_m;
    /**
     * $_controller, will be the name of the controller to apply
     * @access private
     * @var string
     */
    private $_controller = '';
    /**
     * $_action, will be the name of the method or action to apply
     * @access private
     * @var string
     */
    private $_action = '';
    /**
     * $_model, will be the MODEL instance
     * @access private
     * @var object
     */
    private $_model;
    /**
     * $_rules, will be the set of rules to apply when a KEY is foreign
     * @access private
     * @var string
     */
    private $_rules;
    /**
     * $_rules_instructions, when a KEY is foreign, it arranges the parameterized queries to apply for the realizations between tables
     * @access private
     * @var string
     */
    private $_rules_instructions = array();
    /**
     * $_p, instance of Propagate
     * @access private
     * @var string
     */
    private $_p;
    /**
     * $_f, instance of Functions
     * @access private
     * @var string
     */
    private $_f;
    /**
     * $_database, will be the name of the database to be used
     * @access private
     * @var string
     */
    private $_database = '';
    /**
     * $_prefix, it will be the name of the prefix of the table (if it has one)
     * @access private
     * @var string
     */
    private $_prefix = '';
    /**
     * $_table, will be the name of the table to be used (the name will be the name of the controller)
     * @access private
     * @var string
     */
    private $_table = '';
    /**
     * $_key, Primary KEY of the row in a table
     * @access private
     * @var number
     */
    private $_key = '';
    /**
     * $_field_applied, are the fields of a table that will be used (It is configured)
     * @access private
     * @var number
     */
    private $_field_applied = '';
    /**
     * $_fields, existing fields in a table (automatic)
     * @access private
     * @var array
     */
    private $_fields = array();
    /**
     * $_fields_show, fields to be displayed in lists and forms (It is configured)
     * @access private
     * @var array
     */
    private $_fields_show = array();
    /**
     * $_fields_relation, will be the set of fields in a table that have a relation with another table (KEY FORANEO)
     * @access private
     * @var array
     */
    private $_fields_relation = array();
    /**
     * $_estructuraBbdd, content structure of the Database with all its tables and rules. Method getStructureDatabase() of the model.
     * @access private
     * @var object
     */
    private $_estructuraBbdd = '';
    /**
     * $_pager, indicates whether the query will be paged and will contain pager
     * @access private
     * @var boolean
     */
    private $_pager = false;
    /**
     * $_pager_url, replace default name controller
     * @access private
     * @var string
     */
    private $_pager_url = 0;
    /**
     * $_pager_page, current page number
     * @access private
     * @var number
     */
    private $_pager_page = 0;
    /**
     * $_pager_quantity, number of records per page
     * @access private
     * @var number
     */
    private $_pager_quantity = 10;
    /**
     * $_pager_propagate, Array with fields to be included in the page.
     * @access private
     * @var array
     */
    private $_pager_propagate = array();
    /**
     * $_params_filter, Array with fields to be omitted in the insert
     * @access private
     * @var array
     */
    private $_params_filter = array();
	/**
     * $_posted, instance of the Upload class. Try uploading the files
     * @access private
     * @var object
     */
    private $_posted = '';
    /**
     * $_files_path_host, path to files
     * @access private
     * @var string
     */
    private $_files_path_host = '';
    /**
     * $_files_path_physical, physical path to the files
     * @access private
     * @var string
     */
    private $_files_path_physical = '';
    /**
     * $_status, state of a record in a table (logical deletion applies)
     * @access private
     * @var string
     */
    private $_status = 'status';
    /**
     * $_order, field to apply order in a record of a table
     * @access private
     * @var string
     */
    private $_order = 'field_order';
    /**
     * $_sort, order to apply in the consultations (ASC - DESC)
     * @access private
     * @var string
     */
    private $_sort = 'ASC';
    /**
     * $_save_data_on_file, determines if the data will be saved in a physical file, is indicated in the comments of the table
     * @access private
     * @var array
     */
    private $_save_data_on_file = false;
    /**
     * __construct function
     * @see __construct()
     * Note: Constructor
     */
    function __construct(){}
    /**
     * setMessages public function
     * @uses setMessages(), Class
     * @uses $this->_m, Instance
     * Note: Set global messages
     */
    public function setMessages($m){
        $this->_m = $m;
    }
    /**
     * setPropagate public function
     * @uses AppSessions(), Class
     * @uses $this->_p, Instance
     * Note: Set the propagate instance
     */
    public function setPropagate($p){
        $this->_p = $p;
    }
    /**
     * setFunctions public function
     * @uses AppSessions(), Class
     * @uses $this->_f, Instance
     * Note: Set the instance Functions
     */
    public function setFunctions($f){
        $this->_f = $f;
    }
    /**
     * setFilesPath public function
     * @uses dirname(), Function
     * @uses CONFIG_HOST_NAME_FRONTEND, Constant
     * @uses $this->_table, String
     * @uses $path, String
     * Note: Set the paths of the images
     */
    public function setFilesPath($path=''){
        $directory = dirname(__FILE__) . '/../../material/'.$this->_table.'/';
        $this->_files_path_physical = empty($path) ? $directory : $path;
        $this->_files_path_host = CONFIG_HOST_NAME_FRONTEND.'material/'.$this->_table.'/';
    }
    /**
     * setAction public function
     * @uses $action, String
     * Note: Set the method or action to apply
     */
    public function setAction($action){
        $this->_action = $action;
    }
    /**
     * setPrefix public function
     * @uses $prefix, String
     * Note: Set the prefix of the table
     */
    public function setPrefix($prefix){
        $this->_prefix = $prefix;
    }
    /**
     * setDatabase public function
     * @uses $database, String
     * Note: Set the name of database to use
     */
    public function setDatabase($database){
        $this->_database = $database;
    }
    /**
     * setController public function
     * @uses $controller, String
     * @uses $this->setSessions(), Function
     * @uses $this->setFilesPath(), Function
     * @uses $this->getModel(), Function
     * @uses $this->getUpload(), Function
     * @uses $this->getRules(), Function
     * Note: Set the controller to apply, instantiate the path of the records, the model, file upload and rules
     */
    public function setController($controller){
        $this->_table = $controller;
        $this->_controller = $controller;
        //$this->setSessions();
        $this->setFilesPath();
        $this->getModel();
        $this->_model->setPropagate($this->_p);
        $this->getUpload();
        
        if($this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_save_data_on_file']==true){
            $this->_save_data_on_file = true;
        }
    }
    /**
     * setPager public function
     * @uses valor, Variable
     * Note: setPager, indicates if pager applies
     */
    public function setPager($pager=false){
        $this->_pager = $pager;
    }
    /**
     * setPagerUrl public function
     * @uses $pager_page, String
     * Note: Apply the new URL, diferent of default controller
     */
    public function setPagerUrl($pager_url){
        $this->_pager_url = $pager_url;
    }
    /**
     * setPagerPage public function
     * @uses $pager_page, String
     * Note: Apply the page of the pager
     */
    public function setPagerPage($pager_page){
        $this->_pager_page = (int) $pager_page;
    }
    /**
     * setOrder public function
     * @uses $order, String
     * Note: Indicate what the field to take into account to apply the "ORDER BY" in the query
     */
    public function setOrder($order){
        $this->_order = $order;
    }
    /**
     * setSort public function
     * @uses $sort, String
     * Note: Indicates the type of order to be applied ASC / DESC
     */
    public function setSort($sort){
        $this->_sort = $sort;
    }
    /**
     * setPagerQuantity public function
     * @uses $pager_quantity, String
     * Note: Apply the record amount to page
     */
    public function setPagerQuantity($pager_quantity){
        $this->_pager_quantity = $pager_quantity;
    }
    /**
     * setPagerPropagate public function
     * @uses $pager_propagate, String
     * Note: Array with fields that will be included in the pagination.
     */
    public function setPagerPropagate($pager_propagate){
        $this->_pager_propagate = $pager_propagate;
    }
    /**
     * setParamFilter public function
     * @uses $params_filter, String
     * Note: Array with fields that will be excluded when inserting
     */
    public function setParamFilter($params_filter){
        $this->_params_filter = $params_filter;
    }
    /**
     * getModel public function
     * @uses dirname(), Function
     * @uses file_exists(), Function
     * @uses trigger_error(), Function
     * @uses FOLDER_MODEL, Constant
     * @uses AppBaseModel(), Class
     * @uses getStructureDatabase(), Method
     * Note: Instance the Model
     */
    public function getModel(){
        $path = dirname(__FILE__) . '/../'.FOLDER_MODEL.'APP.Base.Model.php';

        if (file_exists($path) == false) {
            trigger_error ('Model `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }

        require_once($path);
        $this->_model = new AppBaseModel();
        $this->_estructuraBbdd = $this->_model->getStructureDatabase();
    }
    /**
     * getView public function
     * @uses dirname(), Function
     * @uses file_exists(), Function
     * @uses trigger_error(), Function
     * @uses FOLDER_VIEW, Constant
     * Note: Includes the View
     */
    public function getView(){
        $path = dirname(__FILE__) . '/../'.FOLDER_VIEW.'APP.Base.View.php';

        if (file_exists($path) == false) {
            trigger_error ('View `' . $path . '` does not exist.', E_USER_NOTICE);
            return false;
        }
        return $path;
    }
    /**
     * getUpload public function
     * @uses $_POST(), Array
     * @uses dirname(), Function
     * @uses Upload(), Class
     * Note: Upload Instance (treats uploads of files)
     */
    public function getUpload(){
        /*if($_POST){
            $path = dirname(__FILE__) . '/../_lib/upload/Class.Upload.php';
            require_once($path);
            $this->_posted = new Upload();
        }*/
    }
    /**
     * getRules public function
     * @uses dirname(), Function
     * @uses file_exists(), Function
     * @uses FOLDER_MODEL, Constant
     * @uses $this->_controller, String
     * @uses Rules(), Class
     * @uses $this->setPrefix(), Method
     * @uses $this->getRules(), Method
     * Note: Instance the rules to apply in case the data is a foreign KEY having prepared queries, queries related to its controller.
     */
    public function getRules(){
        $path = dirname(__FILE__) . '/../'.FOLDER_MODEL.'_rules/'.$this->_controller.'.php';

        if (file_exists($path) == false) {
            return false;
        }else{
            require_once($path);
            $this->_rules = new Rules();
            $this->_rules->setPrefix($this->_prefix);
            $this->_rules_instructions = $this->_rules->getRules();
        }
    }
    /**
     * getCrypter public function
     * @uses dirname(), Function
     * @uses Crypt(), Class
     * Note: Instance of Crypt, class that handles the encryption of the values saved in session
     */
    public function getCrypter(){
        $path = dirname(__FILE__) . '/../../framework/_lib/crypt/Class.Crypt.php';
        require_once($path);
        $this->_crypter = new Crypt();
    }
# } THIS ALWAYS GOES
    /**
      * List of available ACTIONS
      * Note: Each action as controller has its equivalent as model (model) and view (view)
      * The controller is in charge of receiving the interactions, processing them and arranging them for the model and then calls the view, each controller implements its correlation with the MODEL and its VISTA. A controller can dispense with the model but not with his view. Each controller has its equilibrium in the DB to respond to the Scaffolding system, but it may not have equibalence such as: start, login (This is configured in the config class in the setExceptionsApi () method)
      * /
    /**
     * index public function
     * @uses $this->_action, Variable
     * @uses $this->getView(), Method, Apply the view
     * Note: index, initial method for each controller.
     */
    public function index(){
        $action = $this->_action;
        require_once($this->getView());
    }
    /**
     * listed public function
     * @uses $this->setPager(), Method, implements pager
     * @uses $this->_setCampos(), generates an array with the fields to be used, and leaves them in memory
     * @uses $this->_model->setTable(), Method, tells the model which table of the DB will use
     * @uses $this->_model->setFields(), Method, tells the model fields to be treated
     * @uses $this->_model->setKey(), Method, tells the model which is the field of type UNICO (PRI) will be the unicId
     * @uses $this->_model->setStatus(), Method, tells the model which state (logical) to apply when interacting with the DB
     * @uses $this->_model->setOrder(), Method, tells the model if the record order 'logical' applies the table must have an order field
     * @uses $this->_model->setSort(), Method, tells the model in which order the list of records should be debugged}
     * @uses $this->_model->getRecordsPaged(), Method, tells the model which method to apply
     * @uses $this->_structureBbdd, Array, It is an associative matrix that contains the structure of the database and the meta data to apply in each controller, action and view
     * @uses $this->getView(), Method, Apply the view
     * Note: list, it deals with a list of recordsets
     */
   /* public function listed(){
        $this->setPager(true);
        $setCamposRules = array(
            'TYPE' => array(array('LIST' => true,'FORM' => false)),
            'METHOD' => array(array('GET' => false,'POST' => false,'REQUEST' => false,'FILES' => false)),
            'ONLYKEY' => false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setTable($this->_prefix.$this->_table);		
        $this->_model->setFields($this->_fields);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setOrder($this->_order);
        $this->_model->setSort($this->_sort);
        
        if($this->_pager==true){
            $this->_model->setPager(true);
            $this->_model->setPagerQuantity($this->_pager_quantity);
            $this->_model->setPagerPage($this->_pager_page);
        }
        
        $resultSelect = $this->_model->getRecordsPaged();
        $table_name = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_alternatename'];
        $table_show_in_list = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinlist'];
        $table_show_in_form = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinform'];
        $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];
        $action = $this->_action;
        
        require_once($this->getView());
    }*/
    /*
     * List
     */
    public function listed(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => true
            )),
            'METHOD' => array(array(
                'GET' => false,
                'POST' => false,
                'REQUEST' => false,
                'FILES' => false
            )),
            'ONLYKEY' => false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setTable($this->_prefix.$this->_table);		
        $this->_model->setFields($this->_fields);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setOrder($this->_order);
        $this->_model->setSort($this->_sort);

        $resultSelect = $this->_model->getRecords();
        $table_name = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_alternatename'];
        $table_show_in_list = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinlist'];
        $table_show_in_form = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinform'];
        $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * Detail
     */
    public function detail(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => true,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => false,
                'POST' => false,
                'REQUEST' => false,
                'FILES' => false
            )),
            'ONLYKEY' 	=> false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setFields($this->_fields);

        $resultSingle = $this->_model->getDetail();

        $table_name = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_alternatename'];
        $table_show_in_list = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinlist'];
        $table_show_in_form = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinform'];
        $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * Filter
     */
    public function filter(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => false,
                'REQUEST' => false,
                'FILES' => false
            )),
            'ONLYKEY' => false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setTable($this->_prefix.$this->_table);		
        $this->_model->setFields($this->_fields);
        $this->_model->setOrder($this->_order);
        $this->_model->setSort($this->_sort);

        $arrayFields = $this->_fields;
        $this->_model->setFieldAppliedArray($arrayFields);

        $resultFilter = $this->_model->getFilter();

        $table_name = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_alternatename'];
        $table_show_in_list = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinlist'];
        $table_show_in_form = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinform'];
        $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * Filter
     */
    public function filtrar(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => false,
                'REQUEST' => false,
                'FILES' => false
            )),
            'ONLYKEY' => false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setTable($this->_prefix.$this->_table);		
        $this->_model->setFields($this->_fields);

        $arrayFields = $this->_fields;
        $this->_model->setFieldAppliedArray($arrayFields);

        $resultFilter = $this->_model->getFilter();

        $table_name = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_alternatename'];
        $table_show_in_list = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinlist'];
        $table_show_in_form = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinform'];
        $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * Search
     */
    public function search(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => true,
                'REQUEST' => false,
                'FILES' => true
            )),
            'ONLYKEY' => false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setTable($this->_prefix.$this->_table);		
        $this->_model->setFields($this->_fields);
        $arrayFields = $this->_fields;
        $this->_model->setFieldAppliedArray($arrayFields);
        $result = $this->_model->getSearch();

        $table_name = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_alternatename'];
        $table_show_in_list = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinlist'];
        $table_show_in_form = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinform'];
        $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * Insert
     */
    public function talos01(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => true,
                'REQUEST' => false,
                'FILES' => true
            )),
            'ONLYKEY' => true
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setParamFilter($this->_params_filter);
        $this->_model->setFields($this->_fields);
        $this->_model->setSaveOnFile($this->_save_data_on_file);

        $resultInsertar = $this->_model->getTalos01();

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * POsition - returns the previous and next record
     */
    public function position(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => true,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => false,
                'POST' => false,
                'REQUEST' => false,
                'FILES' => false
        )),
            'ONLYKEY' => false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setOrder($this->_order);
        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setFields($this->_fields);
        
        $arrayFields = $this->_fields;
        
        $this->_model->setFieldApplied($this->_order);
        $this->_model->setFieldAppliedArray($arrayFields);
        
        $result = $this->_model->getPosicion();
        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * Talos02
     */
    public function talos02(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => true,
                'REQUEST' => false,
                'FILES' => true
            )),
            'ONLYKEY' => true
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setParamFilter($this->_params_filter);
        $this->_model->setFields($this->_fields);
        $this->_model->setSaveOnFile($this->_save_data_on_file);

        $resultUpdate = $this->_model->getTalos02();

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * Talos03 Delete - Logical
     */
    public function talos03(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => true,
                'REQUEST' => false,
                'FILES' => true
            )),
            'ONLYKEY' => true
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setFields($this->_fields);
        $this->_model->setFieldApplied($this->_status);
        $this->_model->setSaveOnFile($this->_save_data_on_file);

        $resultUpdate = $this->_model->getTalos03();

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * List
     */
    public function give(){
        if(!empty($_GET['query'])){
            $this->getCrypter();
            $this->_crypter->setKey(CRYPT_VAR_TXT);
            $inCrypter = $this->_crypter->getDecrypt($this->_p->spread('get','query',''));
        }
        if(!empty($_POST['query'])){
            $this->getCrypter();
            $this->_crypter->setKey(CRYPT_VAR_TXT);
            $inCrypter = $this->_crypter->getDecrypt($this->_p->spread('post','query',''));
        }
        if(!empty($_REQUEST['query'])){ 
            $this->getCrypter();
            $this->_crypter->setKey(CRYPT_VAR_TXT);
            $inCrypter = $this->_crypter->getDecrypt($this->_p->spread('request','query',''));
        }

        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => true,
                'REQUEST' => false,
                'FILES' => false
            )),
            'ONLYKEY' => true
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setFields($this->_fields);

        $result = $this->_model->getInjectionGive($inCrypter);

        $action = $this->_action;
        require_once($this->getView());
    }

    public function delete01(){
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => true,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => false,
                'POST' => false,
                'REQUEST' => false,
                'FILES' => false
            )),
            'ONLYKEY' => false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setFields($this->_fields);
        $this->_model->setFieldApplied($this->_status);
        $this->_model->setSaveOnFile($this->_save_data_on_file);

        $resultDelete = $this->_model->getDelete01();

        $action = $this->_action;
        require_once($this->getView());
    }
    /**
     * filterPaged public function
     * @uses $this->setPager(), Method, implements pager
     * @uses $this->_ setCampos(), Method, generates an array with ALL the fields to be used, and leaves them in memory
     * @uses $this->_ setCamposGet(), Method, add to the arrays the fields that are passed through GET
     * @uses $this->_ model->setKey(), Method, tells the model which is the field of type UNICO (PRI) will be the unicId
     * @uses $this->_ model->setStatus(), Method, tells the model which state (logical) to apply when interacting with the DB
     * @uses $this->_ model->setTable(), Method, tells the model which table of the DB will use
     * @uses $this->_ model->setFields(), Method, tells the model fields to be treated
     * @uses $this->_ model->setOrder(), Method, tells the model if the record order 'logical' applies the table must have an order field
     * @uses $this->_ model->setSort(), Method, tells the model in which order the list of records should be debugged}
     * @uses $this->_ model->setFieldAppliedArray (), Method, field array to be treated
     * @uses $this->_ model->getFecordsPaged (), Method, tells the model which method to apply
     * @uses $this->_ structureBbdd, Array, It is an associative matrix that contains the structure of the Database and the meta data to apply in each controller, action and view
     * @uses $this-> getView(), Method, Apply the view
     * Note: list, treat a list of record sets but filtered and paged
     */
    public function filterPaged(){
        $this->setPager(true);
        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => true,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => false,
                'REQUEST' => false,
                'FILES' => false
            )),
            'ONLYKEY' => false
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setStatus($this->_status);
        $this->_model->setTable($this->_prefix.$this->_table);		
        $this->_model->setFields($this->_fields);
        $this->_model->setOrder($this->_order);
        $this->_model->setSort($this->_sort);

        $arrayFields = $this->_fields;
        $this->_model->setFieldAppliedArray($arrayFields);

        if($this->_pager==true){
            $pagerActive = true;
            $pagerUrl = $this->_pager_url;
            $pagerPage = $this->_pager_page;
            $pagerQuantity = $this->_pager_quantity;
            $pagerPropagate = $this->_pager_propagate;

            $this->_model->setPager($pagerActive);
            $this->_model->setPagerUrl($pagerUrl);
            $this->_model->setPagerPage($pagerPage);
            $this->_model->setPagerQuantity($pagerQuantity);
            // $this->_model->setPagerPropagate($pagerPropagate);
        }

        $resultFilter = $this->_model->getFilterPaged();

        $table_name = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_alternatename'];
        $table_show_in_list = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinlist'];
        $table_show_in_form = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinform'];
        $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];

        $action = $this->_action;
        require_once($this->getView());
    }
    /*
     * Injection paged
     */
    public function injectionPaged(){
        $this->setPager(true);
        if(!empty($_GET['query'])){
            $this->getCrypter();
            $this->_crypter->setKey(CRYPT_VAR_TXT);
            $inCrypter = $this->_crypter->getDecrypt($this->_p->spread('get','query',''));
        }
        if(!empty($_POST['query'])){
            $this->getCrypter();
            $this->_crypter->setKey(CRYPT_VAR_TXT);
            $inCrypter = $this->_crypter->getDecrypt($this->_p->spread('post','query',''));
        }
        if(!empty($_REQUEST['query'])){ 
            $this->getCrypter();
            $this->_crypter->setKey(CRYPT_VAR_TXT);
            $inCrypter = $this->_crypter->getDecrypt($this->_p->spread('request','query',''));
        }

        $setCamposRules = array(
            'TYPE' => array(array(
                'LIST' => false,
                'FORM' => false
            )),
            'METHOD' => array(array(
                'GET' => true,
                'POST' => true,
                'REQUEST' => false,
                'FILES' => false
            )),
            'ONLYKEY' => true
        );
        $this->_setCampos($setCamposRules);
        $this->_model->setKey($this->_key);
        $this->_model->setTable($this->_prefix.$this->_table);
        $this->_model->setFields($this->_fields);

        if($this->_pager==true){
            $pagerActive = true;
            $pagerUrl = $this->_pager_url;
            $pagerPage = $this->_pager_page;
            $pagerQuantity = $this->_pager_quantity;
            $pagerPropagate = $this->_pager_propagate;

            $this->_model->setPager($pagerActive);
            $this->_model->setPagerUrl($pagerUrl);
            $this->_model->setPagerPage($pagerPage);
            $this->_model->setPagerQuantity($pagerQuantity);
            $this->_model->setPagerPropagate($pagerPropagate);
        }

        $resultFilter = $this->_model->getInjectionPaged($inCrypter);

        $action = $this->_action;
        require_once($this->getView());
    }
# THIS ALWAYS GOES TO THE END {
    /**
      * _setCampos public function
      * @uses $this->_model->_fields, Array
      * @uses $this->_model->_fields_show, Array
      * @uses $this->_model->_fields_relation, Array
      * @uses $this->_model->_key, Array
      * @uses $this->_structureBbdd, Array, It is an associative matrix that contains the structure of the Database and the meta data to apply in each controller, action and view
      * Note: _setCampos, Indicates which is the primary key (PRI) and the foreign key (MUL)
      * It also makes available different arrangement with the columns to be taken into account
      * Configure the fields to be treated for lists or forms etc.
      * Take the value of the Database from the Comment field
      * Also add to the arrays the fields that are in the matrices $ _GET, $ _POST, $ _REQUEST, $ _FILES according to the need can be combined.
      */
    public function _setCampos($setCamposRules){
        if (is_array($setCamposRules)){
            if (isset($setCamposRules['TYPE']) && is_array($setCamposRules['TYPE'])){
                $table_name = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_alternatename'];
                $table_show_in_list = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinlist'];
                $table_show_in_form = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_showinform'];
                $table_save_data_on_file = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_save_data_on_file'];
                $table_rules = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_rules'];
                $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];

                foreach ($setCamposRules['TYPE'] as $structure){
                    if($structure['LIST']===true){
                        foreach($table_fields as $key=> $value){
                            $field = $key;
                            $field_alternate_name = $table_fields[$key]['alternatename'];
                            $field_list = $table_fields[$key]['showinlist'];
                            $field_form = $table_fields[$key]['showinform'];
                            $field_primary_key = $table_fields[$key]['key'];
                            if($field_list=='true'){
                                $this->_fields[] = $key;
                                $this->_fields_show[] = $field_alternate_name;
                            }
                            if($field_primary_key=='PRI'){
                                $this->_key = $key;
                            }
                            if($field_primary_key=='MUL'){
                                $this->_fields_relation[] = $key;
                            }
                        }
                    }
                    if($structure['FORM']===true){
                        foreach($table_fields as $key=> $value){
                            $field = $key;
                            $field_alternate_name = $table_fields[$key]['alternatename'];
                            $field_list = $table_fields[$key]['showinlist'];
                            $field_form = $table_fields[$key]['showinform'];
                            $field_primary_key = $table_fields[$key]['key'];
                            if($field_form=='true'){
                                $this->_fields[] = $key;
                                $this->_fields_show[] = $field_alternate_name;
                            }
                            if($field_primary_key=='PRI'){
                                $this->_key = $key;
                            }
                            if($field_primary_key=='MUL'){
                                $this->_fields_relation[] = $key;
                            }
                        }
                    }
                }
            }

            if (isset($setCamposRules['METHOD']) && is_array($setCamposRules['METHOD'])){
                foreach ($setCamposRules['METHOD'] as $method){
                    if($method['GET']===true){
                        if(isset($_GET)){
                            foreach($_GET as $var=> $val){
                                if($this->_f->chek_field($var, $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'])){
                                    if(!in_array($var,$this->_fields)){
                                        $this->_fields[] = $var;
                                    }
                                }
                            }
                        }
                    }
                    if($method['POST']===true){
                        if(isset($_POST)){
                            foreach($_POST as $var=> $val){
                                if($this->_f->chek_field($var, $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'])){
                                    if(!in_array($var,$this->_fields)){
                                        $this->_fields[] = $var;
                                    }
                                }
                            }
                        }
                    }
                    if($method['REQUEST']===true){
                        if(isset($_REQUEST)){
                            foreach($_REQUEST as $var=> $val){
                                if($this->_f->chek_field($var, $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'])){
                                    if(!in_array($var,$this->_fields)){
                                        $this->_fields[] = $var;
                                    }
                                }
                            }
                        }
                    }
                    if($method['FILES']===true){
                        if(isset($_FILES)){
                            foreach($_FILES as $var=> $val){
                                if($this->_f->chek_field($var, $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'])){
                                    if(!in_array($var,$this->_fields)){
                                        $this->_fields[] = $var;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if (isset($setCamposRules['ONLYKEY']) && !empty($setCamposRules['ONLYKEY'])){
                $table_fields = $this->_estructuraBbdd[$this->_database][$this->_prefix.$this->_table]['GLOBAL_data'];

                foreach($table_fields as $key=> $value){
                    $field_primary_key = $table_fields[$key]['key'];

                    if($field_primary_key=='PRI'){
                        $this->_key = $key;
                    }

                    if($field_primary_key=='MUL'){
                        $this->_fields_relation[] = $key;
                    }
                }
            }
        }
    }
    /**
     * __destruct public function
     * Note: Clears the object when it is no longer used
     * @see __destruct()
     */
    public function __destruct(){
        //unset($this);
    }
}
?>