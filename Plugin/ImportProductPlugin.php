<?php
namespace Vendor\ImportAttributeValues\Plugin;

use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\OptionLabel;
use Magento\Eav\Model\Entity\Attribute\OptionManagement;
use Magento\Eav\Api\Data\AttributeOptionInterfaceFactory;
use Magento\Eav\Api\Data\AttributeOptionLabelInterfaceFactory;

class ImportProductPlugin
{
    protected $eavConfig;
    protected $optionManagement;
    protected $optionFactory;
    protected $optionLabelFactory;

    public function __construct(
        Config $eavConfig,
        OptionManagement $optionManagement,
        AttributeOptionInterfaceFactory $optionFactory,
        AttributeOptionLabelInterfaceFactory $optionLabelFactory
    ) {
        $this->eavConfig = $eavConfig;
        $this->optionManagement = $optionManagement;
        $this->optionFactory = $optionFactory;
        $this->optionLabelFactory = $optionLabelFactory;
    }

    public function beforeValidateRow(
        \Magento\CatalogImportExport\Model\Import\Product $subject,
        array $rowData,
        $rowNum
    ) {
        $attributeCodes = ['color', 'size']; // Modify as needed

        foreach ($attributeCodes as $attributeCode) {
            if (!empty($rowData[$attributeCode])) {
                $this->addAttributeOption($attributeCode, $rowData[$attributeCode]);
            }
        }

        return [$rowData, $rowNum];
    }

    private function addAttributeOption($attributeCode, $optionValue)
    {
        $attribute = $this->eavConfig->getAttribute('catalog_product', $attributeCode);
        if (!$attribute || !$attribute->usesSource()) {
            return;
        }

        $options = $attribute->getSource()->getAllOptions();
        foreach ($options as $option) {
            if ($option['label'] === $optionValue) {
                return;
            }
        }

        // Create new option
        $option = $this->optionFactory->create();
        $option->setLabel($optionValue);

        $optionLabel = $this->optionLabelFactory->create();
        $optionLabel->setLabel($optionValue);

        $option->setStoreLabels([$optionLabel]);
        $option->setSortOrder(0);
        $option->setIsDefault(false);

        $this->optionManagement->add('catalog_product', $attributeCode, $option);
    }
}
