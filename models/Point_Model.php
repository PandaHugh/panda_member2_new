<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Point_Model extends CI_Model
{
  
    public function __construct()
    {
        parent::__construct();
    }

     public function date()
    {
        $date = $this->db->query("SELECT CURDATE() as curdate")->row('curdate');
        return $date;
    }

    public function datetime()
    {
        $datetime = $this->db->query("SELECT NOW() as datetime")->row('datetime');
        return $datetime;
    }

    public function guid()
    {
        $guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') as guid")->row('guid');
        return $guid;
    }



    public function check_parameter()
    {
        $query = $this->db->query("SELECT * FROM `set_parameter`");
        return $query; 
    }

    public function get_point_auto_expiry_trans_ref_no()
    {
        $result = $this->db->query("SELECT CONCAT('PAE',SUBSTRING(REPLACE(CURDATE(),'-',''),-8),a.run_no) AS ref_no 
            FROM (SELECT IFNULL(MAX(LPAD(RIGHT(REF_NO,'7')+1,'7',0)),LPAD(1,'7',0)) AS run_no 
                FROM `trans_main` a WHERE a.`TRANS_TYPE` = 'POINT_ADJ_OUT' AND LEFT(a.`REF_NO`,3) = 'PAE' 
                AND SUBSTRING(REF_NO,-13,6) = SUBSTRING(REPLACE(CURDATE(),'-',''),-6,6))a");
        return $result;
    }

    function get_cut_off_point_expiry_date()
    {
        $cut_off_month = $this->check_parameter()->row('point_expiry_period');
        $interval_month = $this->check_parameter()->row('point_expiry_month');

        $trigger_hour = $this->check_parameter()->row('auto_point_expiry_run_hour');

        $query = $this->db->query("SELECT CONCAT(DATE_FORMAT(CONCAT(YEAR(CURRENT_TIMESTAMP),'-',MONTH(CONCAT( YEAR(CURRENT_TIMESTAMP), '-', '$cut_off_month', '-01' ) ),'-', DAY( LAST_DAY( CONCAT( YEAR(CURRENT_TIMESTAMP), '-', '$cut_off_month', '-01' ) ) ) ), '%Y-%m-%d' ), ' ', '$trigger_hour' ) AS cut_off_date ;");

        $result = array(
            'cut_off_datetime' => $query->row('cut_off_date'),
            'cut_off_date' => $this->db->query("SELECT DATE('".$query->row('cut_off_date')."') AS cut_off_date;")->row('cut_off_date'),
            'end_period' => $this->db->query("SELECT LEFT(DATE_SUB(DATE('".$query->row('cut_off_date')."'), INTERVAL $interval_month MONTH),7) AS end_period;")->row('end_period'),
        );
        return $result;

        /*        $query = $this->db->query("SELECT 
          CONCAT(
            DATE_FORMAT(
              CONCAT(
                YEAR(CURRENT_TIMESTAMP),
                '-',
                MONTH(
                  DATE_SUB(
                    CONCAT(
                      YEAR(CURRENT_TIMESTAMP),
                      '-',
                      '11',
                      '-01'
                    ),
                    INTERVAL 3 MONTH
                  )
                ),
                '-',
                DAY(
                  LAST_DAY(
                    DATE_SUB(
                      CONCAT(
                        YEAR(CURRENT_TIMESTAMP),
                        '-',
                        '11',
                        '-01'
                      ),
                      INTERVAL 3 MONTH
                    )
                  )
                )
              ),
              '%Y-%m-%d'
            ),
            ' ',
            '$trigger_hour'
          ) AS cut_off_date ");*/

    }

    function get_point_expiry_trans($final_end_period)
    {
        $query = $this->db->query("
                                SELECT 
                          *,
                          point_earn + total_adj_in + total_merchant_point AS point_expiry,
                          Pointsbalance - (
                            point_earn + total_adj_in + total_merchant_point
                          ) AS total_after_expiry 
                        FROM
                          (SELECT 
                            a.`AccountNo`,
                            a.`Name`,
                            a.`Pointsbalance`,
                            a1.point_earn,
                            IF(
                              a2.total_adj_in IS NULL,
                              '0',
                              a2.total_adj_in
                            ) AS total_adj_in,
                            IF(
                              a3.total_merchant_point IS NULL,
                              '0',
                              a3.total_merchant_point
                            ) AS total_merchant_point 
                          FROM
                            `member` a 
                            INNER JOIN
                              (SELECT 
                                SUM(a.`Points`) AS point_earn,
                                a.`AccountNo` 
                              FROM
                                `points_movement` a 
                              WHERE a.periodcode <= '$final_end_period' 
                              GROUP BY a.`AccountNo`) a1 
                              ON a1.AccountNo = a.`AccountNo` 
                            LEFT JOIN
                              (SELECT 
                                SUM(a.`VALUE_TOTAL`) AS total_adj_in,
                                a.`SUP_CODE` AS accountno,
                                a.`SUP_NAME`,
                                a.`TRANS_DATE` 
                              FROM
                                `trans_main` a 
                              WHERE a.`TRANS_TYPE` = 'POINT_ADJ_IN' 
                                AND LEFT(a.`TRANS_DATE`, 7) <= '$final_end_period' 
                              GROUP BY a.`SUP_CODE`) a2 
                              ON a2.accountno = a.`AccountNo` 
                            LEFT JOIN
                              (SELECT 
                                ROUND(SUM(a.`POINT_TOTAL`)) AS total_merchant_point,
                                a.`AccountNo` 
                              FROM
                                `mem_trans_c` a 
                              WHERE LEFT(DATE(a.`CREATED_AT`), 7) <= '$final_end_period' 
                                AND a.`TRANS_TYPE` = 'ADJ-IN' 
                              GROUP BY a.`AccountNo`) a3 
                              ON a3.AccountNo = a.AccountNo) aa  
                        WHERE Pointsbalance - (
                            point_earn + total_adj_in + total_merchant_point
                          ) > 0 
                          ORDER BY aa.point_earn DESC 
                          LIMIT 2000
                    ");
        return $query;
    }

    function get_point_expiry_by_account($final_end_period,$accountno)
    {
        // $query = $this->db->query("
        //                         SELECT 
        //                   *,
        //                   point_earn + total_adj_in + total_merchant_point AS point_expiry,
        //                   Pointsbalance - (
        //                     point_earn + total_adj_in + total_merchant_point
        //                   ) AS total_after_expiry 
        //                 FROM
        //                   (SELECT 
        //                     a.`AccountNo`,
        //                     a.`Name`,
        //                     a.`Pointsbalance`,
        //                     a1.point_earn,
        //                     IF(
        //                       a2.total_adj_in IS NULL,
        //                       '0',
        //                       a2.total_adj_in
        //                     ) AS total_adj_in,
        //                     IF(
        //                       a3.total_merchant_point IS NULL,
        //                       '0',
        //                       a3.total_merchant_point
        //                     ) AS total_merchant_point 
        //                   FROM
        //                     `member` a 
        //                     INNER JOIN
        //                       (SELECT 
        //                         SUM(a.`Points`) AS point_earn,
        //                         a.`AccountNo` 
        //                       FROM
        //                         `points_movement` a 
        //                       WHERE a.periodcode <= '$final_end_period' 
        //                       GROUP BY a.`AccountNo`) a1 
        //                       ON a1.AccountNo = a.`AccountNo` 
        //                     LEFT JOIN
        //                       (SELECT 
        //                         SUM(a.`VALUE_TOTAL`) AS total_adj_in,
        //                         a.`SUP_CODE` AS accountno,
        //                         a.`SUP_NAME`,
        //                         a.`TRANS_DATE` 
        //                       FROM
        //                         `trans_main` a 
        //                       WHERE a.`TRANS_TYPE` = 'POINT_ADJ_IN' 
        //                         AND LEFT(a.`TRANS_DATE`, 7) <= '$final_end_period' 
        //                       GROUP BY a.`SUP_CODE`) a2 
        //                       ON a2.accountno = a.`AccountNo` 
        //                     LEFT JOIN
        //                       (SELECT 
        //                         ROUND(SUM(a.`POINT_TOTAL`)) AS total_merchant_point,
        //                         a.`AccountNo` 
        //                       FROM
        //                         `mem_trans_c` a 
        //                       WHERE LEFT(DATE(a.`CREATED_AT`), 7) <= '$final_end_period' 
        //                         AND a.`TRANS_TYPE` = 'ADJ-IN' 
        //                       GROUP BY a.`AccountNo`) a3 
        //                       ON a3.AccountNo = a.AccountNo) aa  
        //                 WHERE Pointsbalance - (
        //                     point_earn + total_adj_in + total_merchant_point
        //                   ) > 0 
        //                   AND aa.accountno = '$accountno'
        //             ");

        $query = $this->db->query("
              SELECT 
                *,
                point_earn + total_adj_in + total_merchant_point AS point_expiry,
                Pointsbalance - (
                  point_earn + total_adj_in + total_merchant_point
                ) AS total_after_expiry 
              FROM
                (SELECT 
                  a.`AccountNo`,
                  a.`Name`,
                  a.`Pointsbalance`,
                  a1.point_earn,
                  IF(
                    a2.total_adj_in IS NULL,
                    '0',
                    a2.total_adj_in
                  ) AS total_adj_in,
                  IF(
                    a3.total_merchant_point IS NULL,
                    '0',
                    a3.total_merchant_point
                  ) AS total_merchant_point 
                FROM
                  (
                SELECT AccountNo, `Name`, Pointsbalance FROM `member` 
                WHERE accountno = '$accountno'
                ) a 
                  INNER JOIN
                    (SELECT 
                SUM(a.`Points`) AS point_earn,
                a.`AccountNo` 
                    FROM
                `points_movement` a 
                    WHERE a.periodcode <= '$final_end_period' AND accountno = '$accountno'
                    GROUP BY a.`AccountNo`) a1 
                    ON a1.AccountNo = a.`AccountNo` 
                  LEFT JOIN
                    (SELECT 
                SUM(a.`VALUE_TOTAL`) AS total_adj_in,
                a.`SUP_CODE` AS accountno,
                a.`SUP_NAME`,
                a.`TRANS_DATE` 
                    FROM
                `trans_main` a 
                    WHERE a.`TRANS_TYPE` = 'POINT_ADJ_IN' 
                AND LEFT(a.`TRANS_DATE`, 7) <= '$final_end_period' 
                AND a.SUP_CODE = '$accountno'
                    GROUP BY a.`SUP_CODE`) a2 
                    ON a2.accountno = a.`AccountNo` 
                  LEFT JOIN
                    (SELECT 
                ROUND(SUM(a.`POINT_TOTAL`)) AS total_merchant_point,
                a.`AccountNo` 
                    FROM
                `mem_trans_c` a 
                    WHERE LEFT(DATE(a.`CREATED_AT`), 7) <= '$final_end_period' 
                AND a.`TRANS_TYPE` = 'ADJ-IN' 
                AND a.AccountNo = '$accountno'
                    GROUP BY a.`AccountNo`) a3 
                    ON a3.AccountNo = a.AccountNo) aa  
              WHERE Pointsbalance - (
                  point_earn + total_adj_in + total_merchant_point
                ) > 0 
                AND aa.accountno = '$accountno'
          ");
        return $query;
    }

    public function count_main_in_out($column)
    {
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', 0); 
      ini_set('memory_limit','2048M');

      if($column == 'POINT_REDEEM')
      {
          $count_trans_main = $this->db->query("SELECT COUNT(c.TRANS_GUID) AS count_row FROM (SELECT ITEM_CODE FROM mem_item WHERE ITEM_TYPE = 'REDEEM' AND isVoucher = '1') AS a INNER JOIN (SELECT ITEMCODE, TRANS_GUID FROM trans_child) AS b ON a.ITEM_CODE = b.ITEMCODE INNER JOIN (SELECT TRANS_GUID FROM trans_main WHERE TRANS_TYPE = 'POINT_REDEEM') AS c ON b.TRANS_GUID = c.TRANS_GUID");
      }
      elseif($column == 'ITEM_REDEEM')
      {
          $count_trans_main = $this->db->query("SELECT COUNT(c.TRANS_GUID) AS count_row FROM (SELECT ITEM_CODE FROM mem_item WHERE ITEM_TYPE = 'REDEEM' AND isVoucher = '0') AS a INNER JOIN (SELECT ITEMCODE, TRANS_GUID FROM trans_child) AS b ON a.ITEM_CODE = b.ITEMCODE INNER JOIN (SELECT TRANS_GUID FROM trans_main WHERE TRANS_TYPE = 'POINT_REDEEM') AS c ON b.TRANS_GUID = c.TRANS_GUID");
      }
      elseif($column == 'POINT_ADJ_IN')
      {
          $count_trans_main = $this->db->query("SELECT COUNT(*) AS count_row FROM(
            SELECT TRANS_GUID FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ_IN' GROUP BY TRANS_GUID
            UNION ALL
            SELECT TRANS_GUID FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ' AND VALUE_TOTAL > 0 GROUP BY TRANS_GUID) AS a");
      }
      elseif($column == 'POINT_ADJ_OUT')
      {
          $count_trans_main = $this->db->query("SELECT COUNT(*) AS count_row FROM(
            SELECT TRANS_GUID FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ_OUT' GROUP BY TRANS_GUID
            UNION ALL
            SELECT TRANS_GUID FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ' AND VALUE_TOTAL < 0 GROUP BY TRANS_GUID) AS a");
      }
      elseif($column == 'REDEEM_CASH')
      {
          $count_trans_main = $this->db->query("SELECT COUNT(TRANS_GUID) AS count_row FROM `trans_main` a WHERE a.`TRANS_TYPE` = 'POINT_REDEEM' AND LEFT(a.`REF_NO`,3) = 'RDC' AND a.`reason` = 'CASH'");
      }
      else
      {
          $count_trans_main = $this->db->query("SELECT COUNT(TRANS_GUID) AS count_row FROM trans_main WHERE TRANS_TYPE = '$column'");
      }

      return $count_trans_main->row('count_row');
    }

    public function main_in_out_list($column, $limit, $start, $order, $dir)
    {
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', 0); 
      ini_set('memory_limit','2048M');

      if($column == 'POINT_REDEEM')
      {
          $trans_main = $this->db->query("SELECT c.* FROM mem_item a INNER JOIN trans_child b ON a.ITEM_CODE = b.ITEMCODE INNER JOIN trans_main c ON b.TRANS_GUID = c.TRANS_GUID WHERE a.ITEM_TYPE = 'REDEEM' AND a.isVoucher = '1' AND TRANS_TYPE = 'POINT_REDEEM' GROUP BY TRANS_GUID ORDER BY $order $dir LIMIT $start, $limit");
      }
      elseif($column == 'ITEM_REDEEM')
      {
          $trans_main = $this->db->query("SELECT c.* FROM mem_item a INNER JOIN trans_child b ON a.ITEM_CODE = b.ITEMCODE INNER JOIN trans_main c ON b.TRANS_GUID = c.TRANS_GUID WHERE a.ITEM_TYPE = 'REDEEM' AND a.isVoucher = '0' AND TRANS_TYPE = 'POINT_REDEEM' GROUP BY TRANS_GUID order by $order $dir LIMIT $start, $limit");
      }
      elseif($column == 'POINT_ADJ_IN')
      {
          $trans_main = $this->db->query("SELECT * FROM(
              SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ_IN' GROUP BY TRANS_GUID
              UNION ALL
              SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ' AND VALUE_TOTAL > 0 GROUP BY TRANS_GUID) AS a
              ORDER BY $order $dir LIMIT $start, $limit");
      }
      elseif($column == 'POINT_ADJ_OUT')
      {
          $trans_main = $this->db->query("SELECT * FROM(
              SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ_OUT' GROUP BY TRANS_GUID
              UNION ALL
              SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ' AND VALUE_TOTAL < 0 GROUP BY TRANS_GUID) AS a
              ORDER BY $order $dir LIMIT $start, $limit");
      }
      elseif($column == 'REDEEM_CASH')
      {
          $trans_main = $this->db->query("SELECT * FROM `trans_main` a WHERE a.`TRANS_TYPE` = 'POINT_REDEEM' AND LEFT(a.`REF_NO`,3) = 'RDC' AND a.`reason` = 'CASH' ORDER BY $order $dir LIMIT $start, $limit");
      }
      else
      {
          $trans_main = $this->db->query("SELECT * from trans_main where TRANS_TYPE = '$column' GROUP BY TRANS_GUID ORDER BY $order $dir LIMIT $start, $limit");
      }

      return $trans_main;
    }

    public function search_main_in_out_list($column, $limit, $start, $order, $dir, $search)
    {
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', 0); 
      ini_set('memory_limit','2048M');

      if($column == 'POINT_REDEEM')
      {
          $trans_main = $this->db->query("SELECT c.* FROM mem_item a INNER JOIN trans_child b ON a.ITEM_CODE = b.ITEMCODE INNER JOIN trans_main c ON b.TRANS_GUID = c.TRANS_GUID WHERE a.ITEM_TYPE = 'REDEEM' AND a.isVoucher = '1' AND TRANS_TYPE = 'POINT_REDEEM' AND (c.POSTED LIKE '%$search%' OR c.REF_NO LIKE '%$search%' OR c.TRANS_DATE LIKE '%$search%' OR c.SUP_CODE LIKE '%$search%' OR c.SUP_NAME LIKE '%$search%' OR c.VALUE_TOTAL LIKE '%$search%' OR c.REMARK LIKE '%$search%' OR c.CREATED_AT LIKE '%$search%' OR c.CREATED_BY LIKE '%$search%' OR c.UPDATED_AT LIKE '%$search%' OR c.UPDATED_BY LIKE '%$search%') GROUP BY TRANS_GUID ORDER BY $order $dir LIMIT $start, $limit");
      }
      elseif($column == 'ITEM_REDEEM')
      {
          $trans_main = $this->db->query("SELECT c.* FROM mem_item a INNER JOIN trans_child b ON a.ITEM_CODE = b.ITEMCODE INNER JOIN trans_main c ON b.TRANS_GUID = c.TRANS_GUID WHERE a.ITEM_TYPE = 'REDEEM' AND a.isVoucher = '0' AND TRANS_TYPE = 'POINT_REDEEM' AND (c.POSTED LIKE '%$search%' OR c.REF_NO LIKE '%$search%' OR c.TRANS_DATE LIKE '%$search%' OR c.SUP_CODE LIKE '%$search%' OR c.SUP_NAME LIKE '%$search%' OR c.VALUE_TOTAL LIKE '%$search%' OR c.REMARK LIKE '%$search%' OR c.CREATED_AT LIKE '%$search%' OR c.CREATED_BY LIKE '%$search%' OR c.UPDATED_AT LIKE '%$search%' OR c.UPDATED_BY LIKE '%$search%') GROUP BY TRANS_GUID ORDER BY $order $dir LIMIT $start, $limit");
      }
      elseif($column == 'POINT_ADJ_IN')
      {
          $trans_main = $this->db->query("SELECT * FROM(
              SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ_IN' GROUP BY TRANS_GUID
              UNION ALL
              SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ' AND VALUE_TOTAL > 0 GROUP BY TRANS_GUID) AS a
              WHERE (POSTED LIKE '%$search%' OR REF_NO LIKE '%$search%' OR TRANS_DATE LIKE '%$search%' OR SUP_CODE LIKE '%$search%' OR SUP_NAME LIKE '%$search%' OR VALUE_TOTAL LIKE '%$search%' OR REMARK LIKE '%$search%' OR CREATED_AT LIKE '%$search%' OR CREATED_BY LIKE '%$search%' OR UPDATED_AT LIKE '%$search%' OR UPDATED_BY LIKE '%$search%') GROUP BY TRANS_GUID ORDER BY $order $dir LIMIT $start, $limit");
      }
      elseif($column == 'POINT_ADJ_OUT')
      {
          $trans_main = $this->db->query("SELECT * FROM(
              SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ_OUT' GROUP BY TRANS_GUID
              UNION ALL
              SELECT * FROM trans_main WHERE TRANS_TYPE = 'POINT_ADJ' AND VALUE_TOTAL < 0 GROUP BY TRANS_GUID) AS a
              WHERE (POSTED LIKE '%$search%' OR REF_NO LIKE '%$search%' OR TRANS_DATE LIKE '%$search%' OR SUP_CODE LIKE '%$search%' OR SUP_NAME LIKE '%$search%' OR VALUE_TOTAL LIKE '%$search%' OR REMARK LIKE '%$search%' OR CREATED_AT LIKE '%$search%' OR CREATED_BY LIKE '%$search%' OR UPDATED_AT LIKE '%$search%' OR UPDATED_BY LIKE '%$search%') GROUP BY TRANS_GUID ORDER BY $order $dir LIMIT $start, $limit");
      }
      elseif($column == 'REDEEM_CASH')
      {
          $trans_main = $this->db->query("SELECT * FROM `trans_main` a WHERE a.`TRANS_TYPE` = 'POINT_REDEEM' AND LEFT(a.`REF_NO`,3) = 'RDC' AND a.`reason` = 'CASH' AND (POSTED LIKE '%$search%' OR REF_NO LIKE '%$search%' OR TRANS_DATE LIKE '%$search%' OR SUP_CODE LIKE '%$search%' OR SUP_NAME LIKE '%$search%' OR VALUE_TOTAL LIKE '%$search%' OR REMARK LIKE '%$search%' OR CREATED_AT LIKE '%$search%' OR CREATED_BY LIKE '%$search%' OR UPDATED_AT LIKE '%$search%' OR UPDATED_BY LIKE '%$search%') GROUP BY TRANS_GUID ORDER BY $order $dir LIMIT $start, $limit;");
      }
      else
      {
          $trans_main = $this->db->query("SELECT * from trans_main where TRANS_TYPE = '$column' AND (POSTED LIKE '%$search%' OR REF_NO LIKE '%$search%' OR TRANS_DATE LIKE '%$search%' OR SUP_CODE LIKE '%$search%' OR SUP_NAME LIKE '%$search%' OR VALUE_TOTAL LIKE '%$search%' OR REMARK LIKE '%$search%' OR CREATED_AT LIKE '%$search%' OR CREATED_BY LIKE '%$search%' OR UPDATED_AT LIKE '%$search%' OR UPDATED_BY LIKE '%$search%') GROUP BY TRANS_GUID ORDER BY $order $dir LIMIT $start, $limit");
      }

      return $trans_main;
    }

    public function recalc_point($accountno)
    {
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', 0); 
      ini_set('memory_limit','2048M');

      $this->db->query("SET @created_at = NOW()");
      $this->db->query("SET @EPeriod = (SELECT LEFT(date(@created_at), 7) AS created_period)");
      $this->db->query("SET @EDateFrom = (SELECT DATE_ADD(DATE_ADD(LAST_DAY(DATE(@created_at)),INTERVAL 1 DAY),INTERVAL - 1 MONTH) AS date_from)");
      $this->db->query("SET @EDateTo = (SELECT LAST_DAY(@created_at) AS date_to)");
      $this->db->query("SET @ELastPeriod = (SELECT LEFT(DATE_SUB(DATE(@created_at),INTERVAL 1 MONTH),7) AS last_month_period)");

      /*Step 1*/
      $this->db->query("DELETE FROM points_movement WHERE periodcode = @EPeriod AND AccountNo = '".$accountno."'");

      /*Step 2*/
      $this->db->query("
        INSERT INTO points_movement
        (PeriodCode,AccountNo,Points,PointsAdj,PointsUsed,Created_at)

        SELECT
        TRIM(@EPeriod) AS PeriodCode,
        accountno,
        SUM(points) AS points,
        SUM(pointsAdj) AS pointsAdj,
        SUM(pointsused) AS PointsUsed,
        NOW() AS Created_at
        FROM
        (
          SELECT a.sup_code AS accountno,
          0 AS Points,
          0 AS PointsAdj,
          SUM(IF(trans_type='POINT_REDEEM',-b.VALUE_TOTAL,b.VALUE_TOTAL)) AS Pointsused
           FROM
          (
          SELECT trans_guid, sup_code, trans_type FROM trans_main 
          WHERE sup_code = '$accountno' AND trans_date BETWEEN @EDateFrom AND @EDateTo
          AND posted=1 AND trans_type='POINT_REDEEM'
          ) a
          INNER JOIN
          (
          SELECT trans_guid, VALUE_TOTAL FROM trans_child
          ) b
          ON a.trans_guid=b.trans_guid
          INNER JOIN
          (
          SELECT accountno FROM member WHERE accountno = '$accountno'
          )c
          ON c.accountno=a.sup_code
          GROUP BY a.sup_code

          UNION ALL

          SELECT a.sup_code AS accountno,
          0 AS Points,
          SUM(b.VALUE_TOTAL*qty_factor) AS PointsAdj,
          0 AS Pointsused
           FROM
          (
          SELECT trans_guid, sup_code FROM trans_main
          WHERE posted = 1 AND trans_date BETWEEN @EDateFrom AND @EDateTo AND 
          (trans_type='POINT_ADJ' OR trans_type='POINT_ADJ_IN' OR
          trans_type='POINT_ADJ_OUT') AND sup_code = '$accountno'
          ) a
          INNER JOIN
          (
          SELECT trans_guid, VALUE_TOTAL, qty_factor FROM trans_child
          ) b
          ON a.trans_guid=b.trans_guid
          INNER JOIN
          (
          SELECT accountno FROM member 
          WHERE accountno = '$accountno'
          ) c
          ON c.accountno=a.sup_code
          GROUP BY a.sup_code

          UNION ALL

          SELECT a.accountno,
          SUM(a.Points) AS Points,
          0 AS PointsAdj,
          0 AS Pointsused
          FROM
          (
          SELECT Points, accountno FROM frontend.posmain
          WHERE bizdate BETWEEN @EDateFrom AND @EDateTo
          ) a
          INNER JOIN
          (
          SELECT accountno FROM member
          WHERE accountno = '$accountno'
          ) b
          ON a.accountno=b.accountno
          GROUP BY a.accountno

          UNION ALL


          SELECT accountno,
          0 AS Points,
          SUM(Point_Total) AS PointsAdj,
          0 AS Pointsused
           FROM
           mem_trans_c
          WHERE DATE(created_at) BETWEEN @EDateFrom AND @EDateTo AND
          trans_type='ADJ-IN' AND AccountNo = '$accountno'
          GROUP BY accountno

          UNION ALL

          SELECT accountno,
          0 AS Points,
          SUM(Point_Total) AS PointsAdj,
          0 AS Pointsused
           FROM
          mem_trans_c
          WHERE
          DATE(created_at) BETWEEN @EDateFrom AND @EDateTo AND
          trans_type='ADJ-OUT' AND AccountNo = '$accountno'
          GROUP BY accountno

          UNION ALL

          SELECT accountno,
          0 AS Points,
          0 AS PointsAdj,
          SUM(Point_Total) AS Pointsused
           FROM
          mem_trans_c
          WHERE
          DATE(created_at) BETWEEN @EDateFrom AND @EDateTo AND
          trans_type='REDEEM' AND AccountNO = '$accountno'
          GROUP BY accountno
        ) a
        GROUP BY accountno
      ");

      /*Step 3 update member BF Point*/
      $this->db->query("
        UPDATE
        points_movement a
        INNER JOIN
        points_movement b
        ON a.accountNo=b.accountNo
        SET b.PointsBF=a.PointsBalance
        WHERE
        a.periodcode=@ELastPeriod AND
        b.periodcode=@EPeriod AND b.AccountNo = '$accountno'
      ");

      /*Step 4 insert missing record from last period*/
      $this->db->query("
        INSERT INTO points_movement
        SELECT @EPeriod AS PeriodCode,AccountNo,PointsBalance AS PointsBF,
        0 AS Points,0 AS PointsAdj, 0 AS PointsUsed,PointsBalance,
        NOW() AS Created_at
        FROM points_movement
        WHERE
        periodcode=@ELastPeriod AND Accountno = '$accountno' AND
        NOT EXISTS(SELECT * FROM points_movement WHERE accountno = '$accountno' AND periodcode=@ELastPeriod)
      ");

      /*Step 5 update points balance*/
      $this->db->query("
        UPDATE points_movement
        SET PointsBalance=PointsBF+PointsAdj+PointsUsed+Points
        WHERE
        periodcode=@EPeriod AND AccountNo = '$accountno'
      ");

      /*Step 6 update member*/
      $this->db->query("
        UPDATE member a
        INNER JOIN points_movement b
        ON a.accountno=b.accountno
        SET a.PointsBF=b.PointsBF,a.Points=b.Points,a.PointsAdj=b.PointsAdj,a.PointsUsed=b.PointsUsed
        WHERE
        b.PeriodCode=@EPeriod AND a.AccountNo = '$accountno'
      ");

      /*Step 7 update NewForScript flag*/
      $this->db->query("
        UPDATE member
        SET Pointsbalance=PointsBF+Points+PointsAdj+PointsUsed
        WHERE
        Pointsbalance<>PointsBF+Points+PointsAdj+PointsUsed
        AND AccountNo = '$accountno'
      ");
    }

    public function check_tac_for_redeem($cardno)
    {
        $result = $this->db->query("SELECT 
            IF(
            a.`Nationality` = 'MALAYSIAN' OR a.`Nationality` = 'MALAYSIA',
            RIGHT(REPLACE(digits(a.`ICNo`),'-',''),6),
            RIGHT(REPLACE(digits(a.`PassportNo`),'-',''),6) ) AS tac 

            FROM member a WHERE a.`CardNo` = '$cardno'

            union all
            
            SELECT 
            IF(
            a.`Nationality` = 'MALAYSIAN' OR a.`Nationality` = 'MALAYSIA',
            RIGHT(REPLACE(digits(a.`ICNo`),'-',''),6),
            RIGHT(REPLACE(digits(a.`PassportNo`),'-',''),6) ) AS tac
            
            from `member` a inner join `membersupcard` b on a.`AccountNo` = b.accountno
            where b.supcardno = '$cardno';
            ");
        return $result;
    }
}
?>