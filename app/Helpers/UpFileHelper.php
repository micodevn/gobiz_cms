<?php

namespace App\Helpers;

class UpFileHelper
{
    // kiểm tra url có tồn tại hay không
    public static function is_url_exist($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }


    public static function checkPathFile($local_file, $destination_file, $type = '')
    {
        $check_has_file = true;
        if ($type == 'video') {
            $link_server = VtHelper::getLinkMedia($destination_file, 3);
            $link_up_server = $destination_file;
            $status = self::is_url_exist($link_server);
            if ($status == false) {
                $check_dir = self::ftpVideoMkdir($link_up_server);
                if ($check_dir) {
                    self::upVideoToVega($local_file, $link_up_server);
                }
            } else {
                self::upVideoToVega($local_file, $link_up_server);
            }
        } else {
            $link_server = VtHelper::getLinkMedia($destination_file, 1);
            $link_up_server = $destination_file;
            $status = self::is_url_exist($link_server);
            if ($status == false) {
                $check_dir = self::ftpMkdir($link_up_server);
                if ($check_dir) {
                    self::upFileToVega($local_file, $link_up_server);
                }
            } else {
                self::upFileToVega($local_file, $link_up_server);
            }
        }
        return $check_has_file;
    }

    // hàm tạo folder trên cdn
    public static function ftpMkdir($link_up_server)
    {
        $check_dir = true;
        $dir = explode('/', $link_up_server);
        /*$ftp_server = "181d5ecac-vorigin.vws.vegacdn.vn";
        $ftp_user_name = "user_475f668342179bc1181";
        $ftp_user_pass = "1907ff508d2891dc9b12";*/
        $ftp_server = "172.16.7.236";
        $ftp_user_name = "dungchung";
        $ftp_user_pass = "Educa@3000";
        $conn = ftp_connect($ftp_server);
        $login = ftp_login($conn, $ftp_user_name, $ftp_user_pass);
        ftp_pasv($conn, true) or die("Cannot switch to passive mode");

        for ($i = 0; $i < (count($dir) - 1); $i++) {
            if (!@ftp_chdir($conn, $dir[$i])) {
                if (!ftp_mkdir($conn, $dir[$i])) {
                    $check_dir = false;
                } else {
                    ftp_chdir($conn, $dir[$i]);
                }
            }
        }
        return $check_dir;
    }

    // hàm up file lên cdn
    public static function upFileToVega($local_file, $server_file)
    {
        set_time_limit(240);
        /*$ftp_server = "181d5ecac-vorigin.vws.vegacdn.vn";
        $ftp_user_name = "user_475f668342179bc1181";
        $ftp_user_pass = "1907ff508d2891dc9b12";*/
        $ftp_server = "172.16.7.236";
        $ftp_user_name = "dungchung";
        $ftp_user_pass = "Educa@3000";
        // set up basic connection
        $conn_id = ftp_connect($ftp_server);
        // login with username and password
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
        ftp_pasv($conn_id, true) or die("Cannot switch to passive mode");
        // upload a file
        $ret = ftp_nb_put($conn_id, $server_file, $local_file, FTP_BINARY);
        $count = 0;
        while ($ret == FTP_MOREDATA) {
            // Do whatever you want
            var_dump($count);
            $count++;
            // Continue uploading...
            $ret = ftp_nb_continue($conn_id);
        }
        if ($ret != FTP_FINISHED) {
            echo "There was an error uploading the file...";
        }
        // close the connection
        ftp_close($conn_id);
    }

    // hàm tạo folder trên cdn lưu video
    public static function ftpVideoMkdir($link_up_server)
    {
        $check_dir = true;
        $dir = explode('/', $link_up_server);
        /*$ftp_server = "181d5ecac-vorigin.vws.vegacdn.vn";
        $ftp_user_name = "user_475f668342179bc1181";
        $ftp_user_pass = "1907ff508d2891dc9b12";*/
        $ftp_server = "118.68.218.33";
        $ftp_user_name = "Sg-admin";
        $ftp_user_pass = "R6]rc^>M";
        $conn = ftp_connect($ftp_server);
        $login = ftp_login($conn, $ftp_user_name, $ftp_user_pass);
        ftp_pasv($conn, true) or die("Cannot switch to passive mode");

        for ($i = 0; $i < (count($dir) - 1); $i++) {
            if (!@ftp_chdir($conn, $dir[$i])) {
                if (!ftp_mkdir($conn, $dir[$i])) {
                    $check_dir = false;
                } else {
                    ftp_chdir($conn, $dir[$i]);
                }
            }
        }
        return $check_dir;
    }

    // hàm up video lên
    public static function upVideoToVega($local_file, $server_file)
    {
        /*$ftp_server = "181d5ecac-vorigin.vws.vegacdn.vn";
        $ftp_user_name = "user_475f668342179bc1181";
        $ftp_user_pass = "1907ff508d2891dc9b12";*/
        $ftp_server = "118.68.218.33";
        $ftp_user_name = "Sg-admin";
        $ftp_user_pass = "R6]rc^>M";
        // set up basic connection
        $conn_id = ftp_connect($ftp_server);
        // login with username and password
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
        ftp_pasv($conn_id, true) or die("Cannot switch to passive mode");
        // upload a file
        $ret = ftp_nb_put($conn_id, $server_file, $local_file, FTP_BINARY);
        $count = 0;
        while ($ret == FTP_MOREDATA) {
            // Do whatever you want
            var_dump($count);
            echo '<br>';
            $count++;
            $ret = ftp_nb_continue($conn_id);
        }
        if ($ret != FTP_FINISHED) {
            echo "There was an error uploading the file...";
        }
        // close the connection
        ftp_close($conn_id);
    }

    /**
     * Converts bytes into human readable file size.
     *
     * @param mixed $bytes
     * @return string human readable file size (2,87 Мб)
     * @author Mogilev Arseny
     */
    public static function FileSizeConvert($bytes)
    {
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

        foreach($arBytes as $arItem)
        {
            if($bytes >= $arItem["VALUE"])
            {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
            }
        }
        return $result;
    }
}
