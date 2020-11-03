<?php
/**
 * @author will <wizarot@gmail.com>
 * @link   http://wizarot.me/
 *
 * Date: 2019/8/29
 * Time: 12:15 PM
 */

namespace CommonBundle\Helpers;

use CommonBundle\Constants\ApiCode;
use CommonBundle\Constants\ReviewStatus;
use CommonBundle\Entity\Banner;
use CommonBundle\Entity\College;
use CommonBundle\Entity\Event;
use CommonBundle\Entity\FosUser;
use CommonBundle\Entity\IdleApplication;
use CommonBundle\Entity\IdleCategory;
use CommonBundle\Entity\IdleProfile;
use CommonBundle\Entity\MatchApplication;
use CommonBundle\Entity\MatchCategory;
use CommonBundle\Entity\MatchInfo;
use CommonBundle\Entity\Page;
use CommonBundle\Entity\Professional;
use CommonBundle\Entity\Review;
use CommonBundle\Entity\Tab;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Entity\WeappUserTicket;
use CommonBundle\Entity\Works;
use CommonBundle\Exception\ApiException;
use CommonBundle\Repository\WeappUserTicketRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Util\Json;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class CommonHelper
 * @package CommonBundle\Helpers
 */
class CommonHelper
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;


    /**
     * CommonHelper constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    /**
     * @param null $name
     * @return ObjectManager
     */
    protected function getEntityManager($name = null)
    {
        return $this->container->get('doctrine')->getManager($name);
    }

    /**
     * @param $obj
     * @param null $locale
     * @return array
     * @throws Exception
     */
    public function toDataModel($obj, $locale = null)
    {
        $output = [];
        if (is_array($obj) or $obj instanceof PersistentCollection) {
            foreach ($obj as $item) {
                $output[] = $this->toDataModel($item, $locale);
            }
            return $output;
        } elseif (is_object($obj)) {
            if ($obj instanceof FosUser) {
                $output = [
                    'id' => $obj->getid(),
                    'enabled' => $obj->getEnable(),
                    'username' => $obj->getUsername(),
                    'isSuperAdmin' => $obj->isSuperAdmin(),
                    'password' => null,
                    'confirmPassword' => null,
                    'email' => $obj->getEmail(),
                    'name' => $obj->getName(),
                    'roles' => $obj->getRoles(),
                    'lastLogin' => $obj->getLastLogin() ? $obj->getLastLogin()->format('Y-m-d H:i') : null
                ];
            } elseif ($obj instanceof WeappUser) {
                $output = [
                    'id' => $obj->getid(),
                    'nickname' => $obj->getNickname(),
                    'avatar' => $obj->getAvatar(),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i')
                ];
            } elseif ($obj instanceof Banner) {
                $output = [
                    'id' => $obj->getid(),
                    'title' => $obj->getTitle(),
                    'file' => $obj->getFile(),
                    'slug' => $obj->getSlug(),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i')
                ];
            } elseif ($obj instanceof Page) {
                $output = [
                    'id' => $obj->getid(),
                    'title' => $obj->getTitle(),
                    'content' => $obj->getContent(),
                    'slug' => $obj->getSlug(),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i')
                ];
            } elseif ($obj instanceof College) {
                $output = [
                    'id' => $obj->getid(),
                    'title' => $obj->getTitle(),
                    'description' => $obj->getDescription(),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i')
                ];
            } elseif ($obj instanceof Professional) {
                $output = [
                    'id' => $obj->getid(),
                    'title' => $obj->getTitle(),
                    'description' => $obj->getDescription(),
                    'college' => $obj->getCollege()->getId(),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i')
                ];
            } elseif ($obj instanceof IdleCategory) {
                $output = [
                    'id' => $obj->getid(),
                    'title' => $obj->getTitle(),
                    'description' => $obj->getDescription(),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i')
                ];
            } elseif ($obj instanceof MatchCategory) {
                $output = [
                    'id' => $obj->getid(),
                    'title' => $obj->getTitle(),
                    'type' => $obj->getType(),
                    'isOnline' => $obj->getIsOnline(),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i')
                ];
            } elseif ($obj instanceof MatchInfo) {
                $output = [
                    'id' => $obj->getid(),
                    'title' => $obj->getTitle(),
                    'tabs' => $obj->getTabs(),
                    'endAt' => $obj->getEndAt()->format('Y-m-d H:i'),
                    'peopleLimit' => $obj->getPeopleLimit(),
                    'qualificationLimit' => $obj->getQualificationLimit(),
                    'files' => $obj->getFiles(),
                    'urls' => $obj->getUrls(),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d H:i'),
                    'applications' => $this->toDataModel($obj->getMatchApplication())
                ];
            } elseif ($obj instanceof MatchApplication) {
                $output = [
                    'currentStatus' => $obj->getCurrentStatus(),
                    'skill' => $obj->getSkill(),
                    'experience' => $obj->getExperience(),
                    'people' => $obj->getPeople(),
                    'totalPeople' => $obj->getTotalPeople(),
                    'joinEndAt' => $obj->getJoinEndAt()->format('Y-m-d H:i:s'),
                    'isSponsor' => $obj->getIsSponsor(),
                    'skills' => $obj->getSkills(),
                    'matchExperience' => $obj->getMatchExperience(),
                    'contact' => $obj->getContact()
                ];
            } elseif ($obj instanceof IdleApplication) {
                $output = [
                    'id' => $obj->getId(),
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
                    'profile' => $this->toDataModel($obj->getProfile()),
                    'createdAt' => $obj->getCreatedAt()->format('Y-m-d')
                ];
            } elseif ($obj instanceof IdleProfile) {
                $output = [
                    'title' => $obj->getProfile()->getName(),
                    'status' => $obj->getStatus()
                ];
            }
        }
        return $output;
    }

    /**
     * @param $date
     * @param string $format
     * @param bool $timestamp
     * @return int|string|null
     */
    public function getDateTimeFormat($date, $format = 'Y-m-d H:i', $timestamp = false)
    {
        if ($date instanceof \DateTime) {
            return $timestamp ? $date->getTimestamp() : $date->format($format);
        }
        return null;
    }

    /**
     * @param $filters
     * @param $page
     * @param $limit
     * @param QueryBuilder $queryBuilder
     * @param $class
     * @return array
     * @throws ApiException
     */
    public function filterPagination($filters, $page, $limit, QueryBuilder $queryBuilder, $class)
    {
        $filters = Json::decode($filters, true);
        if (is_array($filters) && !empty($filters)) {
            foreach ($filters as $key => $value) {
                if ($value) {
                    if (!property_exists($class, $key)) {
                        throw new ApiException('非法参数' . $key, ApiCode::DATA_INVALID);
                    }
                    $queryBuilder->andWhere('q.' . $key . ' LIKE :' . $key)
                        ->setParameter($key, '%' . $value . '%');
                }
            }
        }

        /** @var PaginationInterface $pagination */
        $pagination = $this->container->get('knp_paginator')->paginate($queryBuilder, $page, $limit);

        return [
            'currentPage' => (int)$page,
            'perPage' => (int)$limit,
            'total' => $pagination->getTotalItemCount(),
            'items' => $this->toDataModel($pagination->getItems())
        ];
    }

    /**
     * @param $filters
     * @param $page
     * @param $limit
     * @param QueryBuilder $queryBuilder
     * @param $class
     * @return array
     * @throws Exception
     */
    public function filterPaginationReview($filters, $page, $limit, QueryBuilder $queryBuilder, $class)
    {
        $filters = Json::decode($filters, true);
        if (is_array($filters) && !empty($filters)) {
            foreach ($filters as $key => $value) {
                if ($value) {
                    $queryBuilder->andWhere('w.' . $key . ' LIKE :' . $key)
                        ->setParameter($key, '%' . $value . '%');
                }
            }
        }

        /** @var PaginationInterface $pagination */
        $pagination = $this->container->get('knp_paginator')->paginate($queryBuilder, $page, $limit);

        return [
            'currentPage' => (int)$page,
            'perPage' => (int)$limit,
            'total' => $pagination->getTotalItemCount(),
            'items' => $this->toDataModel($pagination->getItems())
        ];
    }

    /**
     * @param $file
     * @param int $len
     * @return array
     */
    static function getExcelDate($file, $len = 2)
    {
        try {
            /** Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = IOFactory::load($file);
            $worksheetAll = $spreadsheet->getAllSheets();
            $rows = [];
            foreach ($worksheetAll as $wa) {
                $i = 0;
                // 前三行不需要
                foreach ($wa->getRowIterator() AS $row) {
                    $i++;
                    if ($i < $len) {
                        continue;//第一行數據沒用,直接跳過去
                    }

                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // This loops through all cells,
                    $cells = [];
                    foreach ($cellIterator as $cell) {
                        $cells[] = $cell->getFormattedValue();
                    }
                    $rows[] = $cells;
                }
            }

            return $rows;

        } catch (\Exception $e) {
            die('Error loading file: ' . $e->getMessage() . ' file:' . $e->getFile() . ' Line:' . $e->getLine());
        }
    }
}
