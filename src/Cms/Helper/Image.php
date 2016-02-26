<?php

# @todo: van e szükség rá?

namespace Waxis\Cms\Cms\Helper;

class Image {

	public $data = null;

	public $params = null;
	
	public $form = null;

	public $id = null;

	public $images = array();

	public $multiimages = array();

	public $idField = null;

	public $idElement = null;

	public $table = null;

	public function __construct ($data, $params, WX_Form_Element_Form $form) {
		$this->data = $data;

		$this->params = $params;

		$this->form = $form;

		$this->idField = $form->getIdField();

		$this->idElement = $form->getIdElement();

		$this->table = $form->getTable();

		$this->id = isset($data[$this->idElement]) && !empty($data[$this->idElement]) ? $data[$this->idElement] : null;

		$this->action = $this->id !== null ? 'edit' : 'add';
	}

	public function handleImage () {
		if (empty($this->images)) {
			$this->_setImageElements();
		}

		if (empty($this->images)) {
			return;
		}

		# if it's an edit we have to compare incoming to existing record
		$oldRecord = $this->_getOldRecord();

		# handle all the images in form
		foreach ($this->images as $image) {
			switch ($this->action) {
				case 'add':
					# if it's an add, and we have incoming image, then upload it
					if (!empty($image['value'])) {
						$this->_addImage($image['descriptor'], $image['value']);
					}
					break;

				case 'edit':
					$oldImage = $oldRecord[$image['field']];
					$descriptor = $image['descriptor'];
					$newImage = $image['value'];
					$newImageKey = $image['key'];

					# if we don't have an image key it was not clonable image
					if ($newImageKey === null) {
						$this->_handleImageEditOne($oldImage, $newImage, $descriptor);

					# if we have image key then it is clonable
					# and old image is a json
					} else {
						$oldImage = json_decode($oldImage, true);
						$oldImage = isset($oldImage[$newImageKey]) ? $oldImage[$newImageKey] : null;

						$this->_handleImageEditOne($oldImage, $newImage, $descriptor);
					}

					break;

			}
		}
	}

	public function _handleImageEditOne ($oldImage, $newImage, $descriptor) {
		# if we don't have new image but have old delete old
		if (empty($newImage) && !empty($oldImage)) {
			$this->_deleteImage($descriptor, $oldImage);

		# if we have new image
		} else {
			# if we don't have old image just add new
			if (empty($oldImage) && !empty($newImage)) {
				$this->_addImage($descriptor, $newImage);

			# if we have old image and it doesn't match the new one
			# delete the old, and add the new
			} elseif ($oldImage != $newImage) {
				$this->_deleteImage($descriptor, $oldImage);
				$this->_addImage($descriptor, $newImage);
			}
		}
	}

	public function handleMultiimage () {
		$this->_setMultiimageElements();

		if (empty($this->multiimages)) {
			return;
		}

		foreach ($this->multiimages as $multiimage) {

			$images = !empty($multiimage['value']) ? $multiimage['value'] : null;
			$imagesArray = $images !== null ? json_decode($images, true) : null;
			$descriptor = $multiimage['descriptor'];
			$multiimageField = $multiimage['field'];
			$key = $multiimage['key'];

			switch ($this->action) {
				case 'add':
					# if we don't have images to add
					if ($images === null) {
						continue;
					}

					# add all the images		
					foreach ($imagesArray as $hash => $image) {
						$this->_addImage($descriptor, $hash);
					}

					# set return data 
					$this->_setDataJsonWithNormalSizeUrls($imagesArray, $multiimageField, $descriptor, $key);
					break;

				case 'edit':
					# if it's an edit we have to compare incoming to existing record
					$oldRecord = $this->_getOldRecord();
					$oldImages = !empty($oldRecord[$multiimageField]) ? $oldRecord[$multiimageField] : null;

					# if we don't have key it was not clonable multiimage
					if ($key === null) {
						$this->_handleMultiimageEditOne($oldImages, $images, $multiimageField, $descriptor, $key);

					# if we have key then it is clonable and old multiimage is a json
					} else {
						$oldImages = json_decode($oldImages, true);
						$oldImages = isset($oldImages[$key]) && !empty($oldImages[$key]) ? $oldImages[$key] : null;

						$this->_handleMultiimageEditOne($oldImages, $images, $multiimageField, $descriptor, $key);
					}
					
					break;
			}
		}

		return $this->data;
	}

	public function _handleMultiimageEditOne ($oldImages, $images, $multiimageField, $descriptor, $key) {
		$oldImagesArray = !empty($oldImages) ? json_decode($oldImages, true) : null;
		$imagesArray = !empty($images) ? json_decode($images, true) : null;

		# if we don't have incoming images
		if ($images === null) {
			# did we have images before?
			if ($oldImages !== null) {
				# if yes, then delete them
				foreach ($oldImagesArray as $hash => $image) {
					$this->_deleteImage($descriptor, $hash);
				}
			}

		# if we have incoming images
		} else {

			# did we have images before?
			if ($oldImages === null) {
				# if no, then just upload current
				foreach ($imagesArray as $hash => $image) {
					$this->_addImage($descriptor, $hash);
				}

			} else {
				# if yes, did it change?
				if ($oldImages != $images) {

					# if yes compare the old images to new ones
					//$images = json_decode($multiimage['value'], true);
					$oldImageIds = array_keys($oldImagesArray);
					$newImageIds = array_keys($imagesArray);

					$imagesToDelete = array_diff($oldImageIds, $newImageIds);
					$imagesToAdd = array_diff($newImageIds, $oldImageIds);

					# delete the old ones we don't have now
					foreach ($imagesToDelete as $hash) {
						$this->_deleteImage($descriptor, $hash);
					}

					# add the new ones
					foreach ($imagesToAdd as $hash) {
						$this->_addImage($descriptor, $hash);
					}
				}
			}

			$this->_setDataJsonWithNormalSizeUrls($imagesArray, $multiimageField, $descriptor, $key);
		}
	}

	public function _setDataJsonWithNormalSizeUrls ($images, $multiimageField, $descriptor, $key) {
		if (($key !== null && !empty($this->data[$multiimageField]) && !isset($this->data[$multiimageField][0])) || $key == null) {
			$this->data[$multiimageField] = [];
		}
				
		foreach ($images as $hash => $image) {
			$value = [
				'title' => $image['title'],
				'url' => $this->_getImage($descriptor, $hash, 'normal')
			];

			if ($key === null) {
				$this->data[$multiimageField][$hash] = $value;
			} else {
				$this->data[$multiimageField][$key][$hash] = $value;
			}
		}

		if ($key === null) {
			$this->data[$multiimageField] = json_encode($this->data[$multiimageField]);
		} else {
			$this->data[$multiimageField][$key] = json_encode($this->data[$multiimageField][$key]);
		}
	}

	private function _setMultiimageElements () {
		foreach ($this->form->getElements() as $element) {
			if ($element->getType() == 'multiimage') {
				$this->multiimages[] = [
					'descriptor' => $element->getImageDescriptor(),
					'field' => $element->getName(false),
					'value' => $element->getValue(),
					'key' => $element->getValueKey(),
				];
			}
		}
	}

	private function _setImageElements () {
		foreach ($this->form->getElements() as $element) {
			if ($element->getType() == 'image') {
				$this->images[] = [
					'descriptor' => $element->getImageDescriptor(),
					'field' => $element->getName(false),
					'key' => $element->getValueKey(),
					'value' => $element->getValue(),
				];
			}
		}
	}

	private function _getOldRecord () {
		$db = Zend_Registry::get('db');
		$query = $db->select()
					->from($this->table)
					->where($this->idField . ' = "' . $this->id . '"')
					->limit(1);
		return $db->query($query)->fetch();
	}

	private function _addImage ($descriptor, $value) {
		WX_Image::getInstance($descriptor)->moveFromTempToLiveAndResize($value);
	}

	private function _getImage ($descriptor, $value, $size) {
		return WX_Image::getInstance($descriptor)->get($size, $value);
	}

	private function _deleteImage ($descriptor, $value) {
		WX_Image::getInstance($descriptor)->delete($value);
	}
}