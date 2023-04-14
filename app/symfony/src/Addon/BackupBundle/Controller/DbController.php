<?php

namespace Addon\BackupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\DriverManager;

class DbController extends Controller
{
    const BOUNDARY = ";";
    const PASS_HASH = "21232f297a57a5a743894a0e4a801fc3"; //pass: admin
    /**
    * Controller for route /dbcreate/{name}
    * execute SQL querys from file (file should be located in /web )
    * @param string $name name of file with database dump 
    **/
    public function dbcreateAction($name)
    {
        $name;
        echo ($this->dbFill($name))? 'Success' : 'Fail';
        exit();
    }//end func
    
   /**
    * create database dump
    * @param string $name filename database dump, will be create in web directory
    **/
   public function dbdumpAction($name){
        $res = $this->dbDump($name);
        echo ($res)? 'Success' : 'Fail';
        exit();
   }//end func
   
   /**
    * Show db create form 
    * @param string $pass Password for safe
    **/
   public function dbcreateformAction($pass){
       if ($this->getHash($pass) != self::PASS_HASH){
            return $this->redirect($this->generateUrl('cinema_cinema_homepage'));
       } 
       
       return $this->render('AddonBackupBundle:Db:dbcreate_form.html.twig');
        
   }//end func
   
    /**
    * Show db create form 
    * @param string $pass Password for safe
    **/
   public function dbdumpformAction($pass){
       if ($this->getHash($pass) != self::PASS_HASH){
            return $this->redirect($this->generateUrl('cinema_cinema_homepage'));
       } 
       
       return $this->render('AddonBackupBundle:Db:dbdump_form.html.twig');
        
   }//end func
   
   
   public function dumpcreateAction(){
       $fn = 'dump';
       $request = $this->get('request');
       $filename = $request->request->get($fn);
       if ($this->dbDump($filename)){
            return $this->render('AddonBackupBundle:Db:dbdump_success.html.twig', array('link'=>$filename));
       }else{
            return $this->render('AddonBackupBundle:Db:dbdump_fail.html.twig');
       } 
   }
   
   
   /**
    * execute SQL query
    * @param string $sql SQL query 
    **/
   protected function query($sql)
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        return $conn->executeQuery($sql);
    }//end func
    
    
    protected function fetchArray($res){
        $arr = array();
        if (get_class($res) == 'Doctrine\DBAL\Driver\PDOStatement'){
            while ($row = $res->fetch()) {
                $arr[] = $row;
            }
        }
        return $arr;
    }//end func
    
    /**
     * create database dump
     **/
    protected function dbDump( $fullFilenameDb )
    {
        $dumpDemo = '';
        $dumpDb = "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO'". self::BOUNDARY ."\n";
        $dumpDb .= "SET time_zone = '+00:00'". self::BOUNDARY ."\n";
        $dumpDb .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */". self::BOUNDARY ."\n";
        $dumpDb .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */". self::BOUNDARY ."\n";
        $dumpDb .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */". self::BOUNDARY ."\n";
        $dumpDb .= "/*!40101 SET NAMES utf8 */".  self::BOUNDARY ."\n\n";

        $tables = array();
        $sql = 'SHOW TABLES';
        $result = $this->fetchArray($this->query($sql));
        if ( is_array( $result ) && count( $result ) )
        {
            foreach( $result as $row )
            {
                
                foreach( $row as $key=>$value )
                {
                    $tables[] = $row[$key];
                }
            }
        }
        
        foreach( $tables as $table )
        {
            $sql = "SHOW CREATE TABLE $table";
            $result = $this->fetchArray($this->query($sql));
            //print_r($result);exit(); 
            foreach( $result as $row )
            {
                $dumpDb .= 'DROP TABLE IF EXISTS `' . $row['Table'] . "`" . self::BOUNDARY . "\n\n";
                $dumpDb .= $row['Create Table'] . self::BOUNDARY . "\n\n";    
            }
            
            
            $sql = '/*!40101 SET NAMES utf8 */';
            $this->query( $sql );
            $sql = 'SELECT * FROM `' . $table . '`';
            
            $tableData = $this->fetchArray($this->query($sql));
            if ( is_array( $tableData ) &&  count( $tableData ) )
            {
                
                $dumpDemo .= 'INSERT INTO `' . $table . '` (';
                $numFields = count( $tableData[0] );
                $count = 0;
                foreach( $tableData[0] as $field => $value )
                {
                    $count++;
                    $dumpDemo .= '`' . $field . '`';
                    if ( $count < $numFields ) 
                    {
                        $dumpDemo .= ', ';
                    }
                }
                $dumpDemo .= ") VALUES ";
                    
                $numRows = count( $tableData );
                $countRows = 0;
                foreach( $tableData as $tableRow )
                {
                    $dumpDemo .= '(';
                    $count = 0;
                    $countRows++;
        
                    foreach( $tableRow as $fieldName => $fieldValue )
                    {
                        $sql = "DESCRIBE $table $fieldName";
                        
                        $fieldDesc = $this->fetchArray($this->query($sql));
                        if ( !isset( $fieldDesc[0]['Default'] ) )
                        {
                            $default = "''";
                        }
                        else
                        {
                            $default = $fieldDesc[0]['Default'];
                        } 
                        if ( $default == '' ) $default = "''";
                        $count++;
                        if ( !empty( $fieldValue ) )
                        {
                            $fieldValue = addslashes( $fieldValue );
                            $dumpDemo .= "'" . $fieldValue . "'";   
                        }
                        else
                        {
                            $dumpDemo .= $default;
                        }
                        if ( $count <  $numFields )
                        {
                            $dumpDemo .= ", ";
                        }
                    }
                    $dumpDemo .= ")";
                    if ( $countRows < $numRows )
                    {
                        $dumpDemo .= ",\n";
                    }
                    else
                    {
                        $dumpDemo .= self::BOUNDARY . "\n\n";
                    }
                } 
            }    
        }
        
        $dump = $dumpDb . "\n\n" . $dumpDemo;
        $writenDb =  file_put_contents( $fullFilenameDb, $dump );
        return ( $writenDb ) ? true : false;
    }//end func

    protected function dbFill($name){
        if (!file_exists($name)) return false;
        $f = fopen( $name, "r" );
        if ( !$f ) return false; 
        
        $dump = '';
        
        while( !feof($f) )
        {
            $line = fgets($f, 4096 );
            if ( $line{0} == '-' && $line{1} == '-' ) continue;
            if ( ($line == '' ) ) continue;
            $dump .= $line;
        }
        //echo $dump;
        
        $commands = explode(";\n",$dump);
        foreach($commands as $command )
        {
            $command = trim( $command );
            if ( $command != '' ) $this->query($command);
        }
        return true;
    }//end func

    /**
     * get hash input string
     * @param string $str input string
     * @return string Hash of string
     **/
    protected function getHash($str){
        return md5($str);
    }//end func
    
    /**
     * upload dump file and fill data into database from it 
     **/
    public function dumpuploadAction(){
        $fn = 'dump';
        if ($_FILES[$fn]['error'] == 0){
            $tmp_file = $_FILES[$fn]['tmp_name'];
            if ($this->dbFill($tmp_file)){
                return $this->render('AddonBackupBundle:Db:db_create_success.html.twig');
            }
        }
        return $this->render('AddonBackupBundle:Db:db_create_fail.html.twig');
    }//end func
}