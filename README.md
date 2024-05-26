# Auto Currency Switcher - Magento 2 Extension

Automatically switches shop's currency to visitor's local currency - "Magento 2" Extension 

Auto Currency extension tracks visitor's IP address and automatically changes the store currency to the visitor's location currency. Visitor can switch to his/her desired currency at any time.

This extension uses `Nginx GeoIP2` databases for IP Address lookup. 

**Warning!! Here is Google's official stance on multilingual websites.**
- If you have multiple versions of a page:
- **Avoid automatically redirecting users from one language version of a site to a different language version of a site**. For example, don't redirect based on what you think the user's language may be. These redirections could prevent users (and search engines) from viewing all the versions of your site.
- Consider adding hyperlinks to other language versions of a page. That way users can click to choose a different language version of the page.
- **Therefore, using this extension is highly discouraged as it can have a very negative impact on Google SEO.**
- **Therefore, I abandoned this automatic extension and chose a method where users manually select the language and currency.**

## Prerequisite ##

#### Enable Multiple Currency on your Magento 2 Store

1. Login to Magento 2 Admin
2. Go to `STORES -> Configuration -> GENERAL -> Currency Setup -> Currency Options`
3. In `Allowed Currencies` box, select the currencies that you want to enable on your site/store
4. Now, go to `STORES -> Currency Rates`
5. Import currency rates by clicking the Import button, Or add the rates manually
6. Then, click the `Save Currency Rates` button

## Installation ##

#### Composer Installation
1. Go to your Magento website’s root directory with the following command:
    - `cd /path/to/your/magento/root/directory`
2. Run the following command:
    - `composer require hgati/auto-currency-switcher:dev-master`
3. Enable the module and clear static content with the following command:
    - `php bin/magento module:enable Hgati_AutoCurrencySwitcher –clear-static-content`
4. Do setup upgrade with the following command:
    - `php bin/magento setup:upgrade`
    
#### Configuration Settings

1. Login to your Magento site's admin
2. Go to `STORES → Settings → Configuration` page
3. On left sidebar, click on `CHAPAGAIN EXTENSIONS → Auto Currency` menu
4. From there, you can Enable/Disable the module. The module is disabled by default.

