=== Builder for WooCommerce product reviews shortcodes - ReviewShort ===
Contributors: Tobias_Conrad, Freemius
Donate link: https://checkout.freemius.com/mode/dialog/plugin/5861/plan/9651/?trial=paid
Tags: woocommerce reviews, customer reviews, WooCommerce product reviews, google rating, review plugin
Requires PHP: 7.0
Requires at least: 5.0
Tested up to: 6.5
Stable tag: 1.01.7
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.txt

Show WooCommerce customer feedback anywhere with WooCommerce reviews shortcodes, beautifully and ...
== Description ==
**By default** WooCommerce product reviews are shown only on the product details page.
With this WooCommerce reviews shortcodes generator you can **view product reviews anywhere and beautifully**. For example on your homepage, sales page, landing page and shop page.
**Thereby you get social proof** on these pages and google is likely to show the ratings and details on the search results.
**USP1:** WooCommerce reviews shortcodes are working anywhere in any page builder: Gutenberg, Elementor, Page Origin, Beaver Builder, WPBakery, Divi, Oxygen builder, Thrive Architect, ...
**USP2:** You can alter the layout of the reviews in templates inside each shortcode.

[Please see new Knowledge Base with Chat/Ticketsystem for workarounds,...](https://betterreviewsforwoocommerce.tawk.help/)

= Video - 90 seconds challenge =

https://www.youtube.com/watch?v=QZFf2GDdR-E

= Benefits by using WooCommerce reviews shortcodes =

- Adds google product ratings schema to any page or post
- Uses WooCommerce product details page review layout and style
- Working with all page builders and themes
- Easy click and select WooCommerce shortcode builder

= Style customer reviews =

- Show reviewer or product image
Case: Often reviewer does not add its own picture and the review looks less attractive.
In this case show the product image and visitor will connect review text with product image.
- For mobile view there is no need to restyle the customer reviews, they are mobile responsive out of the box

= usage examples =

(They are in german, because my shop target country is germany)
The plugin is fully working in any country and any language (see FAQ below how to translate).

- use on salespages and show multiple review sections, each for one product
<a href="https://www.santegra-international.com/was-mir-bei-kreisrundem-haarausfall-stressbedingt-geholfen-hat/#bewertungen" rel="noopener" target="_blank">See live</a>
Hint: Only one of the multiple WooCommerce reviews shortcodes on a page should be using an Schema.org markup. So google knows what WooCommerce product reviews to view in results
<a href="https://www.google.com/search?q=Das Komplettpaket: Beim Problem kreisrunder Haarausfall (2x PrioriTea 1x Burdock)" rel="noopener" target="_blank">See google results live</a>
- use on landing pages and show reviews only for one product group (in this case the Cleansing Packs)
<a href="https://www.santegra-international.com/parasiten-des-menschen-natuerliche-entwurmung-mensch/#kundenbewertungen" rel="noopener" target="_blank">See live</a>
- use on shop page and show all reviews <a href="https://www.google.com/search?q=santegra+shop" rel="noopener" target="_blank">See google results live</a>
- use on homepage and show all reviews (excluding the Cleansing Packs)
<a href="https://www.google.com/search?q=santegra" rel="noopener" target="_blank">See google results live</a>
- use on homepage and show all reviews in two columns (one show Cleansing Packs and one show non Cleansing Pack reviews)
<a href="https://www.santegra-international.com/#so-bewerten-uns-unsere-kunden" rel="noopener" target="_blank">See customer reviews live on my site</a>

= Automate review collecting? =

You like to auto request reviews, beautifully, easy, with scarcity and with thank you coupons?
<a href="https://checkout.freemius.com/mode/dialog/plugin/5990/plan/9826/" rel="noopener" target="_blank"> See the Get Better Reviews for WooCommerce plugin.</a>

== Installation ==

This section describes how to install the plugin and create and use the WooCommerce reviews shortcode.

1. Download and activate the plugin through the "Plugins" menu in WordPress by searching "ReviewShort"
2. In the left admin menu click on "ReviewShort" and you will be redirected to the "Review Shortcode List"
3. Click "create new" and the WooCommerce shortcode builder's page opens
3. Set your shortcode and preview results
4. Paste shortcode like [wprshrtcd_woo_product_reviews id="83907"] on any page or post content
5. If the style is not showing correctly please go to the bottom of the "shortcode builder's page" click on "Copy template". This will add standard styles to your reviews.
6. Check your ratings stars markup. Details in the FAQ section <a href="https://wordpress.org/plugins/woo-product-reviews-shortcode/#faq" rel="noopener" target="_blank">View FAQ</a>

== Frequently Asked Questions ==

= How can i instantly check if the ratings stars/aggregated rating markup is valid? =

Check your schema.org ratings markup by visting
<a href="https://search.google.com/test/rich-results" rel="noopener" target="_blank"> Google rich snippets tester</a>
<a href="https://validator.schema.org/" rel="noopener" target="_blank">General Schema Markup Validator</a>
Hint: All Warnings are okay and not needed to show the stars and rating details on google. This warnings only say optional data could be provided.
Hint: Only one "product" element should be found, otherwise google does not know what markup to use. In each shortcode you can "disable schema". Please disable all schemas and leave only one active. Idea: Leave the schema with the most reviews enabled.

= How can i duplicate and reuse shortcode settings? =

Go to the "Review Shortcodes List" The duplicate buttons are on the right side of each shortcode.
Benefits: You save a lot of time by duplicate settings to show WooCommerce product reviews shortcode with the same structure and for example only different products.

= I want to get woocommerce reviews by product id and display it in a page =

When you edit a product you get the product ID from the URL, it is the post id.
This id you add to the manual shortcode like this:
[wprshrtcd_woo_product_reviews products_ids="53451,8266" product_title="So bewerten uns unsere Reinigungspaket Kunden:" per_page="5" show_pic_size="shop_single" show_unique_type="reviewer" show_unique_amount="1"]

Easy way is create the shortcode with our WooCommerce reviews shortcodes builder and just copy [wprshrtcd_woo_product_reviews id="83700"] to the place you want to view the reviews.

= Do i need to look at all 11 product review plugins wordpress? =

No, we use and maintain the WooCommerce reviews shortcodes plugin by our self.
So you can be sure you get one of the best and working customer feedback and reviews plugin.

= What is the difference between free and pro version? =
With free version you can create one WooCommerce reviews shortcode with the builder and use unlimited manual shortcodes. Pro Version is 4,99 $ per year. This coffee fee will ensure the maintenance, support and development is at best level.

= How can i translate plugin in my language? =

<a href="https://www.youtube.com/watch?v=Xg1UsyrJeRE" rel="noopener" target="_blank">Add language to WebinarIgnition, Reviewshort, RRatingg, Better Reviews for WooCommerce, ...</a>

= How can i permanently use the new german translation files = 

See the video "Have the latest german translation permanently active - workaround":
<a href="https://www.youtube.com/watch?v=DOPbnMgCEcg" rel="noopener" target="_blank">Video tutorial</a>

= How can I report security bugs? =

You can report security bugs through the Patchstack Vulnerability Disclosure Program. The Patchstack team help validate, triage and handle any security vulnerabilities. [Report a security vulnerability.](https://patchstack.com/database/vdp/woo-product-reviews-shortcode)

== Screenshots ==

1. Multi column support (Any language possible) (free trial and premium)
2. Multi column support (Any language possible) (free trial and premium)
3. Two columns with reviews viewed by two WooCommerce reviews shortcodes
4. Customer feedback with rating stars and description on google search results

== Changelog ==

= 1.01.7 2024.05.06 =

* Freemius SDK update

= 1.01.6 2024.05.06 =

* Security further improved thanks to patchstack and thanks to Vlad and his weekend work
* Still under construction: A faster loading page with lots of reviews, thanks to serving only the image size needed.

= 1.01.5 2024.04.06 =

* Security further improved thanks to patchstack and thanks to Vlad and his weekend work
* Still under construction: A faster loading page with lots of reviews, thanks to serving only the image size needed.

= 1.01.4 2024.02.12 =

* Fix: prevent xss issue, added nonce thanks patchstack

= 1.01.3 2024.02.10 =

* Fix: issue with unauthorized access thanks patchstack

= 1.01.2 2024.02.06 =

* SDK update and great 2024

= 1.01.1 2023.09.28 =

* Added language: russian, italian to existing french, german, spain	
Thanks Andrea for the idea to translate more espacially the string "Average rating".
Plugin can be translated with free loco translate plugin.

= 1.01.0 2023.09.26 =

* New feature: show all product types on select products 
Tipp: Search through products list via your browser with CMD+f or Strg+f
* New feature: Make compatible with new WOO HPOS
* Fix: picture on top for desktop devices working again without the workaround all top.
Benefits now you can mix top and side view.
* Updated Freemius
Benefits: Better handling of opt-in, license, analytics, affiliation, updates, ...
No need to switch to the premium files as all is included in free files.
All that have been to premium can install free version and get updates again.
To get the most of the plugin: We discovered that opt-in to use the plugin is the best.

<a href="https://checkout.freemius.com/mode/dialog/plugin/5990/plan/9826/" rel="noopener" target="_blank"> Make sure you collect a lot of reviews automatically with our Better Reviews plugin:</a>

= 1.0.21 2023.07.14 =

* SDK update

= 1.0.20 2023.03.22 =

= All update please =

= FINAL FREEMIUS SDK UPDATE =

* Fix: Fatal error: Uncaught Error: Call to undefined method Freemius_Api_WordPress::RemoteRequest()
For details see: https://github.com/Freemius/wordpress-sdk/releases/tag/2.5.5
Cause: Other plugin developer use a customized SDK

Background: Freemius handling opt-ins, licenses, analytics, affiliation, ...

= 1.0.18 + 1.0.19 2023.03.17 =

= Freemius SDK update =

* Updated Freemius: for better handling of opt-in, license, analytics, affiliation, updates, ...
* Fix: Freemius activate the premium version when "Sorry, you are not allowed to access this page." shown.
* improving connection
* Stopp connection test on plugin activation
* Create Affiliation inside the plugin is working again
* Please join and earn % on new customer including renewals

Successful, full of descriptive reviews and sustainable 2023

= 1.0.17 2022.03.11 =

* Security fix of a library we use
* Working with the latest WOO

= 1.0.14 - 1.0.16 2021.11.29 =

* Added: Multi column support (Release Candidate, please test output)
https://www.youtube.com/watch?v=tzomk78Xj7U
* Fixed: Author type in schema
* Fixed: Show stars on pages

Roadmap:

* Read more for multi column
* Better multi columns show image on top
* Pagination

= 1.0.13 2021.02.25 =

* Added woo class in preview to fix issue: No stars when woo class is disabled
Benefits stars also showing when using Elementor page builder

= 1.0.12 2021.02.14 =

* Updated to the newest freemius SDK 2.4.2 for a better user experience.
From Freemius: New WordPress SDK Released
WordPress SDK 2.4.2 was just released with some great license activation improvements,...

= 1.0.11 2020.11.16 =

* Tested and was already working with WordPress 5.5 and WooCommerce 4.7
* Added opt-in link in submenu. After opt-in you see your account and can enter your license.
* Updated to the newest freemius SDK 2.4.1 for a better user experience.

= 1.0.10 2020.08.31 =

* Tested and was already working with WordPress 5.5 and WooCommerce 4.4

= 1.0.9 2020.07.20 =

* added hand translated german language files
To use and keep the language files move all 3 files
from /wp-content/plugins/woo-product-reviews-shortcode/languages
to /wp-content/languages/plugins

This behavior will be fix and needs the this workaround.

= 1.0.8 2020.07.19 =
* updated video on page and inside plugin
now showing 90 seconds benefits and how to create shortcodes by using the builder.

= 1.0.7 2020.07.16 =

* updated readme for a better understanding and usability

= 1.0.6 2020.07.16 =

* compatible with WooCommerce 4.3

= 1.0.5 2020.06.08 =

* Removed german translation, because not good yet

= 1.0.4 2020.06.03 =

* Tested and fully compatible with WooCommerce 4.2

= 1.0.1 - 1.0.3 2020.05.26 =

* Duplicate shortcode button
Benefits: Save time when only one setting need to be changed.
Example: You have a landing page for product a and show the reviews there.
On the next landing page click duplicate and change product to b and enter the new shortcode.
* Exit plugin if WooCommerce not installed.
Benefits: To avoid error when install the plugin alone.
* Activate pro version if more better reviews for WooCommerce is in trial version
Benefits: Free use of the pro plugin

= 1.0.0 2020.05.18 =

* first version on WP.org
Benefits: Update through the WP Plugin section
* If you can not auto update to version 1.x and you have a Version below 1.0.0,
delete and install plugin again to get the right folder slug "woo-product-reviews-shortcode" and updates through WP backend.

= 0.9.7 2020.05.06 =

* usability improved: You are now warned when title is empty and schema is enabled.
Benefits: Your schema is valid.

= 0.9.6 2019.10.18 =

* initial internal release
