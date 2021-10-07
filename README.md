# Magento 2 Simple Log

Easily add logs anywhere in the code (like Magento 1).

## Requirements

Requires Magento 2 in any version.

## Installation

Add the ```log.php``` file in  the```app/code``` directory.

## Description

```
\Log::add(
    mixed $message,
    int $level = 6,
    ?string $fileName = null
)
```

## Parameters

* **message:** the data to log (any type)
* **level:** the error level from 0 to 7
* **fileName:** the log file name in the ```var/log``` directory, *app.log* if null

## Return Values

The method returns the number of bytes that were written to the log file (0 on failure).

## Examples

```php
\Log::add('Hello World!');

\Log::add('Panic!', \Log::ERR);

\Log::add([1, 2, 3], \Log::DEBUG);

try {
    throw new \Exception('Error message');
} catch (\Exception $exception) {
    \Log::add($exception, \Log::ERR);
}

\Log::add('This is a debug', \Log::DEBUG, 'custom_debug.log');
```

## Results

**app.log**

```
2021-10-07 14:55:01 | INFO       | Hello World!
2021-10-07 14:55:02 | ERROR      | Panic!
2021-10-07 14:55:03 | DEBUG      | Array
(
    [0] => 1
    [1] => 2
    [2] => 3
)
2021-10-07 14:36:05 | ERROR       | Error message
#0 /var/www/magento2/pub/index.php(35): Magento\Framework\App\Bootstrap->run()
#1 {main}
```

**custom_debug.log**

```
2021-10-07 14:55:04 | DEBUG      | This is a debug
```