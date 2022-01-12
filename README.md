# catalogrotation
Magento Catalog Rotation Module

Requirements
------------
- PHP >= 8.0

Compatibility
-------------
- Magento >= 2.4;

Installation
-------------
- Just copy/paste the module in your repo

What this module does
-------------
- Lets a merchant introduce a 'catalog rotation' in its inventory: a merchant provides a catalog id to delete to make room
  For new products, and a daemon deletes all products in this category, storing their url in a table in order to avoid
  404 page not found errors. 
- A plugin looks for the old products'stored urls, and redirects to their old parent directory -- if possible

Customisable
-------------
- Added 'brand' in db_schema in case a merchant uses the concept of 'brands' or 'designers' as categories, module can be customised
