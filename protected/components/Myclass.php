<?php

class Myclass extends CController {

    public static function encrypt($value) {
        return hash("sha512", $value);
    }

    public static function refencryption($str) {
        return base64_encode($str);
    }

    public static function refdecryption($str) {
        return base64_decode($str);
    }

    public static function t($str = '', $params = array(), $dic = 'app') {
        return Yii::t($dic, $str, $params);
    }

    public static function getRandomString($length = 9) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; //length:36
        $final_rand = '';
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $final_rand;
    }

    public static function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function rememberMe($username, $check) {
        if ($check > 0) {
            $time = time();     // Gets the current server time
            $cookie = new CHttpCookie('wipo_admin_username', $username);

            $cookie->expire = $time + 60 * 60 * 24 * 30;               // 30 days
            Yii::app()->request->cookies['wipo_admin_username'] = $cookie;
        } else {
            unset(Yii::app()->request->cookies['wipo_admin_username']);
        }
    }


//    public static function generateInvoiceno() {
//        $count = ContractInvoice::model()->count() + 1;
//        $new_inv_no = str_pad($count, ContractInvoice::INVOICE_PAD, '0', STR_PAD_LEFT);
//        ;
//        do {
//            $rf_no = ContractInvoice::model()->findByAttributes(array('Inv_Invoice' => $new_inv_no));
//            if (!empty($rf_no)) {
//                $check_inv_no = $rf_no->Inv_Invoice;
//                $count++;
//                $new_inv_no = $count;
//            } else {
//                break;
//            }
//        } while ($check_inv_no != $new_inv_no);
//        return $new_inv_no;
//    }

    public static function getDatediff($date1, $date2) {
        $d1 = new DateTime($date1);
        $d2 = new DateTime($date2);
        $diff = strtotime($date2) - strtotime($date1);
        $days = ($diff % 604800) / 86400;
        $months = $d1->diff($d2)->m + ($d1->diff($d2)->y * 12);
        $years = $d1->diff($d2)->y;
        $weeks = ($diff - ($days * 86400)) / 604800;

        return array(
            'days' => $days,
            'months' => $months,
            'weeks' => $weeks,
            'years' => $years,
        );
    }
}
