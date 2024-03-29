# Affitto Certificato Push Notification Handler Library


Simple and fast implementation for push notifications handling from [Affitto Certificato](https://www.affittocertificato.it/)

[![Latest Stable Version](https://poser.pugx.org/affittocertificato/pushnotificationhandler/v/stable)](https://packagist.org/packages/affittocertificato/pushnotificationhandler)
[![License](https://poser.pugx.org/affittocertificato/pushnotificationhandler/license)](https://packagist.org/packages/affittocertificato/pushnotificationhandler)



## Basic example

```php

require_once __DIR__.'/../src/NotificationHandler.php';

$handler = new AffittoCertificato\NotificationHandler();

// this call register to a basic event named 'sharingCurriculum'. 
// In other words the method ->onCurriculum(...) is an alias to ->on('sharingCurriculum', ...)
$handler->onCurriculum(function($data){

  // do your logic with $data 
  // code ...
  // code ...
  // code ...
  // code ...
});


// this call register to an event named 'eventname_not_yet_implemented'
$handler->on('eventname_not_yet_implemented', function($data){
  return "You should implement this awesome event... really";
});

// run the push notification handler logic and return results to the AffittoCertificato caller
$handler->run();

// that's it!



```


## What should the callback do?

If a callback wants to inform the caller that something has gone wrong, it **must** throw an Exception with a descriptive note in it

Here's an implementation of a simple logic in onCurriculum event:

```php

$handler->onCurriculum(function($data){

  if (!isset ($data->curriculumLink))
    throw new Exception("Hey! You don't have passed me the link");


  // do some logics with curriculumLink
  // code ...
  // code ...
  // code ...
  // code ...
});



```



The callback function may return a value (not mandatory and in any desidered form [string, object, number, ...]) as further description for action results, if there's one it will be added as "payload" to json response and passed to AffittoCertificato caller.

```php

$handler->onCurriculum(function($data){

    // do your logics
  // code ...
  // code ...
  // code ...
  // code ...

  return "Have a nice day!";


});


```

In this case the caller (Affitto Certificato) will receive the string "Have a nice day!" as a payload from the handler (you). 
This informations will be used as log information and for further debugging activities.

## onCurriculum $data format

The callback onCurriculum receive an object on $data parameter structured as follow:
```php

$data->code; // is the code of rental listing you chose during button creation
$data->curriculumLink; // is the address that link to the tenant's curriculum
$data->userName; // Tenant's full name, such as "John Smith"



```



## Requirements

- PHP >= 5.6

## Installation

The recommended way is to install the lib [through Composer](http://getcomposer.org/).

Simply run `composer require affittocertificato/pushnotificationhandler` for it to be automatically installed and included in your `composer.json`.

Now you can use the autoloader, and you will have access to the library:

```php
require 'vendor/autoload.php';
```


## License

This library is released under the GPL-3.0 license