<?php

namespace App\Enums;

enum Roles: string
{
   case ADMIN = 'Admin';
   case OWNER = 'Owner';
   case STORE = 'Store';
   case CUSTOMER = 'Customer';
   case SUPPLIER = 'Supplier';
}
