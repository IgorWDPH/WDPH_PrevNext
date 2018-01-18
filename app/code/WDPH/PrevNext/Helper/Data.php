<?php
namespace WDPH\PrevNext\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    protected $storeManager;
    protected $objectManager;
	protected $_coreRegistry;
	protected $productRepository;

    const XML_PATH_PREVNEXT = 'wdph_prevnext/';

    public function __construct(Context $context,
								ObjectManagerInterface $objectManager,
								StoreManagerInterface $storeManager,
								\Magento\Framework\Registry $coreRegistry,
								\Magento\Catalog\Api\ProductRepositoryInterface $productRepository)
	{
		$this->_coreRegistry = $coreRegistry;
		$this->productRepository = $productRepository;
        $this->objectManager = $objectManager;
        $this->storeManager  = $storeManager;
        parent::__construct($context);
    }

    public function getConfig($config_path, $storeCode = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_PREVNEXT . $config_path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeCode);
    }
	
	protected function getCategoryProductIds($currentCategory)
	{
        return $currentCategory->getProductCollection()->addAttributeToSelect('*')->addAttributeToFilter('is_saleable', 1, 'left')->addAttributeToSort('position','asc')->getAllIds();                 
    }
	
	public function getNextProduct()
	{
		$prodId = $this->_coreRegistry->registry('product')->getId();
		$currentCategory = $this->objectManager->get('Magento\Framework\Registry')->registry('current_category');		
		if($currentCategory && $prodId)
		{
			$catProductIds = $this->getCategoryProductIds($currentCategory);			
			$currentProductPossition = array_search($prodId, $catProductIds);
			if(isset($catProductIds[$currentProductPossition + 1]))
			{
				$nextProduct = $this->productRepository->getById($catProductIds[$currentProductPossition + 1]);
				return $nextProduct;
			}			
		}
		return false;
	}
	
    public function getPreviousProduct()
    {
		$prodId = $this->_coreRegistry->registry('product')->getId();
		$currentCategory = $this->objectManager->get('Magento\Framework\Registry')->registry('current_category');		
		if($currentCategory && $prodId)
		{
			$catProductIds = $this->getCategoryProductIds($currentCategory);			
			$currentProductPossition = array_search($prodId, $catProductIds);
			if(isset($catProductIds[$currentProductPossition - 1]))
			{
				$prevProduct = $this->productRepository->getById($catProductIds[$currentProductPossition - 1]);
				return $prevProduct;
			}			
		}
		return false;
    }
}
?>