<?php
namespace WDPH\PrevNext\Block;

class Prevnext extends \Magento\Framework\View\Element\Template
{
	protected $prevNexthelper;
	protected $_imagehelper;
	
	public function __construct(\Magento\Framework\View\Element\Template\Context $context,
								\WDPH\PrevNext\Helper\Data $helper,
								\Magento\Catalog\Helper\Image $imagehelper,
                                array $data = [])
    {
		$this->_imagehelper = $imagehelper;
		$this->prevNexthelper = $helper;
        parent::__construct($context, $data);
    }
	
	public function isPrevNextEnabled()
	{
		return $this->prevNexthelper->getConfig('general/enabled');
	}
	
	public function isShowPreview()
	{
		return $this->prevNexthelper->getConfig('general/show_preview');
	} 
	
	public function getNextProduct()
	{
		return $this->prevNexthelper->getNextProduct();
	}
	
	public function getPreviousProduct()
	{
		return $this->prevNexthelper->getPreviousProduct();
	}
	
	public function getPreviewProductImage($product)
	{
		return $this->_imagehelper->init($product, 'category_page_grid')->constrainOnly(FALSE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(100)->getUrl();        
	}
}