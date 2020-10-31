<?php


namespace CommonBundle\Helpers;


use Redis;

class CommonRedis
{
    /**
     * @var Redis
     */
    private $client;

    /**
     * RedisCacheDriver constructor.
     * @param $host
     * @param int $port
     * @param null $authPwd
     * @param float $timeout
     * @throws \Exception
     */
    public function __construct($host, $port = 6379, $authPwd = null, $timeout = 0.0)
    {
        $this->client = new Redis();
        try {
            $this->client->pconnect($host, intval($port), $timeout);
            if (!is_null($authPwd))
                $this->client->auth($authPwd);
            $this->client->ping();
        } catch (\RedisException $e) {
            throw new \Exception(sprintf('Redis connect error: %s, Host: %s, Port: %d', $e->getMessage(), $host, $port));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($key)
    {
        return $this->client->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $ttl = null)
    {
        if (null === $ttl)
            return $this->client->set($key, $value);
        else
            return $this->client->setex($key, $ttl, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        return $this->client->del($key);
    }

    /**
     * {@inheritdoc}
     */
    public function exist($key)
    {
        return $this->client->exists($key);
    }

    /**
     * @return Redis
     */
    public function getRedis()
    {
        return $this->client;
    }
}
