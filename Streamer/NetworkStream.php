<?php

namespace Streamer;

class NetworkStream extends Stream
{
    public static function create($address, $timeout = null, $flags = null, $context = null)
    {
        // stream_socket_client needs to be called in the correct way based on what we have been passed.
        if (is_null($timeout) && is_null($flags) && is_null($context)) {
            $fp = stream_socket_client($address, $errno, $errstr);
        } else if (is_null($flags) && is_null($context)) {
            $fp = stream_socket_client($address, $errno, $errstr, $timeout);
        } else if (is_null($context)) {
            $fp = stream_socket_client($address, $errno, $errstr, $timeout, $flags);
        } else {
            $fp = stream_socket_client($address, $errno, $errstr, $timeout, $flags, $context);
        }

        return new static($fp);
    }

    public function getName($remote = true)
    {
        return stream_socket_get_name($this->stream, $remote);
    }

}