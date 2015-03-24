# Autocratic - Things following my rules

##How it works

The package may be split in two parts:
- GET/POST management
- Item Validator

The first part is optional. In any case, I recommend to include the AutocraticAutoloader.php file.

### GET/POST

The class Get/Post deals with user input.
They encapsulate the $_GET and $_POST superglobal vars and force you to use the validator system.
Every class is a Singleton. So:

```php
<?php
require 'AutocraticAutoloader.php';

$post = \Autocratic\Post::getInstance();

$post->get('id'); // return an Item Object

$post->get('title','no title'); // return an Item Object with default value "no title"
```
Even if we define a default value, the return value is always an Item Object.

But what's an Item Object?

### Item Object

When an Item is created with a value, this value is encapsulated. 
You can take it back only if you specify what type of var do you expect.

So,

```php

$itemId = new Item(101);

// all these are equivalent
$id = $itemId->mustBe('\Autocratic\Validator\Type\Int');
$id = $itemId->mustBe(\Autocratic\Validator\Type\Int::NAME);
$id = $itemId->mustBe(Int::NAME); // want "use \Autocratic\Validator\Type\Int"
$id = $itemId->mustBe(new Int());

```

If the value is not of the specified type, then the "mustBe" method throws an Exception with useful infos.

Method "mustBe" accept more arguments: it will stop when the first argument match the criteria.
For example:

```php
/*
use ...
*/
try {
    //date string Y-m-d or timestamp?
    $date = $itemId->mustBe(new DateString(), new Int()); 
}catch (\Autocratic\Validator\Exception $e) {
    echo "not valid input date: " . $e->getMessage();
}

```
If you don't want manage exceptions (which has sense in strict webapp like API),
you can add as argument the special type ForcedToNull, that force the value to null.

```php
/*
use ...
*/
//date string Y-m-d or timestamp?
$date = $itemId->mustBe(new DateString(), new Int(), ForcedToNull::NAME);

if(is_null($date)) {
    echo "not valid input date";
}

```

What if the input is an array? (ex: ids[]=1&ids[]=2)

# Special type: ArrayOfInt

Simply, this type check if the value is an array of int.

# Special type: ValidableArray (ItemCollection)

If the value is an array, we have to evaluate every element.
This class encapsulates the array and you must check the type every time.

```php
/*
use ...
*/

$item           = new Item(array("id"=>1, "date"=>"2015-09-01"));
$itemCollection = $item->mustBe(ValidableArray::NAME);

try {
    $id   = $itemCollection['id']->mustBe(Int::NAME);
    $date = $itemCollection['date']->mustBe(DateString::NAME);
}catch (\Autocratic\Validator\Exception $e) {
    echo "not valid input date: " . $e->getMessage();
}


// or equivalent

try {
    $id   = $itemCollection->get('id')->mustBe(Int::NAME);
    $date = $itemCollection->get('date')->mustBe(DateString::NAME);
}catch (\Autocratic\Validator\Exception $e) {
    echo "not valid input date: " . $e->getMessage();
}

// or equivalent

foreach($itemCollection as $key=>$value) {
    if($key === 'id') {
        $id = $value->mustBe(Int::NAME);
    }else if($key === 'date') {
        $date = $value->mustBe(DateString::NAME);
    }
}

```
## A Full Example

```php
<?php

use Autocratic\Validator\Type\DateString;
use Autocratic\Validator\Type\Int;

require 'AutocraticAutoloader.php';

$get = \Autocratic\Get::getInstance();

try {

    $id              = $get->get('id')->mustBe(Int::NAME);
    $inputDate       = $get->get('inputDate'       , '2015-05-05')->mustBe(DateString::NAME);
    $inputFutureDate = $get->get('inputFutureDate' , '2025-05-05')->mustBe(new DateString('now'));
    $inputPastDate   = $get->get('inputPastDate'   , '2012-05-05')->mustBe(new DateString(null,'now'));
    
}catch(\Autocratic\Validator\Exception $e) {

    $exceptionInfo = $e->getInfo();
    
    printf(
        "Warning: `%s` is not a valid type for `%s` field. Types allowed are `%s`",
        $exceptionInfo['value'],
        $get->getLastKey(),
        implode(",",$exceptionInfo['allowedTypes'])
    );
    
    exit;
}

var_dump($id);
var_dump($inputDate);
var_dump($inputFutureDate);
var_dump($inputPastDate);
```

