<?php


namespace CommonBundle\Services;


use CommonBundle\Constants\IdleStatus;
use CommonBundle\Constants\TradeStatus;
use CommonBundle\Entity\Banner;
use CommonBundle\Entity\College;
use CommonBundle\Entity\IdleApplication;
use CommonBundle\Entity\IdleCategory;
use CommonBundle\Entity\IdleProfile;
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
                        'file' => $obj->getFile() ? ($domain . $obj->getFile()[0]['response']['data']['file']) : null
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
                case $obj instanceof IdleCategory:
                    $output = [
                        'title' => $obj->getTitle(),
                        'id' => $obj->getId()
                    ];
                    break;
                case $obj instanceof IdleApplication:
                    $output = [
                        'id' => $obj->getId(),
                        'title' => $obj->getTitle(),
                        'description' => $obj->getDescription(),
                        'status' => $obj->getStatus(),
                        'statusTitle' => IdleStatus::getTitle($obj->getStatus()),
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
                case $obj instanceof IdleProfile:
                    $output = [
                        'id' => $obj->getId(),
                        'status' => $obj->getStatus(),
                        'statusTitle' => TradeStatus::getTitle($obj->getStatus()),
                        'receipt' => $obj->getReceipt(),
                        'tradeAt' => $obj->getTradeAt()->format('Y-m-d H:i'),
                        'tradeEndAt' => $obj->getTradeEndAt() ? $obj->getTradeEndAt()->format('Y-m-d H:i') : null,
                        'application' => $this->toDataModel($obj->getIdleApplication()),
                        'profile' => $this->toDataModel($obj->getProfile()),
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
