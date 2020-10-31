<?php


namespace QiniuBundle\Helpers;


use Exception;
use Qiniu\Auth;
use Qiniu\Http\Error;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;


/**
 * Class Client
 * @package QiniuBundle\Helpers
 */
class Client
{
    /**
     * @var string
     */
    protected $accessKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var Auth|null
     */
    private $_auth = null;

    /**
     * @var array
     */
    private $_bucketManagers = [];

    /**
     * @var array
     */
    private $_uploadManagers = [];

    /**
     * Client constructor.
     * @param string $accessKey
     * @param string $secretKey
     */
    public function __construct(string $accessKey, string $secretKey)
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @param $bucket
     * @param $filePath
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public function uploadFile($bucket, $filePath, $key)
    {
        $mgr = $this->getUploadManager($bucket);
        list($ret, $err) = $mgr->putFile($this->getUploadToken($bucket), $key, $filePath);
        if (null === $err) {
            return $ret;
        } else {
            throw new \RuntimeException($err->message(), $err->code());
        }
    }

    /**
     * @param $bucket
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public function stat($bucket, $key)
    {
        $mgr = $this->getBucketManager($bucket);
        /** @var Error $err */
        list($ret, $err) = $mgr->stat($bucket, $key);
        if (null === $err) {
            return $ret;
        } else {
            throw new \RuntimeException($err->message(), $err->code());
        }
    }

    /**
     * @param $bucket
     * @param $key
     * @return bool
     * @throws Exception
     */
    public function remove($bucket, $key)
    {
        $mgr = $this->getBucketManager($bucket);
        /** @var Error $err */
        $err = $mgr->delete($bucket, $key);
        if (null === $err) {
            return true;
        } else {
            throw new \RuntimeException($err->message(), $err->code());
        }
    }

    /**
     * @param string $bucket
     *
     * @return string 上传凭证
     */
    public function getUploadToken($bucket)
    {
        return $this->getAuth()->uploadToken($bucket);
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        if (null === $this->_auth)
            $this->_auth = new Auth($this->accessKey, $this->secretKey);

        return $this->_auth;
    }

    /**
     * @param string $bucket
     *
     * @return UploadManager
     */
    protected function getUploadManager($bucket)
    {
        if (!array_key_exists($bucket, $this->_uploadManagers)) {
            $this->_uploadManagers[$bucket] = new UploadManager();
        }

        return $this->_uploadManagers[$bucket];
    }

    /**
     * @param string $bucket
     *
     * @return BucketManager
     */
    protected function getBucketManager($bucket)
    {
        if (!array_key_exists($bucket, $this->_bucketManagers)) {
            $this->_bucketManagers[$bucket] = new BucketManager($this->getAuth());
        }

        return $this->_bucketManagers[$bucket];
    }
}
