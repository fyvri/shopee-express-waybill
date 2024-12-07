# Shopee Express Waybill

[![Donate](https://img.shields.io/badge/donate-saweria-orange.svg)](https://saweria.co/azisalvriyanto)
</br>
[![Latest Stable Version](https://img.shields.io/packagist/v/azis-alvriyanto/shopee-express-waybill.svg)](https://packagist.org/packages/azis-alvriyanto/shopee-express-waybill)
[![PHP from Stable Version](https://img.shields.io/packagist/php-v/azis-alvriyanto/shopee-express-waybill)](https://www.php.net)
[![Static Analysis](https://github.com/fyvri/shopee-express-waybill/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/fyvri/shopee-express-waybill/actions/workflows/static-analysis.yml)
</br>
[![Total Downloads](https://poser.pugx.org/azis-alvriyanto/shopee-express-waybill/downloads)](https://packagist.org/packages/azis-alvriyanto/shopee-express-waybill/stats)
[![License](https://poser.pugx.org/azis-alvriyanto/shopee-express-waybill/license)](https://github.com/fyvri/shopee-express-waybill/blob/HEAD/LICENSE.md)

## Requirements

- [PHP >= 8.1](http://php.net/)
- A cup of coffee :coffee:

## Installation

```bash
composer require azis-alvriyanto/shopee-express-waybill
```

## Usage

```php
use AzisAlvriyanto\ShopeeExpressWaybill\ShopeeExpressWaybill;

// Initialize
$shopeeExpressWaybill = new ShopeeExpressWaybill();

// Example: Check shipping number
$response = $shopeeExpressWaybill->check('SPXID133333333337');

// Output response
if ($response->success) {
    echo "Success: " . $response->message;
    print_r($response->data);
} else {
    echo "Error: " . $response->message;
}
```

## Testing

To run the tests, use PHPUnit. Ensure PHPUnit is installed as a development dependency:

```bash
composer install --dev
composer test
```

## API Documentation

Server API ready to use publicly in
[https://shopee-express-waybill.membasuh.com](https://shopee-express-waybill.membasuh.com)
or you can get postman collection [here](https://documenter.getpostman.com/view/6937269/2sA3s4nAx2).

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

## Credits

- [Kyle Archangel](https://github.com/kylearchangel)
- [Ingin Menjadi Programmer Handal, Namun Enggan Ngoding](https://facebook.com/groups/programmerhandal/)
- [All Contributors](https://github.com/fyvri/shopee-express-waybill/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
