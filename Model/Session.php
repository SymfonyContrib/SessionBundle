<?php

namespace SymfonyContrib\Bundle\SessionBundle\Model;

class Session
{
    /** @var  string */
    protected $id;

    /** @var  object */
    protected $data;

    /** @var  int */
    protected $lifetime;

    /** @var  int */
    protected $timestamp;

    /** @var  array */
    protected $decodedData;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Session
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param object $data
     *
     * @return Session
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return int
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }

    /**
     * @param int $lifetime
     *
     * @return Session
     */
    public function setLifetime($lifetime)
    {
        $this->lifetime = $lifetime;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     *
     * @return Session
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getDecodedData()
    {
        // Check to see of data has been decoded yet.
        if (!$this->decodedData && $this->data) {
            $this->decode();
        }

        return $this->decodedData;
    }

    public function decode()
    {
        // Keep a copy of the current user's session.
        $backup = $_SESSION;
        // Decode the session.
        session_decode(stream_get_contents($this->data));
        // Save decoded data
        $this->decodedData = $_SESSION;
        // Return the original session data.
        $_SESSION = $backup;

        return $this->decodedData;
    }
}
