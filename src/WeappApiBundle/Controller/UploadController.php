<?php


namespace WeappApiBundle\Controller;

use CommonBundle\Helpers\UploadHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Annotation\Anonymous;

/**
 * Class UploadController
 * @package WeappApiBundle\Controller
 * @Anonymous()
 */
class UploadController extends AbstractApiController
{
    /**
     * 上传图片
     *
     * @Route("/image", name="weapp.upload.image", methods={"POST"})
     * @return JsonResponse
     */
    public function uploadImage()
    {
        return $this->upload('png|jpeg|jpg|gif');
    }

    /**
     * @param $extensions
     * @return JsonResponse
     */
    private function upload($extensions)
    {
        $fs = $this->get('filesystem');
        try {
            $relativePath = '/uploads/idle/' . date('Y/m');
            $uploadDir = $this->container->getParameter('kernel.root_dir') . '/../web' . $relativePath;

            if (!$fs->exists($uploadDir))
                $fs->mkdir($uploadDir);
            $uploader = new UploadHelper('file');
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
