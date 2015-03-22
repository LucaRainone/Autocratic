# Autocratic - Things following my rules

- 

## A Simple Example

```php
<?php
$get = Get::getInstance();

try {
    $id = $get->get('id', 12)->mustBe(Int::NAME, String::NAME);
    echo "\$id=$id";

}catch (\Autocratic\Validator\Exception $e) {
    echo $e->getMessage();
    exit;
}

```