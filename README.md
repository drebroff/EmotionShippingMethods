# MAIN TASK. Create shipping methods (non concept solution)

    ``funami/module-emotionshippingmethods``

___
> 1. Setup newest Magento version
>  2. Create new module. Must be compatible with newest Magento version.
>  3. Programatically create 2 new shipping methods from API (read "Dummy API setup"
>  below).
>  4. Shipping price and title should be taken from API.
>  5. Shipping methods should be shown in checkout only if cart total is above X sum. About
>  X sum read step 6:
>    * a. Shipping method with ID 1 should be visible only to logged in customers
>    * b. Shipping method with ID 2 should be visible only to guest customers
> 6. Create configuration in Magento admin, Store > Configuration > Sales > Delivery
  methods > Dummy shipping.
>  7. In shipping method configuration should be able to add X sum (read step 4).
>  8. Set default value for X sum, used if not set in config database.
>  9. Should be possible to disable module in admin.



## Main Functionalities
MAIN TASK. Create shipping methods with price and title taken form **API**


### Type 1: Zip file

 - Unzip the zip file in `app/code/Funami`
 - Enable the module by running `php bin/magento module:enable Funami_EmotionShippingMethods`
 - Apply database updates by running `php bin/magento setup:di:compile`
 - Flush the cache by running `php bin/magento cache:flush`


## Attributes



