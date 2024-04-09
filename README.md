# Timber chain

The php code runner for any PHP project

## Usage

This package is compile into a single `phar` file, you can download it from the release page.

### To run PHP code at current directory:
```bash
php chain.phar "echo 'Hello, World!';"
```

### To run PHP code at a specific directory:
```bash
php chain.phar --target=/path/to/project "echo 'Hello, World!';"
```

### To run with multiple lines of code 
You can pass they as base64 encoded string with `--base64` option:
PHP code:
```php
$name = "Tom";
echo "Hello, $name!";
```
First, you need to encode it to base64:
```text
JG5hbWUgPSAiVG9tIjsNCmVjaG8gIkhlbGxvLCAkbmFtZSEiOw==
```
Then run it, so you don't have to deal with escaping characters:
```bash
php chain.phar --target=/path/to/project --base64 "JG5hbWUgPSAiVG9tIjsNCmVjaG8gIkhlbGxvLCAkbmFtZSEiOw=="
```

## Build

```bash
    composer build
```
