<?php
/**
 * Class MCurl
 * @package App\Infra
 * @author     marcelo
 * @author     Another Author
 */

namespace App\Infra;


class MCurl
{

    public static function post($url, $data = [], $header = null, $decode = true)
    {

        $url = str_replace(' ', '%20', $url);

        $ch = curl_init();
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $object = curl_exec($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        if ($object === false) {
            dd('Error: (' . $http_status . ') ' . curl_error($ch));
            return null;
        }

        if ($decode && $object)
            $object = json_decode($object);

        curl_close($ch);

        return $object;
    }

    public static function get($url, $header, $decode = true)
    {

        $url = str_replace(' ', '%20', $url);

        $ch = curl_init();
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        $object = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        if ($object === false) {
            dd('Error: (' . $http_status . ') ' . curl_error($ch));
            return null;
        }

        if ($decode)
            $object = json_decode($object);

        curl_close($ch);

        return $object;
    }

}
