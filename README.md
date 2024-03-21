<div style="text-align: center;">
    <img title="BotAPI Logo" alt="BotAPI Logo" src="https://qph.cf2.quoracdn.net/main-qimg-7de85ed4bb521e0d7cf8be7cf4a3de75-lq">

</div>
<br>
<div style="text-align: center;">
    <img title="Latest Version on Packagist" alt="Latest Version on Packagist" src="https://img.shields.io/packagist/v/telegramsdk/botapi.svg?label=composer&logo=composer">
    <img title="PHP Version" alt="PHP Version" src="https://img.shields.io/packagist/dependency-v/telegramsdk/botapi/php?logo=php">
</div>
<br>


# 🛠 Installation
You can install the package using composer:

```bash
composer require parallel/parallel
```

# ❔ Usage
After installation yoi can use this library using composer:
```php
// require the autoload file of vendor to import the library
require_once __DIR__."/vendor/autoload.php";

// select the class in the name space parallel/parallel
use parallel\parallel\Thread;

// create the new object of Thread class
$thread = new Thread();

// create a function to esecute in background
function function_name(){  }

// you can pass an existing function as parameter or create a new function directly when you call the method start
$thread->start('function_name');
$thread->start(function(){  });

// if you use the method join it will wait the end of the new process created and then it will continue with the code.
$thread->join();

```

# 📝 Testing
There are few tests ready for use in test/ directory
Try some examples:
```bash
# try from example_01 to 03
composer example_N
```


# ⚖️ License
This project is under the [MIT License](https://github.com/LorenzoRizzolo/ParallelPhp/blob/main/LICENSE).