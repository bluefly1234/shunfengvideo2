<?php
set_time_limit(0);
function DATA_ExecSelect( $sql_stmt, $rep=false )
{
    include dirname(__FILE__)."/config_data.php";
    $ret[0]=null;
    $link=mysql_connect($db_host, $db_user, $db_pass ) or die("Connect Mysql ERROR: ".@mysql_error());
    if ($link)
    {
		
		if ($rep){
	    	$sql_stmt = mysql_real_escape_string($sql_stmt , $link);
		}
        $db_table = mysql_select_db( $db_name, $link);
        mysql_query("set names utf8");
        if ($db_table)
        {
            $result = mysql_query($sql_stmt);
            if ($result != false)
            {
                $row = mysql_fetch_row($result);
                $line = 0;
                $fieldsnum = mysql_num_fields($result);
                while( $row != false )
                {
                    $tmp=0;
                    while($tmp < $fieldsnum)
                    {
                        $ret[$line*$fieldsnum+$tmp] = $row[$tmp];
                        $tmp=$tmp+1;
                    }
                    $line=$line+1;
                    $row = mysql_fetch_row($result);
                }
                mysql_free_result($result);
                return $ret;
            }
            else
            {
                echo mysql_error();
                return $ret;
            }
            mysql_close($link);
        }   
    }
    return $ret;
}

function DATA_ExecSelect2Array( $sql_stmt )
{
    include dirname(__FILE__)."/config_data.php";
    $ret = array();
    $link=mysql_connect($db_host, $db_user, $db_pass ) or die("Connect Mysql ERROR: ".@mysql_error());
    if ($link)
    {
        $db_table = mysql_select_db( $db_name, $link);
        mysql_query("set names utf8");
        if ($db_table)
        {
            $result = mysql_query($sql_stmt);
            if ($result != false)
            {
                $line = 0;
                $fieldsnum = mysql_num_fields($result);
                while( ($row = mysql_fetch_row($result)) != false )
                {
					array_push($ret, $row);
                }
                mysql_free_result($result);
                return $ret;
            }
            else
            {
                echo mysql_error();
                return $ret;
            }
            mysql_close($link);
        }   
    }
    return $ret;
}

function DATA_ExecSelectOne( $sql_stmt )
{
    include dirname(__FILE__)."/config_data.php";
    $ret=null;
    $link=mysql_connect($db_host, $db_user, $db_pass ) or die("Connect Mysql ERROR: ".@mysql_error());
    if ($link)
    {
        $db_table = mysql_select_db( $db_name, $link);
        mysql_query("set names utf8");
        if ($db_table)
        {
            $result = mysql_query($sql_stmt);
            if ($result != false)
            {
                //$ret=array();
                $ret = mysql_fetch_array($result);
                mysql_free_result($result);
                return $ret;
            }
            else
            {
                echo mysql_error();
                return $ret;
            }
            mysql_close($link);
        }   
    }
    return $ret;
}


function DATA_ExecSql( $sql_stmt )
{
    include dirname(__FILE__)."/config_data.php";
    $link=@mysql_connect($db_host, $db_user, $db_pass ) or die("Connect Mysql ERROR: ".@mysql_error());
    if ($link)
    {
        $db_table = @mysql_select_db( $db_name, $link);
        @mysql_query("set names utf8");
        if ($db_table)
        {
            $sql = @mysql_query($sql_stmt);
            @mysql_close($link);
            return $sql;
        }   
    }
    return 0;
}

function DATA_ExecSqlNeedEff( $sql_stmt )
{
    include dirname(__FILE__)."/config_data.php";
    $link=@mysql_connect($db_host, $db_user, $db_pass ) or die("Connect Mysql ERROR: ".@mysql_error());
    if ($link)
    {
        $db_table = @mysql_select_db( $db_name, $link);
        @mysql_query("set names utf8");
        if ($db_table)
        {
            $sql = @mysql_query($sql_stmt);
            $ret=mysql_affected_rows();
            @mysql_close($link);
            return $ret;
        }   
    }
    return -1;
}   

function DATA_ExecSqlNeedInc( $sql_stmt )
{
    include dirname(__FILE__)."/config_data.php";
    $ret=0;
    $link=mysql_connect($db_host, $db_user, $db_pass ) or die("Connect Mysql ERROR: ".mysql_error());
    if ($link)
    {
        $db_table = mysql_select_db( $db_name, $link);
        mysql_query("set names utf8");
        if ($db_table)
        {
            $sql = mysql_query($sql_stmt);
            $ret=mysql_insert_id();
            mysql_close($link);
            return $ret;
        }   
    }
    return $ret;
}


function DATA_ExecSqlNeedInc_Local($db_host, $db_user, $db_pass, $db_name, $sql_stmt )
{
    $ret=0;
    $link=mysql_connect($db_host, $db_user, $db_pass ) or die("Connect Mysql ERROR: ".mysql_error());
    if ($link)
    {
        $db_table = mysql_select_db( $db_name, $link);
        mysql_query("set names utf8");
        if ($db_table)
        {
            $sql = mysql_query($sql_stmt);
            $ret=mysql_insert_id();
            mysql_close($link);
            return $ret;
        }   
    }
    return $ret;
}


function DATA_ExecSql_Local( $db_host, $db_user, $db_pass, $db_name, $sql_stmt )
{
    $link=@mysql_connect($db_host, $db_user, $db_pass ) or die("Connect Mysql ERROR: ".@mysql_error());
    if ($link)
    {
        $db_table = @mysql_select_db( $db_name, $link);
        @mysql_query("set names utf8");
        if ($db_table)
        {
            $sql = @mysql_query($sql_stmt);
            @mysql_close($link);
            return $sql;
        }   
    }
    return 0;
}
function DATA_getip(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"]))
	   $cip = $_SERVER["HTTP_CLIENT_IP"];
	else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
	   $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	else if(!empty($_SERVER["REMOTE_ADDR"]))
	   $cip = $_SERVER["REMOTE_ADDR"];
	else
	   $cip = "";
	return $cip;
}

function DATA_getID($safe){
	return substr($safe,0,1).($safe%100000);	
}

?>
