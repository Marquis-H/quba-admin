<?php


namespace QiniuBundle\Services;


/**
 * Class CommonService
 * @package CommonBundle\Services
 */
class CommonService extends AbstractService
{
    /**
     * @param $path
     * @return string
     */
    public function getResourceUri($path)
    {
        $domain = $this->container->getParameter('qiniu.domain');
        if (strpos($path, 'http://') === false && strpos($path, 'https://') === false) {
            return $domain . $path;
        } else {
            return $path;
        }
    }

    /**
     * @param $key
     * @param $filePath
     * @param $bucket
     * @throws \Exception
     */
    public function checkStatAndUpload($key, $filePath, $bucket)
    {
        $client = $this->container->get('qiniu.client');
        if (strpos($key, '/') === 0) {
            $key = substr($key, 1);
        }
        try {
            $client->stat($bucket, $key);
        } catch (\RuntimeException $e) {
            switch ($e->getCode()) {
                case 612:
                    $client->uploadFile($bucket, $filePath, $key);
                    break;
            }
        }
    }
}
