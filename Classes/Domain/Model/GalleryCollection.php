<?php

namespace TYPO3\GgExtbase\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Felix Nagel <info@felixnagel.com>
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

use \TYPO3\CMS\Extbase\Persistence\ObjectStorage,
	\TYPO3\GgExtbase\Domain\Model\GalleryItem;

/**
 * GalleryCollection
 */
class GalleryCollection extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity implements \Iterator, \Countable {

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	protected $items;


	/**
	 * Construct class
	 *
	 *
	 * @return \TYPO3\GgExtbase\Domain\Model\GalleryCollection
	 */
	public function __construct() {
		$this->items = new ObjectStorage();

		// TODO do this if its is a core collection
		if ( FALSE ) {
			// Load the records in each collection
			/** @var \TYPO3\CMS\Core\Collection\StaticRecordCollection $item */
			foreach ($this->items as $item) {
				$item->loadContents();
			}
		}
	}


	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getItems() {
		return $this->items;
	}


	/**
	 * @param $items \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 *
	 * @return $this
	 */
	public function setItems(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $items) {
		$this->items = $items;

		return $this;
	}

	/**
	 * Rewinds the iterator to the first storage element.
	 *
	 * @return void
	 */
	public function rewind() {
		$this->items->rewind();
	}

	/**
	 * Checks if the array pointer of the storage points to a valid position.
	 *
	 * @return boolean
	 */
	public function valid() {
		return $this->items->valid();
	}

	/**
	 * Returns the index at which the iterator currently is.
	 *
	 * @return string The index corresponding to the position of the iterator.
	 */
	public function key() {
		return $this->items->key();
	}

	/**
	 * Returns the current storage entry.
	 *
	 * @return object The object at the current iterator position.
	 */
	public function current() {
		return $this->items->current();
	}

	/**
	 * Moves to the next entry.
	 *
	 * @return void
	 */
	public function next() {
		$this->items->next();
	}

	/**
	 * Returns the number of objects in the storage.
	 *
	 * @return integer The number of objects in the storage.
	 */
	public function count() {
		return $this->items->count();
	}

	/**
	 *
	 * @param array $data
	 *
	 * @return $this
	 */
	public function addAll(array $data) {

		/* @var $object \TYPO3\CMS\Core\Resource\FileReference */
		foreach ($data as $object) {
			$item = new GalleryItem();
			$item->setImage($object);
			$item->setTitle($object->getTitle());
			$item->setLink($object->getPublicUrl());

			$this->items->attach($item);
		}

		return $this;
	}

	/**
	 * Returns this object storage as an array
	 *
	 * @return array The object storage
	 */
	public function toArray() {
		return $this->items->toArray();
	}

	/**
	 * Dummy method to avoid serialization.
	 *
	 * @throws \RuntimeException
	 *
	 * @return void
	 */
	public function serialize() {
		$this->items->serialize();
	}


}