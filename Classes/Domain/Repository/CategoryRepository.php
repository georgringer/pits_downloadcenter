<?php
namespace PITS\PitsDownloadcenter\Domain\Repository;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 HOJA <hoja.ma@pitsolutions.com>, PIT Solutions Pvt Ltd
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * CategoryRepository
 * The repository for Category
 */
class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * $defaultOrderings
     *
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     * initializeObject
     */
    public function initializeObject()
    {
        /** @var $querySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        // don't add the pid constraint
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * getSubCategories
     *
     * @param $categoryID
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
	public function getSubCategories($categoryID)
    {
		$query = $this->createQuery();

		// constraint for setting the Parent Category Uid
		$query->matching(
			$query->equals("parentcategory", "$categoryID") 
		);

		// set the sorting order ascending and field sorting for ordering
		$query->setOrderings(
		    array('sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING)
        );
		return $query->execute();
	}

    /**
     * getSubCategoriesCount
     *
     * @param $categoryID
     * @return int
     */
	public function getSubCategoriesCount($categoryID)
    {
		$query = $this->createQuery();

        // constraint for setting the Parent Category Uid
		$query->matching(
			$query->equals("parentcategory", "$categoryID") 
		);

        // set the sorting order ascending and field sorting for ordering
		$query->setOrderings(
		    array('sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING)
        );
		return $query->count();
	}
}
