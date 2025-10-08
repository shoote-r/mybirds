This file is meant to keep track of the followings : 
- Progression 
- Useful resources : links, files, remarks
- anything that might be useful/important to remember


## Developer 
### About inventories 
Useful to be able to distinguish users' inventories (not useful for the users)

### About APP_ENV
Defined .env file by APP_ENV points to overriding .env file, could be prod or test 

### About entities properties 
##### ! **id** property is automatically created by symfony !
*see tp-2 src/Entity/Tag.php



# Database 
- **symfony console doctrine:schema:update** | *modify table scheme without erasing any data* 
- **symfony console doctrine:database:drop** 
- **symfony console doctrine:database:create**
- **symfony console doctrine:schema:create** 	
- **symfony console doctrine:schema:create --dump-sql** | *show SQL code used for database creation* 



*setup databse connection in .env doctrine/doctrine-bundle* 

# TO ADD

### Birds and Garden
Gardens do not show the birds they contain and birds do not show to which garden they belong, though we're supposed to only have one garden so there is something to fix.

