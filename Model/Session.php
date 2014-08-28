<?php

namespace SymfonyContrib\Bundle\SessionBundle\Model;

class Session
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $data;

    /** @var int */
    protected $timestamp;

    /** @var array */
    protected $decodedData;

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
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
        session_decode($this->data);
        // Save decoded data
        $this->decodedData = $_SESSION;
        // Return the original session data.
        $_SESSION = $backup;

        return $this->decodedData;
    }
}
