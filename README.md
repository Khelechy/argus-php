# ARGUS PHP Client 

This is the official PHP library for the [ARGUS Engine](https://github.com/Khelechy/argus), this library helps PHP developers and applications seamlessly integrate to the ARGUS Engine, authentication and event listening.

### Install via Composer

```sh
    composer require khelechy/argus-php
```

### Usage -

```php

   <?php

   use Khelechy\Argus\Argus;
```

Have a class to define the fucntion to be called when you receive an Argus Event

```php
    <?php

    class TestSub{

        public function subscribeToArgus($argusData){
            echo $argusData->Action . "\n";
            echo $argusData->ActionDescription . "\n";
            echo $argusData->Name . "\n";
            echo $argusData->Timestamp . "\n";
        }
    }
```

Finally use argus like so,

```php

    $sub = new TestSub();

    $argus = new Argus("testuser", "testpassword"); // Optionally you can pass the host and port, and auth credentials inclusive.

    $argus->subscribe($sub, 'subscribeToArgus');

    $argus->connect();
```
