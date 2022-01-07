# Path Case Auth & Order API

This project has been prepared for the PATH Product and Software company for case purposes.

# Table of Contents

 - [ Prerequisistes](#prerequisites)
  - [Installing and Running](#installing-and-running)
   	 - [Docker Install](#docker-install)
   - [Examples](#examples)

# Prerequisites
PHP 7.2.5+ <br>
Composer <br>
Symfony 5.3.*

## Installing and running

Open up your terminal and project directory

    git clone https://github.com/UngratefulRaven/pathcase.git
    
    composer install

   
 


Edit .env add your database to 

    DATABASE_URL="mysql://db_username:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"

In your terminal to create databases and migrations

    php bin/console doctrine:database:create

	php bin/console doctrine:migrations:migrate
    
    php bin/console doctrine:fixtures:load
    
     /*
    Last code will generete 3 random user 
    with different mail and passwords

    Example : 
        Mail : johndoe@abccompany.com
        Password : john123 
    */

**Important** : Password always firstname123



You can import **path-case-insomnia.json** in your home directory file into any API / REST Development Tool you are using.
I personally used [Insomnia](https://insomnia.rest/download)
## Docker Install
After you installed project 

    docker-compose up -d --build


    pathcase_nginx_1 is up-to-date
    pathcase_php_1 is up-to-date
    Creating pathcase_mysql_1 ... done

After you get this message

`docker exec -it  pathcase_php_1 bash`

You can access to our container

## Examples

Example - POST resource: POST **> /api/register**

    {
    	"username":"john@doe.com",
    	"first_name":"John",
    	"last_name":"Doe",
    	"email":"john@doe.com",
    	"password":"test123"
    }
Output :

    {
		"status": 200,
		"success": "User john@doe.com successfully created"
	}


Example - POST resource: POST **> /api/login**

    {
    	"username":"john@doe.com",
    	"password":"test123"
    }
Output : 

    {
	    "token": "yJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJp..."
    }
To get all orders for that user
 GET resource: GET **> /api/orders**

    [
    	{
    		"shippingDate": {
    			"date": "2022-01-06 23:20:35.000000",
    			"timezone_type": 3,
    			"timezone": "Europe\/Moscow"
    		},
    		"orderCode": "DROvDWuK3akQZqFpIRUs",
    		"address": "Maltepe Mah. Güzaltan Sk. No:1\/C Bursa",
    		"quantity": 2,
    		"productId": 123
    	},
    	{
    		"shippingDate": {
    			"date": "2022-01-06 23:38:27.000000",
    			"timezone_type": 3,
    			"timezone": "Europe\/Moscow"
    		},
    		"orderCode": "7C9qHiIFxdD1xhqkeUOM",
    		"address": "Maltepe Mah. Güzaltan Sk. No:1\/C Bursa",
    		"quantity": 2,
    		"productId": 123
    	}
    ]

To create order for logged user - POST resource: POST **> /api/order/create**

    {
		"address":"Deneme Mah Test Sk.",
		"quantity":"4",
		"product_id":"80"
	}
Now your order now succesfully created.
Output :

    {
    	"status": 200,
    	"success": "Order eBGhHKsOzzJ1hrnvebeY successfully created"
    }
If you want to check specific order copy that orderCode from created order
In this scenario, I will use the orderCode we created above.

 POST resource: POST **> /api/order/{orderCode}**

Our post like this `/api/order/eBGhHKsOzzJ1hrnvebeY`
Output :

    {
    	"shippingDate": {
    		"date": "2022-01-06 18:46:40.000000",
    		"timezone_type": 3,
    		"timezone": "Europe\/Moscow"
    	},
    	"orderCode": "eBGhHKsOzzJ1hrnvebeY",
    	"address": "Deneme Mah Test Sk.",
    	"quantity": 4,
    	"productId": 80
    }

  Same goes for the update process
   POST resource: POST **> /api/order/update/{orderCode}**
  Our post like this `/api/order/update/eBGhHKsOzzJ1hrnvebeY`
  **Important :** If the shipping date has not passed, the user can update the order.
Now lets change our address quantity,product_id and address

    {
    	"address":"Test Mah. Deneme Sk. No:1/C Bursa",
    	"quantity":"2",
    	"product_id":"123"
    }

Order updated succesfully. Output :

    {
    	"status": 200,
    	"success": "Order 7C9qHiIFxdD1xhqkeUOM successfully updated"
    }
