
# Vendor_ImportAttributeValues 


This Magento 2 module extends the default product import functionality to automatically create attribute options that do not exist during import. This allows you to import products with attribute values that are not yet created in Magento, and the module will dynamically create those options.


## Features 

 
- **Automatic Attribute Option Creation** : During product import, missing attribute options are automatically created.
 
- **Customizable** : You can specify which attributes need this behavior in the code.
 
- **Easy to Install** : Simple installation via Composer or by placing the module in the `app/code` directory.


## Requirements 

 
- **Magento 2.3.x or higher**
 
- **PHP 7.2 or higher**


## Installation 

Step 1: Place the Module in the `app/code` Directory
Clone or download the module and place it in the `app/code` directory of your Magento installation.


```bash
cd /path/to/magento
git clone https://github.com/ismaelsaez/magento2-import-attribute-values.git app/code/Vendor/ImportAttributeValues
```


### Step 2: Enable the Module 


Run the following Magento CLI commands to enable the module and upgrade the database schema:



```bash
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```


### Step 3: Verify the Installation 


To ensure the module is installed correctly, you can check the list of installed modules:



```bash
php bin/magento module:status Vendor_ImportAttributeValues
```

You should see `Vendor_ImportAttributeValues` listed as enabled.

## Configuration 


This module automatically creates missing attribute options for the following attributes during product imports:

 
- **Color**  (color)
 
- **Size**  (size)

You can modify the list of attributes to watch for in the `Vendor\ImportAttributeValues\Plugin\ImportProductPlugin` class. Update the `$attributeCodes` array with any additional attributes you want the module to manage.


```php
$attributeCodes = ['color', 'size', 'custom_attribute']; // Add more attributes here
```


## Usage 


Once the module is installed, simply run a product import as you normally would via the Magento Admin Panel or CLI. If an attribute value being imported does not already exist, the module will automatically create the missing option before the import process continues.


### Example Import File 


For example, if you are importing products with the following attributes:

| SKU | Name | Color | Size | 
| --- | --- | --- | --- | 
| 1001 | Product A | Red | M | 
| 1002 | Product B | Blue | L | 

If `Red`, `Blue`, `M`, or `L` are not already attribute options in Magento, they will be automatically created.

## Troubleshooting 

 
- **Module not enabled** : If the module isn’t enabled, you can run the following command to enable it:


```bash
php bin/magento module:enable Vendor_ImportAttributeValues
```
 
- **Attribute options not being created** : Ensure that the attribute is set to use source models (dropdown or multi-select). If the attribute is set to use custom values, the module will only work for those attributes that use source models.


## Uninstallation 


To uninstall the module, run the following commands:



```bash
php bin/magento module:disable Vendor_ImportAttributeValues
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```

Then, delete the module directory from `app/code/Vendor/ImportAttributeValues`.

## License 


This module is open-source and available under the MIT License.
