<?php 

    # 获取真实IP
    function getIP() 
    {
        $dataList = array(
            isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:'',
            isset($_SERVER['HTTP_CLIENT_IP'])?$_SERVER["HTTP_CLIENT_IP"]:'',
            isset($_SERVER['REMOTE_ADDR'])?$_SERVER["REMOTE_ADDR"]:''
        );

        foreach ($dataList as $data) {
            if (isset($data) && $data && strcasecmp($data, 'unknown')) {
                if (strpos($data, ',') !== FALSE) {
                    $ip = explode(',', $data)[0];
                } else {
                    $ip = $data;
                }

            }
        }
        return $ip;
    }

    function getIpInfo()
    {
        // 通过第三方接口判定用户所在省市
        $client_ip = getIP();
        $ip_info = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php' . '?ip=' . $client_ip);
        return json_decode($ip_info, true);
    }


