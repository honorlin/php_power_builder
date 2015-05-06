<?php
    /* 
     * 名稱：換頁操作
     * 編寫：林廷鴻
     * 日期：2013/01/30
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */

    class pageOP
    {

        public function memoPage($page)
        {
            if(isset($_GET['page']))
                $_SESSION[$page] = $_GET['page']; 
            else
                $_SESSION[$page] = 1;
        }

        public function restorePage($page)
        {
            // 第一頁的名稱
            if(isset($_SESSION[$page]))
                return $page . "?page=" . $_SESSION[$page];
            else
                return $page;
        }

    }



?>
