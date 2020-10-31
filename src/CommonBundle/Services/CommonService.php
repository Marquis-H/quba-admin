<?php


namespace CommonBundle\Services;


use CommonBundle\Entity\Banner;
use CommonBundle\Entity\College;
use CommonBundle\Entity\IdleApplication;
use CommonBundle\Entity\Page;
use CommonBundle\Entity\Professional;
use CommonBundle\Entity\SayLoveMessage;
use CommonBundle\Entity\SayLoveMessageComment;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Entity\WeappUserProfile;
use Doctrine\ORM\PersistentCollection;

class CommonService extends AbstractService
{
    /**
     * @param $message
     * @param int $chat_id
     */
    public function sendTelegramMsg($message, $chat_id = 0)
    {

    }

    /**
     * @param $obj
     * @return array
     */
    public function toDataModel($obj)
    {
        $domain = $this->container->getParameter('api_domain');
        $output = [];
        if (is_array($obj) or $obj instanceof PersistentCollection) {
            foreach ($obj as $key => $item) {
                $output[$key] = $this->toDataModel($item);
            }
            return $output;
        } elseif (is_object($obj)) {
            switch ($obj) {
                case $obj instanceof WeappUser:
                    $output = [
                        'id' => $obj->getId(),
                        'avatar' => $obj->getAvatar(),
                        'nickname' => $obj->getNickname()
                    ];
                    break;
                case $obj instanceof WeappUserProfile:
                    $output = [
                        'pid' => $obj->getId(),
                        'college' => $obj->getCollege() ? $obj->getCollege()->getId() : null,
                        'professional' => $obj->getProfessional() ? $obj->getProfessional()->getId() : null,
                        'name' => $obj->getName(),
                        'gender' => $obj->getGender(),
                        'mobile' => $obj->getMobile(),
                        'sNo' => $obj->getSNo()
                    ];
                    break;
                case $obj instanceof Banner:
                    $output = [
                        'title' => $obj->getTitle(),
                        'url' => $obj->getUrl(),
                        'file' => $domain . $obj->getFile()
                    ];
                    break;
                case $obj instanceof Page:
                    $output = [
                        'title' => $obj->getTitle(),
                        'content' => $obj->getContent(),
                        'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i')
                    ];
                    break;
                case $obj instanceof College:
                    $output = [
                        'title' => $obj->getTitle(),
                        'id' => $obj->getId(),
                        'professionals' => $this->toDataModel($obj->getProfessional())
                    ];
                    break;
                case $obj instanceof Professional:
                    $output = [
                        'title' => $obj->getTitle(),
                        'id' => $obj->getId()
                    ];
                    break;
                case $obj instanceof IdleApplication:
                    $output = [
                        'title' => $obj->getTitle(),
                        'description' => $obj->getDescription(),
                        'status' => $obj->getStatus(),
                        'oldDeep' => $obj->getOldDeep(),
                        'number' => $obj->getNumber(),
                        'originalCost' => $obj->getOriginalCost(),
                        'currentCost' => $obj->getCurrentCost(),
                        'contactType' => $obj->getContactType(),
                        'contact' => $obj->getContact(),
                        'originalUrl' => $obj->getOriginalUrl(),
                        'remark' => $obj->getRemark(),
                        'category' => $obj->getIdleCategory()->getTitle(),
                        'famousPhoto' => $obj->getFamousPhoto(),
                        'photos' => $obj->getPhotos()
                    ];
                    break;
                case $obj instanceof SayLoveMessage:
                    $output = [
                        'id' => $obj->getId(),
                        'nickname' => $obj->getSelfNickname(),
                        'name' => $obj->getSelfName(),
                        'gender' => $obj->getSelfGender(),
                        'taName' => $obj->getSheName(),
                        'taGender' => $obj->getSheGender(),
                        'content' => $obj->getContent(),
                        'like' => $obj->getLike(),
                        'guess' => $obj->getGuess(),
                        'guessRight' => $obj->getGuessRight(),
                        'comments' => $obj->getSayLoveMessageComment()->count(),
                        'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i:s')
                    ];
                    break;
                case $obj instanceof SayLoveMessageComment:
                    $output = [
                        'id' => $obj->getId(),
                        'content' => [$obj->getComment()],
                        'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i:s'),
                        'icon' => "check-circle"
                    ];
                    break;
            }
        }
        return $output;
    }
}
