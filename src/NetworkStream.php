<?php

namespace Streamer;

class NetworkStream extends Stream
{
    /**
     * @param string $remoteSocket
     * @param int $errno
     * @param string $errstr
     * @param float $timeout
     * @param int $flags
     * @param resource $context
     * @return $this
     */
    public static function create(
        $remoteSocket,
        &$errno = null,
        &$errstr = null,
        $timeout = null,
        $flags = STREAM_CLIENT_CONNECT,
        $context = null
    ) {
        $timeout = $timeout ?? (ini_get('default_socket_timeout') ?? null);
        $type = gettype($context);

        // stream_socket_client needs to be called in the correct way based on what we have been passed.
        if (is_null($timeout) && ($type != 'resource')) {
            $fp = stream_socket_client($remoteSocket, $errno, $errstr);
        } elseif ($type != 'resource') {
            $fp = stream_socket_client($remoteSocket, $errno, $errstr, $timeout, $flags);
        } else {
            $fp = stream_socket_client($remoteSocket, $errno, $errstr, $timeout, $flags, $context);
        }

        return new static($fp);
    }

    /**
     * @param bool $remote
     * @return string
     */
    public function getName($remote = true)
    {
        return stream_socket_get_name($this->stream, $remote);
    }
}
