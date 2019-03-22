<?php

/**
 * Rpc
 */
class Rpc
{
    protected $_res_conn = null;
    protected $_str_service_name = null;
    protected $_intConnectTimeout;
    protected $_intTimeout;
    protected $_config = null;

    /**
     * 构造函数
     * @param [type] $strServiceName [description]
     */
    public function __construct($str_service_name)
    {
        if (!function_exists('curl_init')) {
            throw new Exception('curl extension must be loaded for using Rpc!');
        }
        $this->_str_service_name = $str_service_name;
    }

    /**
     * 获取rpc配置
     * @param  [type] $str_service_name [description]
     * @return [type] [description]
     */
    private function _get_rpc_config()
    {
        $str_service_name = $this->_str_service_name;
        $CI = &get_instance();
        $config = $CI->config->item('rpc');

        return isset($config[$str_service_name]) ? $config[$str_service_name] : [];
    }

    /**
     * 获取server信息
     * @param  [type] $arr_servers     [description]
     * @param  string $str_balance     [description]
     * @param  [type] $int_balance_key [description]
     * @return [type] [description]
     */
    private function _get_server($arr_servers, $str_balance = 'RoundRobin', $int_balance_key = null)
    {
        if (!$int_balance_key) {
            $int_balance_key = mt_rand();
        }
        $int_total_server = count($arr_servers);
        if (1 === $int_total_server) {
            return $arr_servers[0];
        } else {
            $int_key = $int_balance_key % $int_total_server;
            ++$this->int_balance_key;
            if ($arr_servers[$int_key]) {
                return $arr_servers[$int_key];
            }
        }

        return false;
    }

    /**
     * 调用
     * @param  [type] $strMethod     [description]
     * @param  array  $arrInput      [description]
     * @param  int    $intRetry      [description]
     * @param  string $strHttpMethod [description]
     * @param  string $strFormat     [description]
     * @return [type] [description]
     */
    public function call($str_method, $arr_input = [], $str_http_method = 'post', $str_format = 'json', $int_retry = 1)
    {
        $this->_init();

        $str_url_params = '';
        if (!empty($str_http_method) && ('post' == strtolower($str_http_method))) {
            curl_setopt($this->_res_conn, CURLOPT_POST, 1);
            if (!empty($arr_input)) {
                curl_setopt($this->_res_conn, CURLOPT_POSTFIELDS, $arr_input);
            }
        } else {
            $str_url_params = http_build_query($arr_input);
        }

        $arr_config = $this->_get_rpc_config();
        $arr_server = $this->_get_server($arr_config['servers']);
        $str_url = '/service/'.$str_method.'?'.$str_url_params;

        if (isset($arr_server['port'])) {
            curl_setopt($this->_res_conn, CURLOPT_URL,
                $arr_server['host'].':'.$arr_server['port'].$str_url);
            curl_setopt($this->_res_conn, CURLOPT_PORT, intval($arr_server['port']));
        } else {
            curl_setopt($this->_res_conn, CURLOPT_URL, $arr_server['host'].$str_url);
        }

        $arr_output = false;

        while ($int_retry--) {
            $arr_output = curl_exec($this->_res_conn);
            $int_errno = curl_errno($this->_res_conn);

            if (false === $arr_output && 0 != $int_errno) {
                log_message('error', sprintf('call service %s:%s fail. input[%s], output[%s]', $str_service_name, $str_method, serialize($arr_input), serialize($arr_output)));
            } else {
                break;
            }
        }

        if (false === $arr_output) {
            return curl_errno($this->_res_conn);
        }

        switch ($str_format) {
            case 'json':
                $arr_output = json_decode($arr_output, true);
                break;
            case 'php':
                $arr_output = unserialize($arr_output);
                break;
            default:
                break;
        }

        return $arr_output;
    }

    /**
     * curl init
     * @return [type] [description]
     */
    protected function _init()
    {
        $this->_res_conn = curl_init();
        $strUserAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!empty($strUserAgent)) {
            curl_setopt($this->_res_conn, CURLOPT_USERAGENT, $strUserAgent);
        }
        curl_setopt($this->_res_conn, CURLOPT_HEADER, 0);
        curl_setopt($this->_res_conn, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->_res_conn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_res_conn, CURLOPT_NOSIGNAL, 1);
        if (!is_null($this->_intConnectTimeout)) {
            curl_setopt($this->_res_conn, CURLOPT_CONNECTTIMEOUT_MS, $this->_intConnectTimeout);
        }
        if (!is_null($this->_intTimeout)) {
            curl_setopt($this->_res_conn, CURLOPT_TIMEOUT_MS, $this->_intTimeout);
        }
    }
}
