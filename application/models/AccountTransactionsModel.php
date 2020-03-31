<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountTransactionsModel extends CI_Model {
    // Default constructor

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        
        $this->load->library('dbcommon');
    }
    
    function getAllAccountTransactions(){
        $accounttransactions = $this->dbcommon->getAll("accounttransactions");
        print_r($accounttransactions);
    }

    function getMonthlyReportMethodOne(){
        $sql = 'SELECT SUM(IF(month = "Jan", total, 0)) AS "Jan", SUM(IF(month = "Feb", total, 0)) AS "Feb", SUM(IF(month = "Mar", total, 0)) AS "Mar", SUM(IF(month = "Apr", total, 0)) AS "Apr", SUM(IF(month = "May", total, 0)) AS "May", SUM(IF(month = "Jun", total, 0)) AS "Jun", SUM(IF(month = "Jul", total, 0)) AS "Jul", SUM(IF(month = "Aug", total, 0)) AS "Aug", SUM(IF(month = "Sep", total, 0)) AS "Sep", SUM(IF(month = "Oct", total, 0)) AS "Oct", SUM(IF(month = "Nov", total, 0)) AS "Nov", SUM(IF(month = "Dec", total, 0)) AS "Dec", SUM(total) AS total_yearly FROM ( SELECT DATE_FORMAT(trn_date, "%b") AS month, SUM(credit) as total FROM accounttransactions WHERE trn_date <= NOW() and trn_date >= Date_add(Now(),interval - 12 month) GROUP BY DATE_FORMAT(trn_date, "%m-%Y")) as sub';

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getMonthlyReportMethodTwo(){
        $sql = "select t1.month,
            t1.md,
            coalesce(SUM(t1.amount+t2.amount), 0) AS total
            from
            (
              select DATE_FORMAT(a.trn_date,'%b') as month,
              DATE_FORMAT(a.trn_date, '%m-%Y') as md,
              '0' as  amount
              from (
                select curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as trn_date
                from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
                cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
                cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
              ) a
              where a.trn_date <= NOW() and a.trn_date >= Date_add(Now(),interval - 12 month)
              group by md
            )t1
            left join
            (
              SELECT DATE_FORMAT(trn_date, '%b') AS month, SUM(credit) as amount ,DATE_FORMAT(trn_date, '%m-%Y') as md
              FROM accounttransactions
              where trn_date <= NOW() and trn_date >= Date_add(Now(),interval - 12 month)
              GROUP BY md
            )t2
            on t2.md = t1.md 
            group by t1.md
            order by t1.md";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    function getTotalByDate($date){
        $sql = "SELECT SUM(credit) as total FROM `accounttransactions` WHERE trn_date LIKE '%".$date."%' GROUP BY trn_date";
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }

    function allTimeTotal(){
        $sql = "SELECT SUM(credit) as total FROM accounttransactions";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }

    function monthlyTotal(){
        $sql = "SELECT SUM(credit) as total FROM accounttransactions GROUP BY MONTH(trn_date)";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }

    function yearlyTotal(){
        $sql = "SELECT SUM(credit) as total FROM accounttransactions GROUP BY YEAR(trn_date)";

        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }

    function getDaysTotal($days){
        $sql = "SELECT SUM(credit) as total FROM `accounttransactions` WHERE trn_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ".$days." DAY) GROUP BY trn_date";
        //Execute query on db and get result
        $query = $this->db->query($sql)->result();
        //print_r($query);
        if(!empty($query)){
            return $query[0]->total;
        }else{
            return false;
        }
    }

    function insertIntoAccountTransactions($aTransaction) {
        if($this->dbcommon->insertIntoTable("accounttransactions", $aTransaction)){
            return true;
        }else{
            return false;
        }
        
    }
}