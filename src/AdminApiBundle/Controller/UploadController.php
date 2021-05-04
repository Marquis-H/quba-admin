<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2018/10/26
 * Time: 10:05 PM
 */

namespace AdminApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use CommonBundle\Helpers\UploadHelper;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UploadController
 * @package Admin\Controller\Api
 */
class UploadController extends AbstractApiController
{
    /**
     * 上传图片
     *
     * @Route("/image", name="admin.upload.image")
     * @Method({"POST"})
     *
     * @return JsonResponse
     */
    public function uploadImage()
    {
        return $this->upload('png|jpeg|jpg|gif|pdf|doc|docx');
    }

    /**
     * 上传文件
     *
     * @Route("/file", name="admin.upload.file")
     * @Method({"POST"})
     *
     * @return JsonResponse
     */
    public function uploadFile(){
        return $this->upload('xls|xlsx');
    }

    /**
     * @param $extensions
     * @return JsonResponse
     */
    private function upload($extensions){
        $fs = $this->get('filesystem');
        try {
            $relativePath = '/uploads/' . date('Y/m');
            $uploadDir = $this->container->getParameter('kernel.root_dir') . '/../web' . $relativePath;

            if (!$fs->exists($uploadDir))
                $fs->mkdir($uploadDir);
            $uploader = new UploadHelper($this->get('request_stack')->getCurrentRequest()->query->get('name', 'file'));
            $uploader->allowedExtensions = explode('|', $extensions);
            $oldName = str_replace('.' . $uploader->getExtension(), '', $uploader->getFileName());
            $uploader->newFileName = sprintf('%s.%s',
                uniqid(mt_rand(10000, 99999)),
                strtolower($uploader->getExtension())
            );
            $status = $uploader->handleUpload($uploadDir);
            if ($status) {
                $uploadPath = $relativePath . '/' . $uploader->newFileName;
                $data = array(
                    'name' => $oldName,
                    'file' => $uploadPath,
                    'extension' => $uploader->getExtension()
                );
                return $this->createSuccessJSONResponse('success', $data);
            } else {
                $uploadPath = null;
                return $this->createFailureJSONResponse(-1, $uploader->getErrorMsg());
            }
        } catch (\Exception $e) {
            return $this->createFailureJSONResponse(-1, $e->getMessage());
        }
    }
}
