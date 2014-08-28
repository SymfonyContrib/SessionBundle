<?php

namespace SymfonyContrib\Bundle\SessionBundle\Memcached;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler as BaseMemcachedSessionHandler;

/**
 * Customizable Memcached session handler.
 */
class MemcachedSessionHandler extends BaseMemcachedSessionHandler
{
    /**
     * Constructor.
     *
     * @param array $options An associative array of Memcached options
     */
    public function __construct(array $options = [])
    {
        $memcached = $this->memcachedFactory($options);

        $parentOptions = [
            'prefix'     => $options['prefix'],
            'expiretime' => $options['ttl'],
        ];

        parent::__construct($memcached, $parentOptions);
    }

    public static function memcachedFactory(array $options)
    {
        $memcached = $options['persistent'] ? new \Memcached($options['persistent']) : new \Memcached();

        $serverList = $memcached->getServerList();
        if (empty($serverList)) {
            $sessionOptions = [
                \Memcached::OPT_COMPRESSION          => $options['compression'],
                \Memcached::OPT_SERIALIZER           => constant('\\Memcached::SERIALIZER_' . strtoupper($options['serializer'])),
                \Memcached::OPT_HASH                 => constant('\\Memcached::HASH_' . strtoupper($options['hash'])),
                \Memcached::OPT_DISTRIBUTION         => constant('\\Memcached::DISTRIBUTION_' . strtoupper($options['distribution'])),
                \Memcached::OPT_LIBKETAMA_COMPATIBLE => $options['libketama'],
                \Memcached::OPT_BUFFER_WRITES        => $options['buffer_writes'],
                \Memcached::OPT_BINARY_PROTOCOL      => $options['binary_protocol'],
                \Memcached::OPT_NO_BLOCK             => $options['no_block'],
                \Memcached::OPT_TCP_NODELAY          => $options['tcp_nodelay'],
                \Memcached::OPT_CONNECT_TIMEOUT      => $options['connect_timeout'],
//                \Memcached::OPT_RETRY_TIMEOUT        => $options['retry_timeout'],
                \Memcached::OPT_SEND_TIMEOUT         => $options['send_timeout'],
                \Memcached::OPT_RECV_TIMEOUT         => $options['receive_timeout'],
                \Memcached::OPT_POLL_TIMEOUT         => $options['poll_timeout'],
//                \Memcached::OPT_SERVER_FAILURE_LIMIT => $options['server_failure_limit'],
            ];
            $memcached->setOptions($sessionOptions);
            $memcached->addServers($options['servers']);
        }

        return $memcached;
    }
}
