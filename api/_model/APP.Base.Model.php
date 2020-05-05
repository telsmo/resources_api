<?php
/**
 * AppBaseModel, Model "base"
 *
 * The AppBaseModel Class is the "base" model to mediate between the controller and the view by applying the model. Interact with the Database
 * @author David Fernandez <fernandezdg@gmail.com>
 * @version 1.01 (10/05/2010 - 02/03/2011)
 * @package {SP MVC} Scaffolding Project - Model View Controller
 * @subpackage Controller
 */
class AppBaseModel extends AppAbstractConnectInstance{
    /**
     * $_table, name of the table to be used (it will be implemented as the name of the controller)
     * @access private
     * @var string
     */
    private $_table = '';
    /**
     * $_fields, array of existing fields in a table to be used (automatic)
     * @access private
     * @var array
     */
    private $_fields = array();
    /**
     * $_field_applied, array of existing fields in a table to be used (configured)
     * @access private
     * @var array
     */
    private $_field_applied = '';
    /**
     * $_field_applied_array, array of variables to apply
     * @access private
     * @var array
     */
    private $_field_applied_array = array();
    /**
     * $_key, Primary KEY of the row in a table
     * @access private
     * @var number
     */
    private $_key = '';
    /**
     * $_status, status field of a table
     * @access private
     * @var string
     */
    private $_status = 'status';
    /**
     * $_order, field to apply order of a table
     * @access private
     * @var string
     */
    private $_order = 'field_order';
    /**
     * $_sort, field to indicate the ASC DESC order to apply in queries
     * @access private
     * @var string
     */
    private $_sort = 'ASC';
    /**
     * $_totalRecords, record amount (pager)
     * @access private
     * @var number
     */
    private $_totalRecords;
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
    private $_pager_quantity;
    /**
     * $_pager_propagate, Array with fields to be included in the page.
     * @access private
     * @var array
     */
    // private $_pager_propagate = array();
    /**
     * $_rules, will be the set of rules to apply when a KEY is foreign
     * @access private
     * @var array
     */
    private $_rules = array();
    /**
     * $_p, instance of Propagate
     * @access private
     * @var string
     */
    private $_p;
    /**
     * $_total_records, total record amount of a table (pager)
     * @access private
     * @var number
     */
    private $_total_records = 0;
    /**
     * $_params_filter, Array with fields to be omitted in the insert
     * @access private
     * @var array
     */
    private $_params_filter	= array();
    /**
     * $_crypter, instance of the Crypt class. Used to store and retrieve the data of the session in an "encrypted" way
     * @access private
     * @var object
     */
    private $_crypter;
    /**
     * $_save_data_on_file, Indicates whether it generates a physical file with all the information
     * @access private
     * @var boolean
     */
    private $_save_data_on_file;
    /**
     * __construct function
     * @see __construct()
     * Note: Constructor sets up
     */
    /*function __construct()
    {
    }*/
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
     * setTable public function
     * @uses $table, String
     * Note: Controller = name table
     */
    public function setTable($table){
        $this->_table = $table;
    }
    /**
     * setFields public function
     * @uses $fields, Array
     * Note: Set of fields to use
     */
    public function setFields($fields){
        $this->_fields = $fields;
    }
    /**
     * setFieldApplied public function
     * @uses $field_applied, Array
     * Note: Set of specific field to use
     */
    public function setFieldApplied($field_applied){
        $this->_field_applied = $field_applied;
    }
    /**
     * setFieldAppliedArray public function
     * @uses $field_applied_array, Array
     * Note: Set of specific fields to use
     */
    public function setFieldAppliedArray($field_applied_array){
        $this->_field_applied_array = (array)$field_applied_array;
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
     * @uses $pager_page, number
     * Note: Actual page
     */
    public function setPagerPage($pager_page){
        $this->_pager_page = $pager_page;
    }
    /**
     * setPagerQuantity public function
     * @uses $pager_quantity, number
     * Note: Amount per page
     */
    public function setPagerQuantity($pager_quantity){
        $this->_pager_quantity = $pager_quantity;
    }
    /**
     * setPagerPropagate public function
     * @uses $pager_propagate, String
     * Note: Array with fields that will be included in the pagination.
     */
    // public function setPagerPropagate($pager_propagate){
    //     $this->_pager_propagate = $pager_propagate;
    // }
    /**
     * setKey public function
     * @uses $key, number
     * Note: Primary KEY of the table
     */
    public function setKey($key=''){
        $this->_key = $key;	
    }
    /**
     * setStatus public function
     * @uses $status, number
     * Note: Status field of a table (logical deletion applied)
     */
    public function setStatus($status=''){
        $this->_status = $status;
    }
    /**
     * setOrder public function
     * @uses $order, string
     * Note: Field of a table to apply order
     */
    public function setOrder($order=''){
        $this->_order = $order;
    }
    /**
     * setSort public function
     * @uses $sort, string
     * Note: Order ASC DESC to apply in consultations
     */
    public function setSort($sort=''){
        $this->_sort = $sort;
    }
    /**
     * setSaveOnFile public function
     * @uses $fields, Array
     * Note: Generate a physical file with all the information (JSON into media/_data/controller.php)
     */
    public function setSaveOnFile($variable){
        $this->_save_data_on_file = $variable;
    }
    /**
     * setTotalRecords public function
     * @uses $_total_records, String
     * Note: Quantity of records, loaded after a select type query.
     */
    private function setTotalRecords($total_records=0){
        $this->_total_records = $total_records;	
    }
    /**
     * setParamFilter public function
     * @uses $_params_filter, String
     * Note: Function that seta array with fields to be omitted in the insert.
    */
    public function setParamFilter($params_filter){
        $this->_params_filter = $params_filter;	
    }
    /**
     * setTotalRecords public function
     * @uses $_total_records, String
     * Note: Returns the number of records after a consultation
     */
    public function getTotalRecords(){
        return $this->_total_records;	
    }
    /**
     * getStructureDatabase public function
     * @uses QueryMethods, Class, Database
     * @uses setConn(), Method, Database
     * @uses getDatabaseDump(), Class
     * @uses $this->_conn, Object, Connection
     * @uses dirname(), Function
     * @uses unserialize(), Function
     * @uses PURGE_STRUCTURE_DATABASE, Constant
     * @uses CONFIG_DB_NAME, Constant
     * Note: Returns the structure of the database is the most important of the implementation of scaffolding. Everything related to the structure and meta data to solve the different views etc. etc. are inherited from the array $structure_bbddv
     */
    public function getStructureDatabase(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);

        $path = dirname(__FILE__).'/../../framework/_lib/database/structure/data.txt';

        // Is the bbdd cached?
        if(file_exists($path)){
          $estructura_bbdd = unserialize(file_get_contents($path));
          // Exist
          if( !array_key_exists(CONFIG_DB_NAME, $estructura_bbdd) ){
            // The Database does not match the one in the cache. Delete the cache database
            $estructura_bbdd = $cl->getDatabaseDump(true);
          }
        }else{ 
            // NO exist;
            $estructura_bbdd = $cl->getDatabaseDump(true);
        }
        
        return $estructura_bbdd;
    }  
    /**
     * getRecords public function
     * Note: Make Array with the list of records
     */
    public function getRecords(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setOrder($this->_order);
        $cl->setSort($this->_sort);

        $cl->setPager($this->_pager);
        $cl->setPagerUrl($this->_pager_url);
        $cl->setPagerPage($this->_pager_page);
        $cl->setPagerQuantity($this->_pager_quantity);
        // $cl->setPagerPropagate($this->_pager_propagate);

        $resultSelect = $cl->select();
        $estadoSelect = $cl->state();
        $this->setTotalRecords($cl->getTotalRecords());

        if($estadoSelect=='impact'){
            return $resultSelect;
        }else{
            return 'error';
        }
    }
    /**
     * getRecordsPaged public function
     * Note: Return array with list of record sets, filtering and paging
     */
    public function getRecordsPaged(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setOrder($this->_order);
        $cl->setSort($this->_sort);

        $cl->setPager($this->_pager);
        $cl->setPagerQuantity($this->_pager_quantity);
        $cl->setPagerPage($this->_pager_page);

        $resultSelect = $cl->select();
        $estadoSelect = $cl->state();
        $this->setTotalRecords($cl->getTotalRecords());

        if($estadoSelect=='impact'){
            return $resultSelect;
        }else{
            return 'error';
        }
    }
    /**
     * getRecordsAll public function
     * Note: Returns an array with the list of record sets, without paging. Use to know the amount of record resulting from a select.
     */
    public function getRecordsAll(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setStatus($this->_status);

        $resultSelect = $cl->selectTotalNum();
        $estadoSelect = $cl->state();

        return $resultSelect;
    }       
    /**
     * getDetail public function
     * Note: Bring information from a record
     * Use to bring extended detail from a record
     */
    public function getDetail(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setRequest($_GET);
        $cl->setFieldApplied($this->_field_applied);

        $resultDetalle = $cl->selectSingle();
        
        if($resultDetalle!='error'){
            return $resultDetalle;
        }else{
            return 'error1';
        }
    }
    public function getFilter(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setOrder($this->_order);
        $cl->setSort($this->_sort);
        $cl->setRequest($_GET);
        $cl->setFieldAppliedArray($this->_field_applied_array);

        if($this->_pager){
            $cl->setPager($this->_pager);
            $cl->setPagerQuantity($this->_pager_quantity);
            $cl->setPagerPage($this->_pager_page);
        }

        $resultFilter = $cl->filter();
        $estadoFilter = $cl->state();
        
        if($estadoFilter=='impact'){
            return $resultFilter;
        }else{
            return 'error';
        }
    }
	
    public function getPosicion(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setOrder($this->_order);
        $cl->setRequest($_GET);
        $cl->setFieldApplied($this->_field_applied);
        $cl->setFieldAppliedArray($this->_field_applied_array);

        $result = $cl->posicion();
        $estado = $cl->state();
        
        if($estado=='impact'){
            return $result;
        }else{
            return 'error';
        }
    }
    public function getSearch(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setRequest($_GET);
        $cl->setFieldAppliedArray($this->_field_applied_array);

        if($this->_pager){
            $cl->setPager($this->_pager);
            $cl->setPagerQuantity($this->_pager_quantity);
            $cl->setPagerPage($this->_pager_page);
        }

        $result = $cl->search();
        $estado = $cl->state();
        
        if($estado=='impact'){
            return $result;
        }else{
            return 'error';
        }
    }
    
    public function getTalos01(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setParamFilter($this->_params_filter);
        $cl->setRequest($_REQUEST);
        //$cl->setRules($this->_rules);
        $resultInsertar = $cl->insert();

        if($resultInsertar!='error'){
            # QUESTION IF YOU GENERATE PHYSICAL ARCHIVE
            if($this->_save_data_on_file==true){
                if(in_array('orden',$this->_fields)){
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1' order by field_order asc");
                }else if($this->_table==CONFIG_DB_PREFIX.'paises'){
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1' order by nombre asc");
                }else{
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1'");
                }

                if(!empty($data_table)){
                    $data_table_encode = json_encode($data_table);
                    $data_table_decode = json_decode($data_table_encode, true);

                    # WE CREATE FILE WITH TABLE NAME
                    $path = dirname(__FILE__).'/../../material/_data/'.$this->_table.'.php';

                    if(file_exists($path)){
                        @unlink($path);
                    }

                    $dump_fp = fopen($path,"w");

                    if($dump_fp != false){
                        fwrite($dump_fp, serialize($data_table_decode));
                        fclose($dump_fp);
                    }
                }
            }
            return $resultInsertar;
        }else{
            return 'error';
        }
    }
    
    public function getTalos02(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setRequest($_REQUEST);
        $cl->setFieldApplied($this->_field_applied);

        $resultUpdate = $cl->update();
        
        if($resultUpdate!='error')
        {
            if($this->_save_data_on_file==true)
            {
                if(in_array('orden',$this->_fields)){
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1' order by field_order asc");
                }else if($this->_table==CONFIG_DB_PREFIX.'paises'){
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1' order by nombre asc");
                }else{
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1'");
                }

                if(!empty($data_table)){
                    $data_table_encode = json_encode($data_table);
                    $data_table_decode = json_decode($data_table_encode, true);

                    $path = dirname(__FILE__).'/../../material/_data/'.$this->_table.'.php';

                    if(file_exists($path)){
                        @unlink($path);
                    }

                    $dump_fp = fopen($path,"w");

                    if($dump_fp != false){
                        fwrite($dump_fp, serialize($data_table_decode));
                        fclose($dump_fp);
                    }
                }
            }
            return $resultUpdate;
        }else{
            return 'error1';
        }
    }
    
    public function getTalos03(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setRequest($_GET);
        $cl->setFieldApplied($this->_field_applied);

        $resultUpdate = $cl->delete();

        if($resultUpdate!='error'){
            if($this->_save_data_on_file==true)
            {
                if(in_array('order',$this->_fields)){
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1' order by field_order asc");
                }else if($this->_table==CONFIG_DB_PREFIX.'paises'){
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1' order by name asc");
                }else{
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1'");
                }

                if(!empty($data_table)){
                    $data_table_encode = json_encode($data_table);
                    $data_table_decode = json_decode($data_table_encode, true);

                    $path = dirname(__FILE__).'/../../material/_data/'.$this->_table.'.php';

                    if(file_exists($path)){
                        @unlink($path);
                    }

                    $dump_fp = fopen($path,"w");

                    if($dump_fp != false){
                        fwrite($dump_fp, serialize($data_table_decode));
                        fclose($dump_fp);
                    }
                }
            }
            return $resultUpdate;
        }else{
            return 'error1';
        }
    }
    
    public function getDelete01(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setRequest($_REQUEST);
        $cl->setFieldApplied($this->_field_applied);
        //$cl->setRules($this->_rules);
        $resultDelete = $cl->delete01();

        if($resultDelete=='impact'){
            if($this->_save_data_on_file==true){
                if(in_array('orden',$this->_fields)){
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1' order by field_order asc");
                }else if($this->_table==CONFIG_DB_PREFIX.'paises'){
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1' order by nombre asc");
                }else{
                    $data_table = $this->getInjection("SELECT * FROM ".$this->_table." WHERE status='1'");
                }

                if(!empty($data_table)){
                    $data_table_encode = json_encode($data_table);
                    $data_table_decode = json_decode($data_table_encode, true);

                    $path = dirname(__FILE__).'/../../material/_data/'.$this->_table.'.php';

                    if(file_exists($path)){
                        @unlink($path);
                    }

                    $dump_fp = fopen($path,"w");

                    if($dump_fp != false){
                        fwrite($dump_fp, serialize($data_table_decode));
                        fclose($dump_fp);
                    }
                }
            }
            return $resultDelete;
        }else{
            return 'error';
        }
    }
	
    public function getInjection($query){
        if(!empty($query)){
            $cl = new QueryMethods();
            $cl->setConn($this->_conn);
            $resultSelect = $cl->injection($query);
            $estadoSelect = $cl->state();

            return $resultSelect;
        }else{
            return 'error';
        }
    }

    public function getInjectionGive($query){
        if(!empty($query)){
            $cl = new QueryMethods();
            $cl->setConn($this->_conn);
            $resultSelect = $cl->injection($query);
            $estadoSelect = $cl->state();

            return $resultSelect;
        }else{
            return 'error';
        }
    }
	
    /**
     * getFilterPaged public function
     * Note: Obtain a list of record sets filtered and paginated. Use to Filter
     */ 
    public function getFilterPaged(){
        $cl = new QueryMethods();
        $cl->setConn($this->_conn);
        $cl->setTable($this->_table);
        $cl->setFields($this->_fields);
        $cl->setKey($this->_key);
        $cl->setStatus($this->_status);
        $cl->setOrder($this->_order);
        $cl->setSort($this->_sort);
        $cl->setRequest($_GET);
        $cl->setFieldAppliedArray($this->_field_applied_array);

        /*if($this->_pager)
        {*/
                $cl->setPager($this->_pager);
                $cl->setPagerQuantity($this->_pager_quantity);
                $cl->setPagerPage($this->_pager_page);
        //}

        $resultFilter = $cl->filterPaged();
        $estadoFilter = $cl->state();

        $this->setTotalRecords($cl->getTotalRecords());

        if($estadoFilter=='impact'){
            return $resultFilter;
        }else{
            return 'error';
        }
    }
	
    public function getInjectionPaged($query){
        if(!empty($query)){
            $cl = new QueryMethods();
            $cl->setConn($this->_conn);

            if($this->_pager){
                $cl->setPager($this->_pager);
                $cl->setPagerQuantity($this->_pager_quantity);
                $cl->setPagerPage($this->_pager_page);
            }

            $resultFilter = $cl->injectionPaged($query);
            $estadoFilter = $cl->state();

            if($estadoFilter=='impact'){
                return $resultFilter;
            }else{
                return 'error';
            }
        }else{
            return 'error';
        }
    }
}
?>