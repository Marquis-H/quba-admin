<?php


namespace CommonBundle\Services;


use CommonBundle\Constants\IdleStatus;
use CommonBundle\Constants\TradeStatus;
use CommonBundle\Entity\Banner;
use CommonBundle\Entity\College;
use CommonBundle\Entity\IdleApplication;
use CommonBundle\Entity\IdleCategory;
use CommonBundle\Entity\IdleMessage;
use CommonBundle\Entity\IdleProfile;
use CommonBundle\Entity\Mark;
use CommonBundle\Entity\MatchApplication;
use CommonBundle\Entity\MatchCategory;
use CommonBundle\Entity\MatchInfo;
use CommonBundle\Entity\Page;
use CommonBundle\Entity\Professional;
use CommonBundle\Entity\SayLoveMessage;
use CommonBundle\Entity\SayLoveMessageComment;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Entity\WeappUserProfile;
use CommonBundle\Repository\MatchApplicationRepository;
use Doctrine\ORM\EntityManager;
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
                        'collegeItem' => $this->toDataModel($obj->getCollege()),
                        'professional' => $obj->getProfessional() ? $obj->getProfessional()->getId() : null,
                        'professionalItem' => $this->toDataModel($obj->getProfessional()),
                        'name' => $obj->getName(),
                        'gender' => $obj->getGender(),
                        'mobile' => $obj->getMobile(),
                        'sNo' => $obj->getSNo(),
                        'user' => $this->toDataModel($obj->getWeappUser())
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
                    /** @var EntityManager $em */
                    $em = $this->container->get('doctrine.orm.default_entity_manager');
                    $marks = $em->getRepository('CommonBundle:Mark')->findBy(['IdleApplication' => $obj]);
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
                        'photos' => $obj->getPhotos(),
                        'marks' => count($marks),
                        'profile' => $this->toDataModel($obj->getProfile()),
                        'isTop' => $obj->getTopAt() != null
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
                case $obj instanceof MatchCategory:
                    $output = [
                        'id' => $obj->getId(),
                        'title' => $obj->getTitle(),
                        'isOnline' => $obj->getIsOnline(),
                        'type' => $obj->getType()
                    ];
                    break;
                case $obj instanceof MatchInfo:
                    /** @var EntityManager $em */
                    $em = $this->container->get('doctrine.orm.default_entity_manager');
                    $matchApplication = $em->getRepository('CommonBundle:MatchApplication')->findBy(['isSponsor' => true, 'MatchInfo' => $obj]);
                    $marks = $em->getRepository('CommonBundle:Mark')->findBy(['MatchInfo' => $obj]);
                    $output = [
                        'id' => $obj->getId(),
                        'title' => $obj->getTitle(),
                        'tabs' => $obj->getTabs(),
                        'endAt' => $obj->getEndAt() ? $obj->getEndAt()->format('Y-m-d') : null,
                        'peopleLimit' => $obj->getPeopleLimit(),
                        'qualificationLimit' => $obj->getQualificationLimit(),
                        'files' => $obj->getFiles(),
                        'urls' => $obj->getUrls(),
                        'sponsorApplications' => count($matchApplication),
                        'matchCategory' => $this->toDataModel($obj->getMatchCategory()),
                        'marks' => count($marks),
                        'isTop' => $obj->getTopAt() != null
                    ];
                    break;
                case $obj instanceof MatchApplication:
                    $parentData = null;
                    if ($parent = $obj->getParent()) {
                        $children = [];
                        /** @var MatchApplication $value */
                        foreach ($parent->getChildren()->getValues() as $value) {
                            array_push($children, [
                                'id' => $value->getId(),
                                'name' => $value->getTeamName(),
                                'currentStatus' => $value->getCurrentStatus(),
                                'skill' => $value->getSkill(),
                                'experience' => $value->getExperience(),
                                'people' => $value->getPeople(),
                                'totalPeople' => $value->getTotalPeople(),
                                'joinEndAt' => $value->getJoinEndAt() ? $value->getJoinEndAt()->format('Y-m-d') : null,
                                'isSponsor' => $value->getIsSponsor(),
                                'skills' => $value->getSkills(),
                                'matchExperience' => $value->getMatchExperience(),
                                'contact' => $value->getContact(),
                                'matchInfo' => $this->toDataModel($value->getMatchInfo()),
                                'profile' => $this->toDataModel($value->getProfile()),
                                'childrens' => $value->getChildren()->count(),
                                'children' => [],
                                'parent' => null,
                                'createdAt' => $value->getCreatedAt()->format('Y-m-d')
                            ]);
                        }
                        $parentData = [
                            'id' => $parent->getId(),
                            'name' => $parent->getTeamName(),
                            'currentStatus' => $parent->getCurrentStatus(),
                            'skill' => $parent->getSkill(),
                            'experience' => $parent->getExperience(),
                            'people' => $parent->getPeople(),
                            'totalPeople' => $parent->getTotalPeople(),
                            'joinEndAt' => $parent->getJoinEndAt() ? $parent->getJoinEndAt()->format('Y-m-d') : null,
                            'isSponsor' => $parent->getIsSponsor(),
                            'skills' => $parent->getSkills(),
                            'matchExperience' => $parent->getMatchExperience(),
                            'contact' => $parent->getContact(),
                            'matchInfo' => $this->toDataModel($parent->getMatchInfo()),
                            'profile' => $this->toDataModel($parent->getProfile()),
                            'childrens' => $parent->getChildren()->count(),
                            'children' => $children,
                            'parent' => null,
                            'createdAt' => $parent->getCreatedAt()->format('Y-m-d')
                        ];
                    }
                    $output = [
                        'id' => $obj->getId(),
                        'name' => $obj->getTeamName(),
                        'currentStatus' => $obj->getCurrentStatus(),
                        'skill' => $obj->getSkill(),
                        'experience' => $obj->getExperience(),
                        'people' => $obj->getPeople(),
                        'totalPeople' => $obj->getTotalPeople(),
                        'joinEndAt' => $obj->getJoinEndAt() ? $obj->getJoinEndAt()->format('Y-m-d') : null,
                        'isSponsor' => $obj->getIsSponsor(),
                        'skills' => $obj->getSkills(),
                        'matchExperience' => $obj->getMatchExperience(),
                        'contact' => $obj->getContact(),
                        'matchInfo' => $this->toDataModel($obj->getMatchInfo()),
                        'profile' => $this->toDataModel($obj->getProfile()),
                        'childrens' => $obj->getChildren()->count(),
                        'children' => $this->toDataModel($obj->getChildren()),
                        'parent' => $parentData,
                        'createdAt' => $obj->getCreatedAt()->format('Y-m-d')
                    ];
                    break;
                case $obj instanceof Mark:
                    $output = [
                        'id' => $obj->getId(),
                        'slug' => $obj->getSlug(),
                        'idleApplication' => $this->toDataModel($obj->getIdleApplication()),
                        'matchInfo' => $this->toDataModel($obj->getMatchInfo()),
                        'createdAt' => $obj->getCreatedAt()->format('Y-m-d')
                    ];
                    break;
                case $obj instanceof IdleMessage:
                    $output = [
                        'id' => $obj->getId(),
                        'isReply' => $obj->getIsReply(),
                        'buyComment' => $obj->getBuyComment(),
                        'saleComment' => $obj->getSaleComment(),
                        'buyCommentAt' => $obj->getBuyCommentAt() ? $obj->getBuyCommentAt()->format('Y-m-d H:i:s') : null,
                        'saleCommentAt' => $obj->getSaleCommentAt() ? $obj->getSaleCommentAt()->format('Y-m-d H:i:s') : null,
                        'buyProfile' => $this->toDataModel($obj->getBuyProfile()),
                        'saleProfile' => $this->toDataModel($obj->getSaleProfile())
                    ];
                    break;
            }
        }
        return $output;
    }
}
